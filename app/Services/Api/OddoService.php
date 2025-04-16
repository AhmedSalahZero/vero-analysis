<?php
namespace App\Services\Api;

use App\Helpers\HArr;
use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\FinancialInstitutionAccount;
use App\Models\Partner;
use App\Models\SupplierInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use ripcord;

class OddoService
{
	protected string $url ;
	protected String $db;
	protected string $username;
	protected string $password ; 
	protected \Ripcord_Client $models;
	protected ?int $uid;
	protected int $company_id;
	public function __construct($url , $db , $userName , $password,$companyId)
	{
		$this->url = $url;
		$this->db = $db;
		$this->username =$userName;
		$this->password = $password;
		$this->company_id = $companyId ;
		require_once(public_path('apis/ripcord.php'));
		$common = ripcord::client("$this->url/xmlrpc/2/common");
		$uid = null ;
		try{
			$uid = $common->authenticate($this->db, $this->username, $this->password, array());
		}
		catch(\Exception $e){
			$uid = null;
		}
		if(is_array($uid)){
			$uid = null ;
		}
		$models = ripcord::client("$this->url/xmlrpc/2/object");
		$this->models = $models;
		
		$this->uid = $uid;
	}
	/**
	 * * import project or contracts
	 */
	public function startImportContracts(string $startDate, string $endDate,int $companyId)
	{
		if(is_null($this->uid)){
			return ;
		}
		$this->getContracts($startDate,$endDate,$companyId);
	}
	/**
	 * * for test purpose
	 */
	public function test(string $startDate, string $endDate,int $companyId)
	{
		if(is_null($this->uid)){
			return ;
		}
		$tableName ='account.payment.register';
		$contractFilters = array(array(array('id', '>=', 0)));
		$contractIds=$this->models->execute_kw($this->db, $this->uid, $this->password, $tableName, 'search',$contractFilters);
		$projects = $this->models->execute_kw($this->db, $this->uid, $this->password, $tableName, 'read', array($contractIds),[
			'fields'=>[
				
			]
		]);
		dd($projects);
		
	}
	/**
	 * * import invoices
	 */
	public function startImportInvoices($startDate , $endDate):void
	{
		if(is_null($this->uid)){
			return ;
		}
		$invoices = $this->getInvoices($startDate,$endDate);
		dd($invoices);
		$companyId = $this->company_id;
		foreach($invoices as $invoice){
		
			$invoiceId = $invoice['id'];
			$invoiceDate = $invoice['invoice_date'];
			$invoiceDueDate = $invoice['invoice_date_due'];
			$soNumber = $invoice['invoice_origin']??null;
			$exchangeRate = 1/$invoice['invoice_currency_rate'];
			$vatAmount = $invoice['amount_tax'];
			$invoiceAmount = abs($invoice['amount_untaxed_in_currency_signed']);
			$collectedAmount =$invoiceAmount + $vatAmount  - $invoice['amount_residual'] ;
			$withholdAmount = 0 ;
			$invoiceNumber = $invoice['name'];
			$oddoPartnerId = $invoice['partner_id'][0];
			$oddoPartnerName = $invoice['partner_id'][1];
			$invoiceCurrency = $invoice['currency_id'][1];
			$isSupplier = $invoice['move_type'] == 'in_invoice';
			$isCustomer = $invoice['move_type'] == 'out_invoice';
			$parentId = Partner::handlePartnerForOdd($oddoPartnerId ,$oddoPartnerName,$isSupplier ,$isCustomer,$companyId  );
			if($isCustomer){
				CustomerInvoice::createForOddo($invoiceId,$parentId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$collectedAmount,$exchangeRate,$soNumber,$companyId);
			}elseif($isSupplier){
				SupplierInvoice::createForOddo($invoiceId,$parentId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$collectedAmount,$exchangeRate,$soNumber,$companyId);
			}
	
		}
		
	}
	protected function getContracts(string $startDate ,string $endDate,int $companyId)
	{
		
		$contractFilters = array(array(array('id', '>=', 0)));
		$contractIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'project.project', 'search',$contractFilters);
		$projects = $this->models->execute_kw($this->db, $this->uid, $this->password, 'project.project', 'read', array($contractIds),[
			'fields'=>[
				'id',
				'name',
				'partner_id',
				'date_start', // start date
				'date', //end date
			]
		]);
		foreach($projects as $projectArr){
			$projectAmount = 0 ;
			$modelType = 'Customer';
			$currentProjectStartDate = isset($projectArr['date_start']) && $projectArr['date_start'] ? $projectArr['date_start'] :  now()->format('Y-m-d') ;
			$currentProjectEndDate = isset($projectArr['date']) && $projectArr['date'] ? $projectArr['date'] : now()->format('Y-m-d') ;
			$currentOddoProjectId = $projectArr['id'];
			$currentOddoCustomerId = $projectArr['partner_id'][0]??null ;
			if(is_null($currentOddoCustomerId)){
				continue;
			}
			$currentOddoCustomerName = $projectArr['partner_id'][1] ;
			$code = Contract::generateRandomContract($companyId,$currentOddoCustomerName,$startDate,$modelType);
			$parentId = Partner::handlePartnerForOdd($currentOddoCustomerId ,$currentOddoCustomerName,0, 1,$companyId  );
			
			$projectFormatted = [
				'oddo_id'=>$currentOddoProjectId,
				'code'=>$code,
				'name'=>$projectArr['name'],
				'model_type'=>$modelType,
				'partner_id'=>$parentId,
				'start_date'=>$currentProjectStartDate,
				'end_date'=>$currentProjectEndDate,
				'company_id'=>$companyId,
				'duration'=>Carbon::make($currentProjectEndDate)->diffInMonths($currentProjectStartDate)
			];
			
			$salesOrderFilters = array(array(
				['project_id','=',$currentOddoProjectId]
				// ['project_id','in',$contractIds]
			));
				$salesOrderIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'sale.order', 'search',$salesOrderFilters
				// , array('limit' => 10)
			);
				$salesOrders = $this->models->execute_kw($this->db, $this->uid, $this->password, 'sale.order', 'read', array($salesOrderIds),[
					'fields'=>[
						'id',
						'display_name', // so_number
						'currency_id',
						'amount_total',
						'project_id'
					]
				]);
				$salesOrderFormatted = [];
				foreach($salesOrders as $orderIndex => $salesOrderArr){
					$projectFormatted['currency']=$salesOrderArr['currency_id'][1];
					$currentOrderIndex =$orderIndex+1;
					$currentSalesOrderId = $salesOrderArr['id'];
					$currentSalesOrderAmount = $salesOrderArr['amount_total'];
					$projectAmount += $currentSalesOrderAmount;
					$salesOrderFormatted[]=[
						'oddo_id'=>$currentSalesOrderId,
						'so_number'=>$salesOrderArr['display_name'],
						// 'id'=>$currentSalesOrderId,
						'amount'=>$currentSalesOrderAmount,
						'execution_percentage_'.$currentOrderIndex=>100,
						'start_date_'.$currentOrderIndex=>$currentProjectStartDate,
						'end_date_'.$currentOrderIndex=>$currentProjectEndDate,
						'execution_days_'.$currentOrderIndex=>Carbon::make($currentProjectEndDate)->diffInMonths($currentProjectStartDate),
						'collection_days_'.$currentOrderIndex=>0,
						'company_id'=>$companyId
						
					];
				}
				$projectFormatted['amount'] = $projectAmount ;
				// if(!count($salesOrderFormatted)){
					// dd('q',$salesOrderFormatted,$projectAmount);
				// }
				if(count($salesOrderFormatted)){
					$projectFormatted['salesOrders']=$salesOrderFormatted;
					$contract = new Contract ;
					$request = (new Request())->merge($projectFormatted);
					$contract->storeBasicForm($request);
					
				}
				// dd($projectFormatted);
				
				
		}

		
		
		// dd($salesOrders);
		
	}
	protected function getInvoices(string $startDate,string $endDate)
	{
		$fields= [
			'partner_id',
			'id',
			'invoice_date',
			'name',
			'move_type',
			'currency_id',
			'amount_residual',
			'amount_untaxed_in_currency_signed',
			'amount_tax',
			'invoice_date_due',
			'date',
			'invoice_currency_rate',//exchange rate
			'invoice_origin' ,// so_number
			'write_date',
			'state',
			'invoice_line_ids' // product ids 
		];
		$filters = array(array(array('move_type', 'in', ['in_invoice','out_invoice'])
		,array('state', '=', 'posted'),
			array('write_date', '>=', $startDate),
			array('write_date', '<=', $endDate)
			// ,['name','=','INV/2025/00004']
		));
		return $invoices = $this->fetchData('account.move',$fields,$filters);
		$productIds = array_unique(Arr::flatten(array_column($invoices,'invoice_line_ids'))) ;
		$filters = [[
			['id','in',$productIds]
		]];
		$fields = [
			'name','display_name','product_id','quantity','price_unit','price_subtotal'
		];
		dd($this->fetchData('account.move.line',$fields,$filters));
		return ;
		
	}
	protected function getUser(array $ids){
		 $user = $this->models->execute_kw($this->db, $this->uid, $this->password, 'res.partner', 'read', array($ids));
		 return $user;
	}
	
	
	public function payInvoice(int $invoiceId, float $invoiceAmount , string $paymentDate , string $userComment  ,int $oddoPartnerId)
	{
	
		$userId = $this->uid;
		if(is_null($this->uid)){
			return ;
		}
		$paymentData = [
			'payment_type' => 'inbound',
			'partner_type' => 'customer',
			'partner_id' => $oddoPartnerId, 
			'journal_id' => (int) 7,
			'amount' => (float) $invoiceAmount,
			'date' => $paymentDate,
			'payment_method_code' => "manual",
			'payment_method_id' => (int) 1,
			'payment_method_line_id' => (int) 4,
			'memo' => $userComment ?: __('N/A'),
			'invoice_ids' => [[6, 0, [(int) $invoiceId]]],
		];


		$response = Http::post("$this->url/jsonrpc", [
			'jsonrpc' => '2.0',
			'method' => 'call',
			'params' => [
				'service' => 'object',
				'method' => 'execute_kw',
				'args' => [
					$this->db,
					$userId,
					$this->password,
					'account.payment',
					'create',
					[$paymentData]
				]
			]
		]);
		$paymentId = json_decode($response->body())->result ;
		$this->models->execute_kw(
			$this->db,
			$this->uid,
			$this->password,
			'account.payment',
			'action_post', // Method to confirm payment
			[[$paymentId]] // Array of payment IDs
		);
		
		$updatedInvoice = $this->models->execute_kw(
			$this->db,
			$this->uid,
			$this->password,
			'account.move',
			'read',
			[[$invoiceId]],
			['fields' => ['payment_state']]
		);
		
		// dd($paymentId);
		// Step 5: Fetch payment move lines to reconcile
		
		$filter = array(array(
				['payment_id', '=', $paymentId],
				['account_id.type', '=', 'receivable']
				// ,['name','=','Inv7']
			));
			$paymentIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move.line', 'search',$filter );
			$paymentLines = $this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move.line', 'read', array($paymentIds),[
				// 'fields'=>$fields
			]);
			// dd($paymentIds);
			// dd($paymentLines);
			

		// $paymentLines = $this->models->execute_kw(
		// 	$this->db,
		// 	$this->uid,
		// 	$this->password,
		// 	'account.move.line',
		// 	'search_read',
		// 	[['payment_id', '=', $paymentId], ['account_id.type', '=', 'receivable']],
		// 	// ['fields' => ['id']]
		// );
		// dd('f');
		// dd($paymentLines);

		// if (!$paymentLines || empty($paymentLines)) {
		// 	return response()->json(['error' => 'No receivable lines found for payment'], 500);
		// }
		$paymentLineId = $paymentLines[0]['id'];

		// Step 6: Fetch invoice move lines to reconcile
		$invoiceLines = $this->models->execute_kw(
			$this->db,
			$this->uid,
			$this->password,
			'account.move.line',
			'search_read',
			[['move_id', '=', $invoiceId], ['account_id.type', '=', 'receivable']],
			['fields' => ['id']]
		);

		if (!$invoiceLines || empty($invoiceLines)) {
			return response()->json(['error' => 'No receivable lines found for invoice'], 500);
		}
		$invoiceLineId = $invoiceLines[0]['id'];

		// Step 7: Reconcile payment and invoice lines
		$this->models->execute_kw(
			$this->db,
			$this->uid,
			$this->password,
			'account.move.line',
			'reconcile',
			[[$paymentLineId, $invoiceLineId]]
		);

		// Step 8: Verify invoice is paid
		$updatedInvoice = $this->models->execute_kw(
			$this->db,
			$this->uid,
			$this->password,
			'account.move',
			'read',
			[[$invoiceId]],
			['fields' => ['payment_state']]
		);
		
		
		dd($updatedInvoice);
		
		dd($paymentData,$response->failed());
		if ($response->failed()) {
			Log::error('Odoo request failed (payment create)', [
				'status' => $response->status(),
				'body' => $response->body(),
			]);
			return response()->json(['error' => 'Failed to create payment'], 500);
		}

		$paymentId = $response->json()['result'] ?? null;

		if (!$paymentId) {
			return response()->json(['error' => 'Failed to create payment'], 500);
		}

		$postPayment = Http::post("$this->odooUrl/jsonrpc", [
			'jsonrpc' => '2.0',
			'method' => 'call',
			'params' => [
				'service' => 'object',
				'method' => 'execute_kw',
				'args' => [
					$this->odooDb,
					$userId,
					$this->odooPassword,
					'account.payment',
					'action_post',
					[[$paymentId]] 
				]
			]
		]);



		if ($postPayment->failed()) {
			return response()->json(['error' => 'Failed to post payment'], 500);
		}
		return response()->json([
			'message' => 'Payment successful',
			'payment_id' => $paymentId,
		]);    
	}


// public function registerPayment(int $invoiceId,float $amount,string $paymentDate)
//     {
//         $paymentData = [
//             'invoice_id' => $invoiceId,
//             'amount' => $amount,
//             'payment_date' => $paymentDate,
//             'journal_id' => 7,
//             'payment_method_id' => 1, // Manual payment method
//         ];

//         // Authenticate
//         // $uid = $this->authenticate();
//         // if (!$uid) {
//         //     return response()->json(['error' => 'Authentication failed'], 401);
//         // }

//         // Register and reconcile payment
//         $payment = $this->createPayment($this->uid, $invoiceId);

//         return response()->json($payment);
//     }

    // private function authenticate()
    // {
    //     $common = Ripcord::client($this->url . 'common');
    //     $uid = $common->authenticate($this->db, $this->username, $this->password, []);
    //     return $uid;
    // }
	/**
	 * * create payment for test
	 */
    public function createPayment($invoiceId,float $paymentAmount,$paymentDate,int $odooPartnerId)
    {
		
		

            // Step 2: Create a payment
            $paymentData = [
                'partner_type' => 'customer',
                'partner_id' => $odooPartnerId,
                'amount' => $paymentAmount,
                'journal_id' => 7, // for cash
                'payment_type' => 'inbound',
                'date' => $paymentDate,
                // 'ref' => "Payment for invoice {$invoiceNumber}",
                'invoice_ids' => [[6, 0, [$invoiceId]]], // Link to invoice
            ];

            $paymentId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'create',
                [$paymentData]
            );

            if (!$paymentId) {
                return response()->json(['error' => 'Failed to create payment'], 500);
            }

            // Step 3: Post the payment
            $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.payment',
                'action_post',
                [[$paymentId]]
            );

            // Step 4: Reconcile using account.reconcile.wizard
            // Find payment journal items
            $paymentLines = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move.line',
                'search_read',
                [[
                    ['payment_id', '=', $paymentId],
                    ['account_id.reconcile', '=', true],
					['balance', '!=', 0],
                    ['partner_id', '=', $odooPartnerId],
                ]],
                ['fields' => ['id','account_id','balance']]
            );

            // Find invoice journal items
            $invoiceLines = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move.line',
                'search_read',
                [[
                    ['move_id', '=',$invoiceId],
                    ['account_id.reconcile', '=', true],
					['balance', '!=', 0],
                    ['partner_id', '=', $odooPartnerId],
                ]],
                ['fields' => ['id', 'account_id', 'balance']]
            );

            if (empty($paymentLines) || empty($invoiceLines)) {
                return response()->json(['error' => 'No reconcilable lines found'], 500);
            }

            // Create reconciliation wizard
            $reconcileWizardId = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.reconcile.wizard',
                'create',
                [[
                    'line_ids' => [[6, 0, [$paymentLines[0]['id'], $invoiceLines[0]['id']]]],
                    'allow_partials' => true,
					'partner_id' => $odooPartnerId,
                ]]
            );

            // Perform reconciliation
			$this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move.line',
                'reconcile',
                [[]], // Empty IDs list to use write_off_vals
                ['write_off_vals' => [
                    'line_ids' => [[6, 0, [$paymentLines[0]['id'], $invoiceLines[0]['id']]]],
                ]]
            );
			
            // $this->models->execute_kw(
            //     $this->db,
            //     $this->uid,
            //     $this->password,
            //     'account.reconcile.wizard',
            //     'reconcile',
            //     [[$reconcileWizardId]]
            // );
			
			// Step 6: Verify reconciliation
            $invoiceAfter = $this->models->execute_kw(
                $this->db,
                $this->uid,
                $this->password,
                'account.move',
                'read',
                [[$invoiceId]],
                ['fields' => ['payment_state']]
            );
		
			if ($invoiceAfter[0]['payment_state'] !== 'paid') {
                Log::error("Reconciliation failed: payment_state is {$invoiceAfter[0]['payment_state']}");
                return response()->json(['error' => 'Reconciliation failed, invoice not marked as paid'], 500);
            }

            return response()->json(['success' => 'Payment registered and reconciled successfully']);

		
		
    }
	public function syncDeletedInvoices(int $companyId)
	{
		$customerInvoices  = CustomerInvoice::where('company_id',$companyId)->where('oddo_id','>',0)->get();
		$supplierInvoices  = SupplierInvoice::where('company_id',$companyId)->where('oddo_id','>',0)->get();
		
		$startDate = now()->subDays(360)->format('Y-m-d');
		$endDate = now()->format('Y-m-d');
		$deletedIds= [];
		$odooInvoicesIds = array_column($this->getInvoices($startDate,$endDate),'id');
		foreach([$customerInvoices,$supplierInvoices] as $invoices){
			foreach($invoices as $invoice){
				$invoiceOdooId = $invoice->getOdooId();
				if(!in_array($invoiceOdooId,$odooInvoicesIds)){
					$deletedIds[] = [
						'id'=>$invoiceOdooId,
						'type'=>getModelNameWithoutNamespace($invoice)
					];
					$invoice->delete();
				}
			}
			
		}
		dd($deletedIds);
	}
	public function syncFinancialInstitutions(string $financialInstitutionOdooCode)
	{
			$fields = [
				'id',
				'code'
			];
			$filters = [
				[
					['type','=','bank'
				],
				// ['code','=',$financialInstitutionOdooCode]
				]
		];
		$journals = $this->fetchData('account.journal',$fields,$filters);
		$journals = collect($journals)->keyBy('code')->toArray();
			$financialInstitutionAccounts = FinancialInstitutionAccount::where('company_id',$this->company_id)->whereNotNull('odoo_code')->get();

			foreach($financialInstitutionAccounts as $financialInstitutionAccount){
				$codeCode = $financialInstitutionAccount->getOdooCode();
				if($codeCode){
		
					$currentJournal = $journals[$codeCode]??null;
					$currentJournalId = $currentJournal ? $currentJournal['id'] : null;
					if($currentJournalId){
						$financialInstitutionAccount->update([
							'odoo_id'=>$currentJournalId
						]);
					}
					
				}
			}
			
			
		
		dd($journals);
	
		
	}
	protected function fetchData(string $modelName ,array $fields = [],  array $filters = [[]]  )
	{
		$ids=$this->models->execute_kw($this->db, $this->uid, $this->password, $modelName, 'search',$filters );
		return $this->models->execute_kw($this->db, $this->uid, $this->password, $modelName, 'read', array($ids),[
			'fields'=>$fields
		]);
	}
	
	


}
