<?php

namespace App\Http\Controllers\Api;

use App\Enums\DonateStatus;
use App\Http\Controllers\Controller;
use App\Models\Donate;
use App\Models\Game\AccountData;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class DonateController extends Controller
{
    public function handlePaymentCallback(Request $request)
    {
        try {
            $this->validateRequest($request);

            Log::channel('palych')->info('Handling payment callback', $request->all());

            $donate = Donate::findOrFail($request->input('custom'));

            if ($this->isPaymentSuccessful($request, $donate)) {
                $this->processSuccessfulPayment($donate);

                return response()->json(['message' => 'OK']);
            }

            return response()->json(['message' => 'Payment failed'], 400);
        } catch (Exception $e) {

            Log::channel('palych')->error('Error processing payment', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        $validationRules = [
            'InvId' => 'required|exists:donates,id',
            'OutSum' => 'required|numeric',
            'SignatureValue' => 'required',
            'custom' => 'required|integer',
        ];

        $request->validate($validationRules);
    }

    /**
     * @throws Exception
     */
    private function isPaymentSuccessful(Request $request, Donate $donate): bool
    {
        if ($request->input('Status') !== 'SUCCESS') {
            return false;
        }

        $checkSign = strtoupper(md5($request->input('OutSum') . ':' . $request->input('InvId') . ':' . config('services.palych.token')));

        if ($checkSign !== $request->input('SignatureValue')) {
            throw new Exception('Digital signature does not match');
        }

        if ($donate->status === DonateStatus::Success) {
            throw new Exception('Payment has already been processed');
        }

        return true;
    }

    private function processSuccessfulPayment(Donate $donate): void
    {
        $donate->update(['status' => DonateStatus::Success]);

        $user = User::find($donate->user_id);

        $accountData = AccountData::query()->where('id', $user->aion_acc_id)->select('toll');

        $accountData->increment('toll', $donate->amount);
    }
}
