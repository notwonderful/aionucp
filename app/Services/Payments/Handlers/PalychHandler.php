<?php

namespace App\Services\Payments\Handlers;

use App\Enums\DonateStatus;
use App\Models\Donate;
use App\Services\Payments\Contracts\PaymentCallbackContract;
use App\Traits\Models\AwardBalanceTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PalychHandler implements PaymentCallbackContract
{
    use AwardBalanceTrait;

    public function handle(Request $request): RedirectResponse
    {
        $method = $request->input('Status');
        $OutSum = $request->input('OutSum');
        $InvId = $request->input('InvId');
        $token = strtoupper(md5($OutSum . ":" . $InvId . ":" . config('services.palych.token')));

        if ($token === $request->SignatureValue) {

            $donate = Donate::findOrFail($request->custom);

            Log::channel('palych')->info("Donate Info: " . print_r($donate, 1));

            if ($method == 'FAIL') {
                $donate->status = DonateStatus::Failure;
                $donate->save();
            }

            if ($method == 'SUCCESS') {
                if ($donate->status == DonateStatus::Pending) {
                    $donate->status = DonateStatus::Success;
                    $donate->save();

                    $this->awardBalance($donate);
                }

                return to_route('donate')->with('status', __('Successful payment!'));
            }
        }

        return back()->with('status', __('Something went wrong!'));
    }
}
