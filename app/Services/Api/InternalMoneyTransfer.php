<?php 
namespace App\Services\Api;

use App\OdooSetting;
use App\Services\Api\Traits\AuthTrait;
use App\Services\Api\Traits\HasPayment;

class InternalMoneyTransfer
{
	
	use AuthTrait,HasPayment;

	
	 public function processOutboundPayment(string $date,int $outJournalId,float $amount,int $odooCurrencyId)
    {
        // try {
            // Create payment
            $paymentId = $this->createPayment('outbound',$outJournalId,$date, $amount, $odooCurrencyId);

            // Example: Update payment if needed
            $updateData = [
                // Add any fields that need updating, e.g.:
                // 'amount' => 2500,
                // 'date' => '2025-05-22',
            ];

            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            // Post payment
            $this->postPayment($paymentId);

            // Assuming MoneyModel is your Laravel model
            // MoneyModel::update(['odoo_id' => $paymentId]);
			return $paymentId;
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Payment registered and posted successfully',
            //     'payment_id' => $paymentId
            // ]);
        // } catch (Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Payment processing failed: ' . $e->getMessage()
        //     ], 500);
        // }
    }
	
	public function processInboundPayment(string $date , int $inboundJournalId , float $amount ,int $odooCurrencyId)
    {
            // Create payment
            $paymentId = $this->createPayment('inbound',$inboundJournalId,$date  , $amount , $odooCurrencyId);
            // Example: Update payment if needed
            $updateData = [
                // Add any fields that need updating, e.g.:
                // 'amount' => 2500,
                // 'date' => '2025-05-22',
            ];

            if (!empty($updateData)) {
                $this->setPaymentToDraft($paymentId);
                $this->updatePayment($paymentId, $updateData);
            }

            // Post payment
            $this->postPayment($paymentId);

            // Assuming MoneyModel is your Laravel model
            // MoneyModel::update(['odoo_id' => $paymentId]);
			return $paymentId;
            
        
    }
	public function cancelMoneyTransferPayment(int $paymentId)
    {
        return $this->cancelPayments($paymentId);
    }
	
    

    

   

   

    

    
	

   



    
	
}
?>
