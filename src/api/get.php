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

check_user_agent();

$config = new Config();
$poster_controller = new PosterController($config);
$media_controller = new MediaController($config);

$handlers = [
  'get_all_posters' => function ($param) use ($poster_controller) {
    return $poster_controller->get_all();
  },
  'get_poster_detail' => function ($param) use ($poster_controller) {
    return $poster_controller->get_by_id($param);
  },
  'get_all_media' => function ($param) use ($media_controller) {
    return $media_controller->get_all();
  },
];

function register_data(RouteEnum $route, mixed $param = null): void
{
  global $handlers;

  $func = $route->get_function_name();

  if (!isset($handlers[$func])) {
    redirect_to_page(FilePathEnum::NOT_FOUND);
    return;
  }

  $cache_key = $route->get_cache_key();
  $timestamp_key = $cache_key . '_ts';

  if ($param === null) {
    if (
      isset($_SESSION[$cache_key], $_SESSION[$timestamp_key]) &&
      time() - $_SESSION[$timestamp_key] < Config::get_cache_ttl()
    ) {
      return;
    }

    unset($_SESSION[$cache_key], $_SESSION[$timestamp_key]);
  }

  try {
    $result = $handlers[$func]($param);

    if (!is_array($result) && $result !== null) {
      redirect_to_page(FilePathEnum::NOT_FOUND);
      return;
    }

    $_SESSION[$cache_key] = $result;
    $_SESSION[$timestamp_key] = time();
  } catch (PDOException | Exception $e) {
    redirect_to_page(FilePathEnum::NOT_FOUND);
    log_error($e);
  }
}
