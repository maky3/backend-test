<?php

namespace App\Service\PaymentProcessorService;

use AllowDynamicProperties;
use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

/**
 * @property PaypalPaymentProcessor $paypalPaymentProcessor
 */
#[AllowDynamicProperties] class PaymentProcessorService
{
    private PaypalPaymentProcessor $paypalProcessor;

    private StripePaymentProcessor $stripePaymentProcessor;

    public function __construct(PaypalPaymentProcessor $paypalPaymentProcessor, StripePaymentProcessor $stripePaymentProcessor)
    {
        $this->stripeProcessor = $stripePaymentProcessor;
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
    }

    /**
     * @param string $paymentProcessor
     * @param float $amount
     * @return bool
     * @throws Exception
     */
    public function processPayment(string $paymentProcessor, float $amount): bool
    {
        if ($paymentProcessor === 'paypal') {
            return $this->paypalProcessor->pay($amount);
        } elseif ($paymentProcessor === 'stripe') {
            return $this->stripeProcessor->processPayment($amount);
        } else {
            throw new Exception('Invalid payment processor');
        }
    }
}