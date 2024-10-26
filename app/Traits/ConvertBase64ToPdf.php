<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\InsurerIntegrationException;
use Illuminate\Support\Facades\Storage;

trait ConvertBase64ToPdf
{
    private function downloadBase64(
        string $base64,
        string $relativePath,
    ) {
        $base64 = base64_decode($base64);
        $saveFile = Storage::put($relativePath, $base64);

        if (!$saveFile) {
            throw new InsurerIntegrationException('Falha ao fazer download de base64');
        }

        return $relativePath;
    }
}
