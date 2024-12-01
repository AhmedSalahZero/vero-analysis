<?php
namespace App\Services\Api;

use App\Models\CustomerInvoice;
use App\Models\Partner;
use App\Models\SupplierInvoice;
use ripcord;

class OddoService
{
	protected string $url ;
	protected String $db;
	protected string $username;
	protected string $password ; 
	protected \Ripcord_Client $models;
	protected int $uid;
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
		$uid = $common->authenticate($this->db, $this->username, $this->password, array());
		$models = ripcord::client("$this->url/xmlrpc/2/object");
		$this->models = $models;
		$this->uid = $uid;
	}
	public function startImport($importDate):void
	{
		
		$invoices = $this->getInvoices($importDate);
	
		foreach($invoices as $invoice){
			$invoiceId = $invoice['id'];
			$invoiceDate = $invoice['invoice_date'];
			$invoiceDueDate = $invoice['invoice_date_due'];
			$amountTax = $invoice['amount_tax'];
			$vatAmount = $amountTax;
			$invoiceAmount = $invoice['amount_residual'] - $amountTax;
			$withholdAmount = 0 ;
			$companyId = $this->company_id;
			$invoiceNumber = $invoice['name'];
			$oddoPartnerId = $invoice['partner_id'][0];
			$oddoPartnerName = $invoice['partner_id'][1];
			$invoiceCurrency = $invoice['currency_id'][1];
			$isSupplier = $invoice['move_type'] == 'in_invoice';
			$isCustomer = $invoice['move_type'] == 'out_invoice';
			
			$partner = Partner::findByOddoId($oddoPartnerId);
			if(is_null($partner)){
				$partner = Partner::createNewForOddo($oddoPartnerId,$oddoPartnerName,$companyId,$isCustomer,$isSupplier);
			}
			if($isCustomer){
				CustomerInvoice::createForOddo($invoiceId,$oddoPartnerId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$companyId);
			}elseif($isSupplier){
				SupplierInvoice::createForOddo($invoiceId,$oddoPartnerId,$oddoPartnerName,$invoiceDate,$invoiceDueDate,$invoiceNumber,$invoiceCurrency,$invoiceAmount,$vatAmount,$withholdAmount,$companyId);
			}
	
		}
		
	}
	protected function getInvoices($importDate)
	{
		$fields = $this->getInvoicesFieldNames();
		$filter = array(array(array('move_type', 'in', ['in_invoice','out_invoice']),array('state', '=', 'posted'),array('date', '=', $importDate)));
		$ids=$this->models->execute_kw($this->db, $this->uid, $this->password, 'account.move', 'search',$filter, array('limit' => 10));
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
			'date'
		];
	}
}
