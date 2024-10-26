<?php

declare(strict_types=1);

namespace App\Adapters;

use App\Enums\HttpStatusCodeEnum;
use Illuminate\Support\Facades\Log;

class LogRequestAdapter
{
    public function logsRequests(
        $path,
        $response,
        $statusCode,
        $payload = null
    ) {
        $request = [
            'url' => $path,
            'payload' => $payload,
            'response' => $response,
            'statusCode' => $statusCode,
        ];

        if ($statusCode > HttpStatusCodeEnum::NON_AUTHORITATIVE_INFORMATION) {
            Log::error($path, $request);
            return;
        }

        Log::Info($path, $request);
    }
}
