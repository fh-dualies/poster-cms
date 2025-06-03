<?php

require_once __DIR__ . '/response-status-enum.php';
require_once __DIR__ . '/file-path-enum.php';

function check_auth_status(): void
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['user'])) {
    redirect_to_page(FilePathEnum::LOGIN);
    exit();
  }

  $user = $_SESSION['user'];

  if (!isset($user['id']) || !isset($user['username']) || !isset($user['email'])) {
    redirect_to_page(FilePathEnum::LOGIN);
    exit();
  }
}

function include_with_prop($fileName, $prop): void
{
  extract($prop);
  include $fileName;
}

function redirect_to_page(FilePathEnum $page, ?array $response = null, bool $reload = false): void
{
  $url = $page->get_path();

  if (!is_null($response)) {
    $url .= "?status=$response[status]&message=$response[message]&is_error=$response[is_error]";
  }

  if ($reload) {
    header("Refresh:0; url=$url");
  } else {
    header("location: $url");
  }
}

function create_response(ResponseStatusEnum $status, string $message, array $data = []): array
{
  return [
    'is_error' => (int) $status->is_error(),
    'status' => $status->get_name(),
    'message' => $message,
    'data' => $data,
  ];
}

function log_error(Throwable $e): void
{
  error_log($e->getMessage());
  print_r($e);
}
