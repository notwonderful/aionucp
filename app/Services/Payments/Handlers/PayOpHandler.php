<?php

namespace App\Services\Payments\Handlers;

use App\Enums\DonateStatus;
use App\Models\Donate;
use App\Services\Payments\Contracts\PaymentCallbackContract;
use App\Services\Payments\Gateways\PayOp\PayOpAdapter;
use App\Traits\Models\AwardBalanceTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayOpHandler implements PaymentCallbackContract
{
    use AwardBalanceTrait;

    public function handle(Request $request): RedirectResponse
    {
        $apiClient = PayOpAdapter::makeApiClient();
        $result = $apiClient->paymentHandler();

        Log::channel('payop')->info("PayOP PaymentHandler: " . json_encode($request->all(), JSON_PRETTY_PRINT));

        if (! isset($result['invoice']) || ! isset($result['invoice']['status']) || $result['invoice']['status'] != DonateStatus::Success) {
            return back()->with('status', __('Wrong status'));
        }

        $order_id = $result['transaction']['order']['id'] ?? 0;
        $donate = Donate::findOrFail($order_id);

        Log::channel('payop')->info('PayOP Donate info:'.print_r($donate, 1));

        if($donate->status === DonateStatus::Pending) {
            $donate->status = DonateStatus::Success;
            $donate->save();

            $this->awardBalance($donate);
        }

        return to_route('donate')->with('status', __('Successful payment!'));
    }
}
