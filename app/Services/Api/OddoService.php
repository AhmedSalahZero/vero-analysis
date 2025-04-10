<?php
namespace App\Services\Api;

use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\Partner;
use App\Models\SupplierInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
		dd($this->getContracts($startDate,$endDate,$companyId));
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
		// dd($invoices);
		
		$companyId = $this->company_id;
		// dd($invoices);
		foreach($invoices as $invoice){
			$invoiceId = $invoice['id'];
			$invoiceDate = $invoice['invoice_date'];
			$invoiceDueDate = $invoice['invoice_date_due'];
			$soNumber = $invoice['invoice_origin']??null;
			$amountTax = $invoice['amount_tax'];
			$vatAmount = $amountTax;
			$invoiceAmount = $invoice['amount_residual'] - $amountTax;
			// if($index == 2){
			// 	dd($invoiceAmount,$invoice['amount_residual'],$amountTax);
			// 	// dd();
			// }
			$withholdAmount = 0 ;
		
			$invoiceNumber = $invoice['name'];
			// $amountTax = $invoice['vat_amount'];
			$oddoPartnerId = $invoice['partner_id'][0];
			$oddoPartnerName = $invoice['partner_id'][1];
			$invoiceCurrency = $invoice['currency_id'][1];
			$isSupplier = $invoice['move_type'] == 'in_invoice';
			$isCustomer = $invoice['move_type'] == 'out_invoice';
			$parentId = Partner::handlePartnerForOdd($oddoPartnerId ,$oddoPartnerName,$isSupplier ,$isCustomer,$companyId  );
			if($isCustomer){
				CustomerInvoice::createForOddo($invoiceId,$parentId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$soNumber,$companyId);
			}elseif($isSupplier){
				SupplierInvoice::createForOddo($invoiceId,$parentId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$soNumber,$companyId);
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
			$currentProjectStartDate = $projectArr['date_start'] ?? now()->format('Y-m-d') ;
			$currentProjectEndDate = $projectArr['date'] ?? now()->format('Y-m-d') ;
			$currentOddoProjectId = $projectArr['id'];
			$currentOddoCustomerId = $projectArr['partner_id'][0] ;
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
				$projectFormatted['salesOrders']=$salesOrderFormatted;
				// dd($projectFormatted);
				
				$contract = new Contract ;
		
				$request = (new Request())->merge($projectFormatted);
				$contract->storeBasicForm($request);
				dd('good');
				// dd('good');
		}

		
		
		// dd($salesOrders);
		
	}
	protected function getInvoices(string $startDate,string $endDate)
	{
		$fields = $this->getInvoicesFieldNames();
		$filter = array(array(array('move_type', 'in', ['in_invoice','out_invoice']),array('state', '=', 'posted'),
			array('date', '>=', $startDate),
			array('date', '<=', $endDate)
			// ,['name','=','Inv7']
		));
		$ids=$this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move', 'search',$filter, );
	// dd($this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move', 'read', array($ids),[
	// 	// 'fields'=>$fields
	// ]));
		return $this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move', 'read', array($ids),[
			'fields'=>$fields
		]);
	}
	protected function getUser(array $ids){
		 $user = $this->models->execute_kw($this->db, $this->uid, $this->password, 'res.partner', 'read', array($ids));
		 return $user;
	}
	protected function getInvoicesFieldNames():array 
	{
		// return [];
		return [
			'partner_id',
			'id',
			'invoice_date',
			'name',
			'move_type',
			'currency_id',
		//	'amount_untaxed', // invoice_amount
			'amount_residual',
			'amount_total_signed',
			'amount_tax',
			'invoice_date_due',
			'date',
			'invoice_origin' // so_number
		];
	}
	
	public function payInvoice(int $invoiceId, float $invoiceAmount , string $paymentDate , string $userComment  ,int $oddoPartnerId)
{
   
	$userId = $this->uid;
	if(is_null($this->uid)){
		return ;
	}
    // $partnerId = $oddoPartnerId;
    // if (!$partnerId) {
    //     $partnerResp = Http::post("$this->url/jsonrpc", [
    //         'jsonrpc' => '2.0',
    //         'method' => 'call',
    //         'params' => [
    //             'service' => 'object',
    //             'method' => 'execute_kw',
    //             'args' => [
    //                 $this->db,
    //                 $userId,
    //                 $this->password,
    //                 'res.users',
    //                 'read',
    //                 [$userId],
    //                 ['fields' => ['partner_id']]
    //             ]
    //         ]
    //     ]);

    //     if ($partnerResp->failed()) {
    //         Log::error('Failed to fetch partner_id for current user', [
    //             'status' => $partnerResp->status(),
    //             'body' => $partnerResp->body(),
    //         ]);
    //         return response()->json(['error' => 'Failed to determine partner'], 500);
    //     }

    //     $partnerId = $partnerResp['result'][0]['partner_id'][0] ?? null;
    //     if (!$partnerId) {
    //         Log::critical('Partner ID not found for user', ['user_id' => $userId]);
    //         return response()->json(['error' => 'No partner associated with user'], 500);
    //     }
    // }

    // Http::post("$this->url/jsonrpc", [
    //     'jsonrpc' => '2.0',
    //     'method' => 'call',
    //     'params' => [
    //         'service' => 'object',
    //         'method' => 'execute_kw',
    //         'args' => [
    //             $this->db,
    //             $userId,
    //             $this->password,
    //             'res.partner',
    //             'write',
    //             [[$partnerId], ['customer_rank' => 1]]
    //         ]
    //     ]
    // ]);

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

    // Log::debug('Sending payment creation request to Odoo', ['payload' => $paymentData]);

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
	// dd($paymentId);
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


}
