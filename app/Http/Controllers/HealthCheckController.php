<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthCheckController extends Controller
{
    public function check()
    {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'status' => 'health',
            ]);
        } catch (\Exception $e) {
            Log::emergency('Health Check: ' . $e->getMessage());
            return response()->json([
                'status' => 'unhealth',
            ], 500);
        }
    }
}
