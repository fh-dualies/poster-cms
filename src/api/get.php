<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

use controller\MediaController;
use controller\PosterController;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';
require_once __DIR__ . '/../controller/poster-controller.php';
require_once __DIR__ . '/../controller/media-controller.php';

$config = new Config();
$poster_controller = new PosterController($config);
$media_controller = new MediaController($config);

function register_data(RouteEnum $route, mixed $param = null): void
{
  // Verify that the route’s function is one of the allowed GET routes
  if (!in_array($route->get_function_name(), RouteEnum::get_get_routes(), true)) {
    redirect_to_page(FilePathEnum::NOT_FOUND);
    return;
  }

  error_log(print_r($_POST, true), 3, __DIR__ . '/../my-debug.log');

  $cache_key = $route->get_cache_key();

  // If no parameter and cache exists, skip fetching
  if ($param === null && !empty($_SESSION[$cache_key])) {
    return;
  }

  try {
    $function_name = $route->get_function_name();
    $result = $function_name($param);

    if (!is_array($result) && $result !== null) {
      redirect_to_page(FilePathEnum::NOT_FOUND);
      return;
    }

    $_SESSION[$cache_key] = $result;
  } catch (PDOException | Exception $e) {
    log_error($e);
    redirect_to_page(FilePathEnum::NOT_FOUND);
  }
}

function get_all_posters(): ?array
{
  global $poster_controller;

  try {
    return $poster_controller->get_all();
  } catch (PDOException $e) {
    log_error($e);
    return null;
  }
}

function get_poster_detail(int $id): ?array
{
  global $poster_controller;

  try {
    return $poster_controller->get_by_id($id);
  } catch (PDOException $e) {
    log_error($e);
    return null;
  }
}

function get_all_media(): ?array
{
  global $media_controller;

  try {
    return $media_controller->get_all();
  } catch (PDOException $e) {
    log_error($e);
    return null;
  }
}
