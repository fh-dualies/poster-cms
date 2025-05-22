<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';

function init_data(string $functionRef, mixed $param = null): mixed
{
  $functions = RouteEnum::get_get_routes();

  if (in_array($functionRef, $functions, true)) {
    try {
      return $functionRef($param);
    } catch (PDOException | Exception $e) {
      log_error($e);
    }
  }

  redirect_to_not_found();
  return null;
}

function get_posters(): array
{
  // global $posterController;
  // return $posterController->get_all();

  return [];
}
