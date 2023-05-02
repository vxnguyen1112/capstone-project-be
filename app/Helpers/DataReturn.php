<?php

    namespace App\Helpers;

    class DataReturn
    {
        public static function Result($data = [], $status=HttpCode::OK)
        {
            return ['status' => $status, 'data' => $data];
        }
    }
