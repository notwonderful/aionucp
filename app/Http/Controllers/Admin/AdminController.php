<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class AdminController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'total_users' => User::count(),
        ]);
    }
}
