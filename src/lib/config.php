<?php

class Config
{
  public static function get_pdo(): PDO
  {
    $db_host = getenv('DB_HOST') ?: 'localhost';
    $db_port = getenv('DB_PORT') ?: '5432';
    $db_user = getenv('DB_USER') ?: 'admin';
    $db_pass = getenv('DB_PASS') ?: 'admin';
    $db_name = getenv('DB_NAME') ?: 'www';

    $dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name}";

    return new PDO($dsn, $db_user, $db_pass);
  }

  public static function get_base_path(): string
  {
    return '/ss25-www1/';
  }

  public static function get_allowed_file_types(): array
  {
    return ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
  }

  public static function get_max_file_size(): int
  {
    return 5 * 1024 * 1024; // 5 MB
  }

  public static function get_upload_directory(): string
  {
    return __DIR__ . '/../static/_uploads/';
  }

  public static function get_cache_ttl(): int
  {
    return 120; // seconds
  }
}
