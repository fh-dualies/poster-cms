<?php

enum RouteEnum
{
  case POST_REDIRECT;
  case POST_LOGIN;
  case POST_REGISTER;
  case POST_LOGOUT;
  case POST_UPDATE_ACCOUNT;

  case GET_ALL_POSTERS;
  case GET_POSTER_DETAIL;

  public static function get_post_routes(): array
  {
    return self::map_routes([
      self::POST_REDIRECT,
      self::POST_LOGIN,
      self::POST_REGISTER,
      self::POST_LOGOUT,
      self::POST_UPDATE_ACCOUNT,
    ]);
  }

  private static function map_routes(array $routes): array
  {
    return array_map(fn(RouteEnum $route) => $route->get_function_name(), $routes);
  }

  public function get_function_name(): string
  {
    return match ($this) {
      self::POST_REDIRECT => 'redirect',
      self::POST_LOGIN => 'login',
      self::POST_REGISTER => 'register',
      self::POST_LOGOUT => 'logout',
      self::POST_UPDATE_ACCOUNT => 'update_account',
      self::GET_ALL_POSTERS => 'get_all_posters',
      self::GET_POSTER_DETAIL => 'get_poster_detail',
    };
  }

  public static function get_get_routes(): array
  {
    return self::map_routes([self::GET_ALL_POSTERS, self::GET_POSTER_DETAIL]);
  }

  public function get_cache_key(): string
  {
    $entity = $this->get_function_name();

    return $entity ? 'cache__' . $entity : '';
  }
}
