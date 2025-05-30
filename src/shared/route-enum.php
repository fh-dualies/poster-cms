<?php

enum RouteEnum
{
  case POST_REDIRECT;
  case POST_LOGIN;
  case POST_REGISTER;
  case POST_LOGOUT;

  case GET_POSTERS;

  public static function get_post_routes(): array
  {
    return [
      self::POST_REDIRECT->get_name(),
      self::POST_LOGIN->get_name(),
      self::POST_REGISTER->get_name(),
      self::POST_LOGOUT->get_name(),
    ];
  }

  public static function get_get_routes(): array
  {
    return [self::GET_POSTERS->get_name()];
  }

  public function get_name(): string
  {
    return match ($this) {
      self::POST_REDIRECT => 'redirect',
      self::POST_LOGIN => 'login',
      self::POST_REGISTER => 'register',
      self::POST_LOGOUT => 'logout',
      self::GET_POSTERS => 'get_posters',
    };
  }
}
