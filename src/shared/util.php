<?php

require_once __DIR__ . '/response-status-enum.php';

function include_with_prop($fileName, $prop): void
{
  extract($prop);
  include $fileName;
}

function redirect_to_not_found(): void
{
  header('location: ' . FilePathEnum::NOT_FOUND->get_path());
  exit();
}

function redirect_to_page(FilePathEnum $page): void
{
  header('location: ' . $page->get_path());
}

function create_response(ResponseStatusEnum $status, string $message, array $data = []): array
{
  return [
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
