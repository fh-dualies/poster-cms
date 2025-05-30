<?php

require_once __DIR__ . '/response-status-enum.php';

function include_with_prop($fileName, $prop): void
{
  extract($prop);
  include $fileName;
}

function redirect_to_page(FilePathEnum $page, ?array $response = null): void
{
  if ($response !== null) {
    header('location: ' . $page->get_path());
  }

  header('location: ' . $page->get_path() . "?status=$response[status]&message=$response[message]");
}

function create_response(ResponseStatusEnum $status, string $message, array $data = []): array
{
  return [
    'is_error' => $status->is_error(),
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
