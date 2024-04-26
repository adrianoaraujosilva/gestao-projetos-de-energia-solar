<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{

    public function success(string $message, $content = null): JsonResponse
    {
        return response()->json(["message" => $message, "content" => $content, "code" => 200], 200);
    }

    public function badRequest(string $message, array $content = null): JsonResponse
    {
        return response()->json(["message" => $message, "content" => $content, "code" => 400], 400);
    }

    public function notFound(): JsonResponse
    {
        return response()->json(["message" => "Data Not Found", "code" => 404], 404);
    }

    public function unauthorized(): JsonResponse
    {
        return response()->json(["message" => "Unauthorized!", "code" => 401], 401);
    }

    public function forbidden(): JsonResponse
    {
        return response()->json(["message" => "Forbidden!", "code" => 403], 403);
    }
}
