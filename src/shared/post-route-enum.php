<?php

enum PostRouteEnum {
    case REDIRECT;

    public function getName(): string
    {
        return match ($this) {
            self::REDIRECT => 'redirect',
        };
    }

    public static function getRoutes(): array
    {
        return [
            self::REDIRECT->getName(),
        ];
    }
}