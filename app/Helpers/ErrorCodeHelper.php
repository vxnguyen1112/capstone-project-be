<?php

namespace App\Helpers;

class ErrorCodeHelper
{
    public const UNAUTHORIZED = 'UNAUTHORIZED';
    public const INVALID_JWT_TOKEN = 'INVALID_JWT_TOKEN';
    public const EXPIRED_JWT_TOKEN = 'EXPIRED_JWT_TOKEN';
    public const REQUIRED = 'REQUIRED';
    public const NOT_FOUND = 'NOT_FOUND';
    public const NOT_ALLOW = 'NOT_ALLOW';
    public const INVALID = 'INVALID';
    public const INTEGER = 'INTEGER';
    public const EXISTED = 'EXISTED';
    public const MISSING = 'MISSING';
    public const ARRAY = 'ARRAY';
    public const INACTIVE = 'INACTIVE';
    public const ROUTE_NOT_FOUND = 'ROUTE NOT FOUND';
}
