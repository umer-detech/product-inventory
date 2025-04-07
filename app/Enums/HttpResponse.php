<?php

namespace App\Enums;

enum HttpResponse: int
{
    case SUCCESS = 200;
    case CREATED = 201;
    case UNAUTHORIZED = 401;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case SERVER_ERROR = 500;
}
