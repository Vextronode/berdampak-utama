<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

abstract class Controller
{
    /**
     * Log a failure with a reference code and return a safe message for the admin.
     */
    protected function failureMessage(string $action, Throwable $e): string
    {
        $code = 'ERR-'.Str::upper(Str::random(6));

        Log::error("[{$code}] {$action}", ['exception' => $e]);

        return "{$action}. Sampaikan kode {$code} ke pengelola teknis bila masalah berlanjut.";
    }
}
