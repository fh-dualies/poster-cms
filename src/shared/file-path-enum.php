<?php

enum FilePathEnum
{
  private const BASE_PATH = '/ss25-www1/';

  case HOME;
  case ACCOUNT;
  case POSTER;
  case MEDIA;
  case CREATE;
  case LOGIN;
  case REGISTER;
  case NOT_FOUND;

  public function get_path(): string
  {
    return match ($this) {
      self::HOME => self::get_sys_path('src/index.php'),
      self::ACCOUNT => self::get_sys_path('src/pages/account.php'),
      self::POSTER => self::get_sys_path('src/pages/poster.php'),
      self::MEDIA => self::get_sys_path('src/pages/media.php'),
      self::CREATE => self::get_sys_path('src/pages/create.php'),
      self::LOGIN => self::get_sys_path('src/pages/login.php'),
      self::REGISTER => self::get_sys_path('src/pages/register.php'),
      self::NOT_FOUND => self::get_sys_path('src/pages/not-found.php'),
    };
  }

  public static function get_sys_path(string $path = ''): string
  {
    return self::BASE_PATH . $path;
  }
}
