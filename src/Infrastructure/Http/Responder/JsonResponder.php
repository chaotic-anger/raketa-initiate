<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\Infrastructure\Http\Responder;

final class JsonResponder implements Responder
{
    public function response(mixed $data, int $statusCode = 200): JsonResponse
    {
        $response = new JsonResponse();

        $response->getBody()->write(
            json_encode(
                [
                    'status' => 'success',
                    'cart' => $data
                ],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );

        return $response
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus($statusCode);
    }
}