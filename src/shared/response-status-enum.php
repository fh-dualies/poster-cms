<?php

enum ResponseStatusEnum
{
    case SUCCESS;
    case NOT_FOUND;
    case UNAUTHORIZED;
    case FORBIDDEN;
    case VALIDATION_ERROR;
    case SERVER_ERROR;

    public function get_name(): string
    {
        return match ($this) {
            self::SUCCESS => 'success',
            self::NOT_FOUND => 'not_found',
            self::UNAUTHORIZED => 'unauthorized',
            self::FORBIDDEN => 'forbidden',
            self::VALIDATION_ERROR => 'validation_error',
            self::SERVER_ERROR => 'server_error',
        };
    }
}