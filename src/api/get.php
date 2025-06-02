<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

use controller\PosterController;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../controller/poster-controller.php';

$config = new Config();

$poster_controller = new PosterController($config);

function register_data(RouteEnum $route, mixed $param = null): void
{
  if (!in_array($route->get_function_name(), RouteEnum::get_get_routes())) {
    redirect_to_page(FilePathEnum::NOT_FOUND);
    return;
  }

  $cacheKey = $route->get_cache_key();

  if (isset($_SESSION[$cacheKey])) {
    return;
  }

  try {
    $function_ref = $route->get_function_name();

    $_SESSION[$cacheKey] = $function_ref($param);
  } catch (PDOException | Exception $e) {
    log_error($e);
    redirect_to_page(FilePathEnum::NOT_FOUND);
  }
}

function get_all_posters(): array
{
  global $poster_controller;
  return $poster_controller->get_all();
}
