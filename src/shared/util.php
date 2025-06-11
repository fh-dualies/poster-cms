<?php

require_once __DIR__ . '/response-status-enum.php';
require_once __DIR__ . '/file-path-enum.php';
require_once __DIR__ . '/../lib/config.php';

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

  if (!isset($user['id'], $user['username'], $user['email'])) {
    redirect_to_page(FilePathEnum::LOGIN);
    exit();
  }

  $cacheKey = 'auth_valid_' . $user['id'];
  $cached = $_SESSION[$cacheKey] ?? null;

  if ($cached && time() - $cached['timestamp'] < Config::get_cache_ttl()) {
    return;
  }

  try {
    $stmt = Config::get_pdo()->prepare('SELECT COUNT(*) FROM users WHERE id = :id');
    $stmt->execute([':id' => $user['id']]);
    $count = (int) $stmt->fetchColumn();

    if ($count === 0) {
      redirect_to_page(FilePathEnum::LOGIN);
      exit();
    }

    $_SESSION[$cacheKey] = ['timestamp' => time()];
  } catch (Exception $e) {
    redirect_to_page(FilePathEnum::LOGIN);
    exit();
  }
}

function check_user_agent(): void
{
  if (php_sapi_name() === 'cli') {
    http_response_code(403);
    exit();
  }

  $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
  $browserPattern = '#(Mozilla|Chrome|Safari|Firefox|Edge)#i';

  if (!preg_match($browserPattern, $userAgent)) {
    http_response_code(403);
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
    header('location: ' . str_replace(["\r", "\n"], '', $url));
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
