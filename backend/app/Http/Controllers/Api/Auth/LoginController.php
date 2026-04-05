<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\VerifyTwoFactorCode;
use App\Contracts\GameServerContract;
use App\Enums\TwoFactorMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerifyTwoFactorRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

final class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request, GameServerContract $gameServer, VerifyTwoFactorCode $verifyTwoFactorCode): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();
        assert($user instanceof User);

        if ($user->hasTwoFactorEnabled()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $token = $this->generateTwoFactorToken($user);

            if ($user->twoFactorAuthentication->method === TwoFactorMethod::EMAIL) {
                $verifyTwoFactorCode->sendEmailCodeForLogin($user);
            }

            return response()->json([
                'requires_2fa' => true,
                'two_factor_token' => $token,
                'method' => $user->twoFactorAuthentication->method,
            ]);
        }

        $request->session()->regenerate();

        $user->setAttribute('balance', $gameServer->getBalance($user->aion_acc_id));

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function verifyTwoFactor(VerifyTwoFactorRequest $request, VerifyTwoFactorCode $verifyTwoFactorCode, GameServerContract $gameServer): JsonResponse
    {
        $userId = $this->validateTwoFactorToken($request->input('two_factor_token'));

        $user = User::findOrFail($userId);

        $verifyTwoFactorCode->execute($user, $request->validated('code'));

        Cache::forget("2fa_token:{$userId}");

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $user->setAttribute('balance', $gameServer->getBalance($user->aion_acc_id));

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(status: 204);
    }

    private function generateTwoFactorToken(User $user): string
    {
        $token = URL::signedRoute('2fa.verify', ['user' => $user->id], now()->addMinutes(10));

        Cache::put("2fa_token:{$user->id}", true, now()->addMinutes(10));

        return $token;
    }

    /** @throws ValidationException */
    private function validateTwoFactorToken(?string $token): int
    {
        if ($token === null || ! URL::hasValidSignature(Request::create($token))) {
            throw ValidationException::withMessages([
                'two_factor_token' => [__('The two-factor token is invalid or has expired.')],
            ]);
        }

        parse_str(parse_url($token, PHP_URL_QUERY) ?? '', $params);
        $userId = (int) ($params['user'] ?? 0);

        if (! Cache::has("2fa_token:{$userId}")) {
            throw ValidationException::withMessages([
                'two_factor_token' => [__('The two-factor token is invalid or has expired.')],
            ]);
        }

        return $userId;
    }
}
