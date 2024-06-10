<?php 
class Order extends Model
{
    protected $table = 'order';

    

     public function validateOrderStatusUpdate($paymentMethod, $paymentStatus, $newStatusString)
    {
        // Convert values to uppercase
        $paymentMethod = strtoupper($paymentMethod);
        $paymentStatus = strtoupper($paymentStatus);

        // Define disallowed methods in uppercase
        $disallowedMethods = ["GCASH", "PAYPAL", "CREDIT CARD"];

        // Check if the payment status is "UNPAID" and the payment method is disallowed
        if ($paymentStatus === "UNPAID" && in_array($paymentMethod, $disallowedMethods)) {
            return ['success' => false, 'message' => 'You cannot change the order status if the payment status is "Unpaid" and the payment method is "Gcash", "Paypal", or any credit card.'];
        }

        return ['success' => true, 'message' => ''];
    }
    
}