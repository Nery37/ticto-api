<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\InsurerIntegrationException;
use Illuminate\Support\Facades\Storage;

trait ConvertExternalUrlToPdf
{
    private function downloadExternalUrl(
        string $externalUrl,
        string $relativePath,
    ) {
        $saveFile = Storage::put($relativePath, file_get_contents($externalUrl));

        if (!$saveFile) {
            throw new InsurerIntegrationException('Falha ao fazer download de URL externa');
        }

        return $relativePath;
    }
}
