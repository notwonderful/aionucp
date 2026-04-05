<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\DonationGateway;
use App\Settings\GatewaySettings;
use App\Settings\PaymentSettings;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

final class CreateDonationRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'gateway' => ['required', 'string', Rule::enum(DonationGateway::class)],
            'amount_toll' => ['required', 'integer', 'min:1'],
        ];
    }

    public function after(
        PaymentSettings $paymentSettings,
        GatewaySettings $gatewaySettings,
    ): array {
        return [
            function (Validator $validator) use ($paymentSettings, $gatewaySettings): void {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                /** @var array{gateway: string, amount_toll: int} $data */
                $data = $validator->validated();

                $gateway = DonationGateway::from($data['gateway']);
                $currency = $gateway->currency();

                if (! $paymentSettings->enabled) {
                    $validator->errors()->add('gateway', __('Donations are currently disabled.'));

                    return;
                }

                if (! $gatewaySettings->isGatewayEnabled($gateway)) {
                    $validator->errors()->add('gateway', __('This payment gateway is currently disabled.'));

                    return;
                }

                $limits = $gatewaySettings->getGatewayLimits($gateway);
                if ($limits === null) {
                    return;
                }

                $amountMoney = $paymentSettings->tollToMoney($data['amount_toll'], $currency);

                if ($amountMoney < $limits['min_amount']) {
                    $validator->errors()->add('amount_toll', __('The minimum payment amount is :amount :currency.', [
                        'amount' => $limits['min_amount'],
                        'currency' => $currency->value,
                    ]));
                }

                if ($amountMoney > $limits['max_amount']) {
                    $validator->errors()->add('amount_toll', __('The maximum payment amount is :amount :currency.', [
                        'amount' => $limits['max_amount'],
                        'currency' => $currency->value,
                    ]));
                }
            },
        ];
    }
}
