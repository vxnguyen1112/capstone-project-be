<?php

namespace App\Helpers;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResponseHelper
{
    /**
     * @param array|object|string $result
     * @param string $status
     * @param int $statusCode
     * @param array $errors
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function send(
        $result = [],
        $status = Status::OK,
        $statusCode = HttpCode::OK,
        $errors = [],
        $headers = []
    )
    {
        $data = [];
        $data['status'] = $status;
        if ($result) {
            $data['results'] = $result;
        }
        if ($errors) {
            $data['errors'] =  ['message' => $errors];
        }

        return response()->json(
            $data,
            $statusCode,
            $headers,
            JSON_UNESCAPED_UNICODE
        );
    }

}
