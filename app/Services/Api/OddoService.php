<?php
namespace App\Services\Api;

use App\Models\Contract;
use App\Models\CustomerInvoice;
use App\Models\Partner;
use App\Models\SupplierInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
	 * * import invoices
	 */
	public function startImport($startDate , $endDate):void
	{
		if(is_null($this->uid)){
			return ;
		}
		$invoices = $this->getInvoices($startDate,$endDate);
		
		$companyId = $this->company_id;
		
		foreach($invoices as $invoice){
			$invoiceId = $invoice['id'];
			$invoiceDate = $invoice['invoice_date'];
			$invoiceDueDate = $invoice['invoice_date_due'];
			$amountTax = $invoice['amount_tax'];
			$vatAmount = $amountTax;
			$invoiceAmount = $invoice['amount_residual'] - $amountTax;
			$withholdAmount = 0 ;
		
			$invoiceNumber = $invoice['name'];
			$oddoPartnerId = $invoice['partner_id'][0];
			$oddoPartnerName = $invoice['partner_id'][1];
			$invoiceCurrency = $invoice['currency_id'][1];
			$isSupplier = $invoice['move_type'] == 'in_invoice';
			$isCustomer = $invoice['move_type'] == 'out_invoice';
			$parentId = Partner::handlePartnerForOdd($oddoPartnerId ,$oddoPartnerName,$isSupplier ,$isCustomer,$companyId  );
			
			// Parent::createForPartner();
			// $parentId = $partner->id;
			if($isCustomer){
				CustomerInvoice::createForOddo($invoiceId,$parentId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$companyId);
			}elseif($isSupplier){
				SupplierInvoice::createForOddo($invoiceId,$parentId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$companyId);
			}
	
		}
		
	}
	protected function getContracts(string $startDate ,string $endDate,int $companyId)
	{
		// $models = $this->models->execute_kw(
		// 	$this->db,
		// 	$this->uid,
		// 	$this->password,
		// 	'project.project',
		// 	'search_read',
		// 	[[]], // no filter = get all
		// 	['fields' => ['model', 'name']]
		// );
		// dd($models);
		// $fields = $this->getInvoicesFieldNames();
		$contractFilters = array(array(array('id', '>=', 0)));
		$contractIds=$this->models->execute_kw($this->db, $this->uid, $this->password, 'project.project', 'search',$contractFilters
		// , array('limit' => 10)
	);
		$projects = $this->models->execute_kw($this->db, $this->uid, $this->password, 'project.project', 'read', array($contractIds),[
			'fields'=>[
				'id',
				'name',
				'partner_id',
				'date_start', // start date
				'date', //end date
			]
		]);
		$projectsFormatted = [];
		
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
						'so_number'=>$salesOrderArr['display_name'],
						'id'=>$currentSalesOrderId,
						'amount'=>$currentSalesOrderAmount,
						'execution_percentage_'.$currentOrderIndex=>100,
						'start_date_'.$currentOrderIndex=>$currentProjectStartDate,
						'end_date_'.$currentOrderIndex=>$currentProjectEndDate,
						'execution_days_'.$currentOrderIndex=>Carbon::make($currentProjectEndDate)->diffInMonths($currentProjectStartDate),
						'collection_days_'.$currentOrderIndex=>0
						
					];
				}
				$projectFormatted['amount'] = $projectAmount ;
				$projectFormatted['salesOrders']=$salesOrderFormatted;
				dd($projectFormatted);
				$contract = new Contract ;
				$request = (new Request())->merge($projectFormatted);
				$contract->storeBasicForm($request);
				dd('good');
		}

		
		
		// dd($salesOrders);
		
	}
	protected function getInvoices(string $startDate,string $endDate)
	{
		$fields = $this->getInvoicesFieldNames();
		$filter = array(array(array('move_type', 'in', ['in_invoice','out_invoice']),array('state', '=', 'posted'),
		['name','=','Inv6']
		,
		// ,array('date', '=', $importDate)
		array('date', '>=', $startDate),
        array('date', '<=', $endDate)
	));
		$ids=$this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move', 'search',$filter, 
		// array('limit' => 10)
	);
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
			'amount_total',
			'amount_residual',
			'amount_total_signed',
			'amount_tax',
			'invoice_date_due',
			'date',
			'invoice_origin' // so_number
		];
	}
}
