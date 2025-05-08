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
      self::HOME => '/ss25-www1/src/index.php',
      self::ACCOUNT => '/ss25-www1/src/pages/account.php',
      self::DETAIL_VIEW => '/ss25-www1/src/pages/detail-view.php',
      self::MEDIA => '/ss25-www1/src/pages/media.php',
      self::POSTER_DESIGNER => '/ss25-www1/src/pages/poster-designer.php',
      self::LOGIN => '/ss25-www1/src/pages/login.php',
      self::REGISTER => '/ss25-www1/src/pages/register.php',
      self::NOT_FOUND => '/ss25-www1/src/pages/not-found.php',
    };
  }
}
