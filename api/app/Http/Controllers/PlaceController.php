<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\DomruService;
use Exception;
use Illuminate\Http\JsonResponse;

class PlaceController
{
    public function open(Account $account, string $control): JsonResponse
    {
        try {
            DomruService::open($account, $control);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function snap(Account $account, string $control): JsonResponse
    {
        try {
            $path = DomruService::snap($account, $control);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'path' => $path,
        ]);
    }

    public function rtsp(Account $account, string $camera): JsonResponse
    {
        try {
            $url = DomruService::rtsp($account, $camera);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}
