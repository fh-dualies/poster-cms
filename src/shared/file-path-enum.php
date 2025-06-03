<?php

enum FilePathEnum
{
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
      self::HOME => '/ss25-www1/src/index.php',
      self::ACCOUNT => '/ss25-www1/src/pages/account.php',
      self::POSTER => '/ss25-www1/src/pages/poster.php',
      self::MEDIA => '/ss25-www1/src/pages/media.php',
      self::CREATE => '/ss25-www1/src/pages/create.php',
      self::LOGIN => '/ss25-www1/src/pages/login.php',
      self::REGISTER => '/ss25-www1/src/pages/register.php',
      self::NOT_FOUND => '/ss25-www1/src/pages/not-found.php',
    };
  }
}
