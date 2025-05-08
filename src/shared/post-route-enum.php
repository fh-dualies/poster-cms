<?php

enum PostRouteEnum
{
  case REDIRECT;

  public static function getRoutes(): array
  {
    return [self::REDIRECT->getName()];
  }

  public function getName(): string
  {
    return match ($this) {
      self::REDIRECT => 'redirect',
    };
  }
}
