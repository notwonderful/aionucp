<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Contracts\PaymentGateway;
use App\DataTransferObjects\PaymentResult;
use App\DataTransferObjects\PaymentVerification;
use App\DataTransferObjects\WebhookResult;
use App\Enums\Currency;
use App\Exceptions\InvalidWebhookSignatureException;
use App\Models\Donation;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use Stripe\Webhook;

final class StripeGateway implements PaymentGateway
{
    private ?StripeClient $stripe = null;

    private function client(): StripeClient
    {
        if ($this->stripe === null) {
            $secret = config('services.stripe.secret');

            if (! is_string($secret) || $secret === '') {
                throw new \RuntimeException('Stripe secret key is not configured.');
            }

            $this->stripe = new StripeClient($secret);
        }

        return $this->stripe;
    }

    public function createPayment(Donation $donation, string $successUrl, string $cancelUrl): PaymentResult
    {
        $session = $this->client()->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($donation->currency->value),
                    'product_data' => [
                        'name' => "Donation #{$donation->id} - {$donation->amount_toll} Toll",
                    ],
                    'unit_amount' => $donation->amount_money,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'donation_id' => $donation->id,
            ],
        ]);

        return new PaymentResult(
            redirectUrl: $session->url ?? '',
            gatewayTransactionId: $session->payment_intent ?? $session->id,
        );
    }

    public function verifyWebhook(Request $request): WebhookResult
    {
        /** @var string $webhookSecret */
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature', ''),
                $webhookSecret,
                300,
            );
        } catch (SignatureVerificationException) {
            throw new InvalidWebhookSignatureException;
        }

        /** @var Session $session */
        $session = $event->data->object;

        /** @var int $donationId */
        $donationId = (int) ($session->metadata['donation_id'] ?? 0);

        return new WebhookResult(
            success: $event->type === 'checkout.session.completed' && $session->payment_status === 'paid',
            donationId: $donationId,
            gatewayTransactionId: $session->payment_intent ?? $session->id,
            eventId: $event->id,
        );
    }

    public function verifyPayment(string $gatewayTransactionId): PaymentVerification
    {
        $paymentIntent = $this->client()->paymentIntents->retrieve($gatewayTransactionId);

        return new PaymentVerification(
            paid: $paymentIntent->status === PaymentIntent::STATUS_SUCCEEDED,
            amount: $paymentIntent->amount_received,
            currency: Currency::from(strtoupper($paymentIntent->currency)),
            status: $paymentIntent->status,
        );
    }
}
