<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Throwable;

abstract class Controller
{
    /**
     * Log a failure with a reference code and return a safe message for the admin.
     */
    protected function failureMessage(string $action, Throwable $e): string
    {
        // Hex agar mudah didiktekan (tidak ada O/0 atau I/1 yang tertukar)
        $code = 'ERR-'.strtoupper(bin2hex(random_bytes(3)));

        Log::error("[{$code}] {$action}", ['exception' => $e]);

        return "{$action}. Sampaikan kode {$code} ke pengelola teknis bila masalah berlanjut.";
    }
}
