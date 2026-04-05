<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Settings\AnnouncementSettings;
use App\Settings\DownloadSettings;
use Illuminate\Http\JsonResponse;

final class SettingsController extends Controller
{
    public function download(DownloadSettings $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'url' => $settings->url,
                'file_size' => $settings->file_size,
                'discord_url' => $settings->discord_url,
                'min_requirements' => $settings->min_requirements,
                'rec_requirements' => $settings->rec_requirements,
            ],
        ]);
    }

    public function announcement(AnnouncementSettings $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'enabled' => $settings->enabled,
                'text' => $settings->text,
                'link_text' => $settings->link_text,
                'link_url' => $settings->link_url,
            ],
        ]);
    }
}
