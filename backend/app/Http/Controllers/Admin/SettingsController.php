<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\AnnouncementSettings;
use App\Settings\DownloadSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SettingsController extends Controller
{
    public function downloadShow(DownloadSettings $settings): JsonResponse
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

    public function downloadUpdate(Request $request, DownloadSettings $settings): JsonResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'max:500'],
            'file_size' => ['required', 'string', 'max:50'],
            'discord_url' => ['required', 'string', 'max:500'],
            'min_requirements' => ['required', 'array'],
            'min_requirements.*.label' => ['required', 'string', 'max:50'],
            'min_requirements.*.value' => ['required', 'string', 'max:100'],
            'rec_requirements' => ['required', 'array'],
            'rec_requirements.*.label' => ['required', 'string', 'max:50'],
            'rec_requirements.*.value' => ['required', 'string', 'max:100'],
        ]);

        $settings->url = $validated['url'];
        $settings->file_size = $validated['file_size'];
        $settings->discord_url = $validated['discord_url'];
        $settings->min_requirements = $validated['min_requirements'];
        $settings->rec_requirements = $validated['rec_requirements'];
        $settings->save();

        return response()->json([
            'data' => $validated,
            'message' => __('Download settings updated successfully!'),
        ]);
    }

    public function announcementShow(AnnouncementSettings $settings): JsonResponse
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

    public function announcementUpdate(Request $request, AnnouncementSettings $settings): JsonResponse
    {
        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
            'text' => ['required', 'string', 'max:500'],
            'link_text' => ['required', 'string', 'max:100'],
            'link_url' => ['required', 'string', 'max:500'],
        ]);

        $settings->enabled = $validated['enabled'];
        $settings->text = $validated['text'];
        $settings->link_text = $validated['link_text'];
        $settings->link_url = $validated['link_url'];
        $settings->save();

        return response()->json([
            'data' => $validated,
            'message' => __('Announcement settings updated successfully!'),
        ]);
    }
}
