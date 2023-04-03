<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected const DEFAULT_HEADERS = [];

    /**
     * @param array<mixed, mixed>|null $data
     * @param int $status
     * @param array<string, string> $headers
     * @return JsonResponse
     */
    protected function success(?array $data = null, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse(
            data: $data,
            status: $status,
            headers: [
                ...$this->getHeaders(),
                $headers,
            ],
            json: true
        );
    }

    /**
     * @param array<mixed, mixed>|null $data
     * @param int $status
     * @param array<string, string> $headers
     * @return JsonResponse
     */
    protected function fail(?array $data = null, int $status = Response::HTTP_BAD_REQUEST, array $headers = []): JsonResponse
    {
        return new JsonResponse(
            data: $data,
            status: $status,
            headers: [
                ...$this->getHeaders(),
                $headers,
            ],
            json: true
        );
    }

    /**
     * @return array<string, string>
     */
    protected function getHeaders(): array
    {
        return self::DEFAULT_HEADERS;
    }
}
