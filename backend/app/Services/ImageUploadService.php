<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;

final class ImageUploadService
{
    private const ALLOWED_SIGNATURES = [
        "\xFF\xD8\xFF"         => 'image/jpeg',
        "\x89\x50\x4E\x47"    => 'image/png',
        "\x47\x49\x46\x38"    => 'image/gif',
        "\x52\x49\x46\x46"    => 'image/webp',
    ];

    public function upload(UploadedFile $file, string $directory = 'uploads/images', int $maxWidth = 1920, int $quality = 85): string
    {
        $this->validateMagicBytes($file);

        $manager = ImageManager::usingDriver(\Intervention\Image\Drivers\Gd\Driver::class);
        $image = $manager->decode($file->getPathname());

        $image->scaleDown($maxWidth, $maxWidth);

        $filename = Str::random(40).'.webp';
        $path = $directory.'/'.$filename;

        $fullPath = storage_path('app/public/'.$path);
        $dir = dirname($fullPath);

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $image->save($fullPath, quality: $quality);

        return $path;
    }

    private function validateMagicBytes(UploadedFile $file): void
    {
        $handle = fopen($file->getPathname(), 'rb');

        if ($handle === false) {
            throw ValidationException::withMessages(['image' => 'Unable to read file.']);
        }

        $bytes = fread($handle, 12);
        fclose($handle);

        if ($bytes === false) {
            throw ValidationException::withMessages(['image' => 'Unable to read file.']);
        }

        foreach (self::ALLOWED_SIGNATURES as $signature => $type) {
            if (str_starts_with($bytes, $signature)) {
                if ($type === 'image/webp' && ! str_contains($bytes, 'WEBP')) {
                    continue;
                }

                return;
            }
        }

        throw ValidationException::withMessages(['image' => 'Invalid image file.']);
    }
}
