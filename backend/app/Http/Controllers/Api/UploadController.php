<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UploadController extends Controller
{
    public function image(Request $request, ImageUploadService $imageUpload): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        $url = $imageUpload->upload($request->file('image'));

        return response()->json(['url' => $url]);
    }
}
