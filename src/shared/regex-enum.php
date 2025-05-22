<?php

enum RegexEnum
{
  case NAME;
  case EMAIL;
  case PASSWORD;

  public function get_pattern(): string
  {
    return match ($this) {
      self::NAME => "/^[a-zA-Z]{2,}$/",
      self::EMAIL => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
      self::PASSWORD => "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/",
    };
  }
}
