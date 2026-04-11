<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\AnnouncementSettingsUpdateRequest;
use App\Http\Requests\Admin\Settings\ClassesSettingsUpdateRequest;
use App\Http\Requests\Admin\Settings\DownloadSettingsUpdateRequest;
use App\Http\Requests\Admin\Settings\GatewaySettingsUpdateRequest;
use App\Http\Requests\Admin\Settings\PaymentSettingsUpdateRequest;
use App\Http\Requests\Admin\Settings\TeleportSettingsUpdateRequest;
use App\Settings\AnnouncementSettings;
use App\Settings\ClassesSettings;
use App\Settings\DownloadSettings;
use App\Settings\GatewaySettings;
use App\Settings\PaymentSettings;
use App\Settings\TeleportSettings;
use Illuminate\Http\JsonResponse;

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

    public function downloadUpdate(DownloadSettingsUpdateRequest $request, DownloadSettings $settings): JsonResponse
    {
        $validated = $request->validated();

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

    public function announcementUpdate(AnnouncementSettingsUpdateRequest $request, AnnouncementSettings $settings): JsonResponse
    {
        $validated = $request->validated();

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
                'bonus_tiers' => $settings->bonus_tiers,
            ],
        ]);
    }

    public function paymentUpdate(PaymentSettingsUpdateRequest $request, PaymentSettings $settings): JsonResponse
    {
        $validated = $request->validated();

        $settings->enabled = $validated['enabled'];
        $settings->rate_rub = (float) $validated['rate_rub'];
        $settings->rate_usd = (float) $validated['rate_usd'];
        $settings->rate_eur = (float) $validated['rate_eur'];
        $settings->bonus_tiers = $validated['bonus_tiers'];
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

    public function gatewayUpdate(GatewaySettingsUpdateRequest $request, GatewaySettings $settings): JsonResponse
    {
        $validated = $request->validated();

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

    public function teleportUpdate(TeleportSettingsUpdateRequest $request, TeleportSettings $settings): JsonResponse
    {
        $validated = $request->validated();

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

    public function classesShow(ClassesSettings $settings): JsonResponse
    {
        return response()->json([
            'data' => [
                'classes' => $settings->classes,
            ],
        ]);
    }

    public function classesUpdate(ClassesSettingsUpdateRequest $request, ClassesSettings $settings): JsonResponse
    {
        $validated = $request->validated();

        $settings->classes = $validated['classes'];
        $settings->save();

        return response()->json([
            'data' => $validated,
            'message' => __('Classes settings updated successfully!'),
        ]);
    }
}
