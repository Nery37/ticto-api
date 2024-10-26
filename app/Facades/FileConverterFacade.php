<?php

declare(strict_types=1);

namespace App\Facades;

use App\DTOs\Guarantee\ConvertFileParameters;
use App\Exceptions\InsurerIntegrationException;
use App\Traits\ConvertBase64ToPdf;
use App\Traits\ConvertExternalUrlToPdf;

class FileConverterFacade
{
    use ConvertBase64ToPdf;
    use ConvertExternalUrlToPdf;

    public function convertFile(ConvertFileParameters $parameters)
    {
        $methodName = 'download' . ucfirst($parameters->getFileTypeContent());
        $filename = date('YmdHis') . '.pdf';
        $relativePath = $parameters->getRelativePath($filename);

        if (!method_exists($this, $methodName)) {
            throw new InsurerIntegrationException('Falha ao determinar método de download de arquivo.');
        }
        return $this->{$methodName}($parameters->getFileContent(), $relativePath);
    }
}
