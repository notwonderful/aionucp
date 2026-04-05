<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Settings\AnnouncementSettings;
use App\Settings\DownloadSettings;
use App\Settings\GatewaySettings;
use App\Settings\PaymentSettings;
use App\Settings\TeleportSettings;
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

    public function paymentShow(PaymentSettings $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'enabled' => $settings->enabled,
                'rate_rub' => $settings->rate_rub,
                'rate_usd' => $settings->rate_usd,
                'rate_eur' => $settings->rate_eur,
            ],
        ]);
    }

    public function paymentUpdate(Request $request, PaymentSettings $settings): JsonResponse
    {
        $validated = $request->validate([
            'enabled' => ['required', 'boolean'],
            'rate_rub' => ['required', 'numeric', 'min:0'],
            'rate_usd' => ['required', 'numeric', 'min:0'],
            'rate_eur' => ['required', 'numeric', 'min:0'],
        ]);

        $settings->enabled = $validated['enabled'];
        $settings->rate_rub = (float) $validated['rate_rub'];
        $settings->rate_usd = (float) $validated['rate_usd'];
        $settings->rate_eur = (float) $validated['rate_eur'];
        $settings->save();

        return response()->json([
            'data' => $validated,
            'message' => __('Payment settings updated successfully!'),
        ]);
    }

    public function gatewayShow(GatewaySettings $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'limits' => $settings->limits,
            ],
        ]);
    }

    public function gatewayUpdate(Request $request, GatewaySettings $settings): JsonResponse
    {
        $validated = $request->validate([
            'limits' => ['required', 'array'],
            'limits.*.min_amount' => ['required', 'numeric', 'min:0'],
            'limits.*.max_amount' => ['required', 'numeric', 'min:0'],
            'limits.*.currency' => ['required', 'string', 'max:3'],
            'limits.*.enabled' => ['required', 'boolean'],
        ]);

        $settings->limits = $validated['limits'];
        $settings->save();

        return response()->json([
            'data' => $validated,
            'message' => __('Gateway settings updated successfully!'),
        ]);
    }

    public function teleportShow(TeleportSettings $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'elyos_x' => $settings->elyos_x,
                'elyos_y' => $settings->elyos_y,
                'elyos_z' => $settings->elyos_z,
                'elyos_map' => $settings->elyos_map,
                'asmodians_x' => $settings->asmodians_x,
                'asmodians_y' => $settings->asmodians_y,
                'asmodians_z' => $settings->asmodians_z,
                'asmodians_map' => $settings->asmodians_map,
                'cooldown_minutes' => $settings->cooldown_minutes,
            ],
        ]);
    }

    public function teleportUpdate(Request $request, TeleportSettings $settings): JsonResponse
    {
        $validated = $request->validate([
            'elyos_x' => ['required', 'numeric'],
            'elyos_y' => ['required', 'numeric'],
            'elyos_z' => ['required', 'numeric'],
            'elyos_map' => ['required', 'integer'],
            'asmodians_x' => ['required', 'numeric'],
            'asmodians_y' => ['required', 'numeric'],
            'asmodians_z' => ['required', 'numeric'],
            'asmodians_map' => ['required', 'integer'],
            'cooldown_minutes' => ['required', 'integer', 'min:1'],
        ]);

        $settings->elyos_x = (float) $validated['elyos_x'];
        $settings->elyos_y = (float) $validated['elyos_y'];
        $settings->elyos_z = (float) $validated['elyos_z'];
        $settings->elyos_map = (int) $validated['elyos_map'];
        $settings->asmodians_x = (float) $validated['asmodians_x'];
        $settings->asmodians_y = (float) $validated['asmodians_y'];
        $settings->asmodians_z = (float) $validated['asmodians_z'];
        $settings->asmodians_map = (int) $validated['asmodians_map'];
        $settings->cooldown_minutes = (int) $validated['cooldown_minutes'];
        $settings->save();

        return response()->json([
            'data' => $validated,
            'message' => __('Teleport settings updated successfully!'),
        ]);
    }
}
