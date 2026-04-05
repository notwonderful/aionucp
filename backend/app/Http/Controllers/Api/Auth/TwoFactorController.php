<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\DisableTwoFactor;
use App\Actions\Auth\EnableTwoFactor;
use App\Actions\Auth\GenerateRecoveryCodes;
use App\Actions\Auth\VerifyTwoFactorSetup;
use App\Enums\TwoFactorMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DisableTwoFactorRequest;
use App\Http\Requests\Auth\SetupTwoFactorRequest;
use App\Http\Requests\Auth\VerifyTwoFactorRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class TwoFactorController extends Controller
{
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $twoFactor = $user->twoFactorAuthentication;

        return response()->json([
            'data' => [
                'enabled' => $twoFactor?->enabled ?? false,
                'method' => $twoFactor?->enabled ? $twoFactor->method : null,
                'verified_at' => $twoFactor?->verified_at,
            ],
        ]);
    }

    public function setup(SetupTwoFactorRequest $request, EnableTwoFactor $enableTwoFactor): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $result = $enableTwoFactor->execute($user, TwoFactorMethod::from($request->validated('method')));

        return response()->json([
            'data' => $result,
            'message' => __('Two-factor authentication setup initiated.'),
        ]);
    }

    public function verify(VerifyTwoFactorRequest $request, VerifyTwoFactorSetup $verifyTwoFactorSetup): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $recoveryCodes = $verifyTwoFactorSetup->execute($user, $request->validated('code'));

        return response()->json([
            'data' => [
                'recovery_codes' => $recoveryCodes,
            ],
            'message' => __('Two-factor authentication has been enabled.'),
        ]);
    }

    public function disable(DisableTwoFactorRequest $request, DisableTwoFactor $disableTwoFactor): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $disableTwoFactor->execute($user, $request->validated('password'));

        return response()->json([
            'message' => __('Two-factor authentication has been disabled.'),
        ]);
    }

    public function recoveryCodes(Request $request, GenerateRecoveryCodes $generateRecoveryCodes): JsonResponse
    {
        $user = $request->user();
        assert($user instanceof User);

        $twoFactor = $user->twoFactorAuthentication;

        if ($twoFactor === null || ! $twoFactor->enabled) {
            return response()->json([
                'message' => __('Two-factor authentication is not enabled.'),
            ], 400);
        }

        $codes = $generateRecoveryCodes->execute();
        $twoFactor->update(['recovery_codes' => $codes]);

        return response()->json([
            'data' => [
                'recovery_codes' => $codes,
            ],
            'message' => __('Recovery codes have been regenerated.'),
        ]);
    }
}
