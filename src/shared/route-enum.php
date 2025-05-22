<?php

enum PostRouteEnum
{
  case POST_REDIRECT;

  case GET_POSTERS;

  public static function get_post_routes(): array
  {
    return [self::POST_REDIRECT->get_name()];
  }

  public static function get_get_routes(): array
  {
      return [self::GET_POSTERS->get_name()];
  }

  public function get_name(): string
  {
    return match ($this) {
      self::POST_REDIRECT => 'redirect',
      self::GET_POSTERS => 'get_posters',
    };
  }
}
