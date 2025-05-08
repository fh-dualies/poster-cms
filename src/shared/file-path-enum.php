<?php

enum FilePathEnum
{
    case HOME;
    case ACCOUNT;
    case DETAIL_VIEW;
    case MEDIA;
    case POSTER_DESIGNER;
    case LOGIN;
    case REGISTER;
    case NOT_FOUND;

    public function getPath(): string
    {
        return match ($this) {
            self::HOME => '/index.php',
            self::ACCOUNT => '/pages/account.php',
            self::DETAIL_VIEW => '/pages/detail-view.php',
            self::MEDIA => '/pages/media.php',
            self::POSTER_DESIGNER => '/pages/poster-designer.php',
            self::LOGIN => '/pages/login.php',
            self::REGISTER => '/pages/register.php',
            self::NOT_FOUND => '/pages/not-found.php',
        };
    }
}