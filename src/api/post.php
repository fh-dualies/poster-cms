<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

use controller\AccountController;
use controller\AuthController;
use controller\MediaController;
use controller\PosterController;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';
require_once __DIR__ . '/../controller/auth-controller.php';
require_once __DIR__ . '/../controller/account-controller.php';
require_once __DIR__ . '/../controller/media-controller.php';
require_once __DIR__ . '/../controller/poster-controller.php';

$auth_controller = new AuthController();
$account_controller = new AccountController();
$media_controller = new MediaController();
$poster_controller = new PosterController();

$handlers = [
  'login' => function ($param) use ($auth_controller) {
    $response = $auth_controller->login($param);

    if (!$response['is_error']) {
      redirect_to_page(FilePathEnum::HOME, $response);
    } else {
      redirect_to_page(FilePathEnum::LOGIN, $response);
    }
  },
  'register' => function ($param) use ($auth_controller) {
    $response = $auth_controller->register($param);

    if (!$response['is_error']) {
      redirect_to_page(FilePathEnum::LOGIN, $response);
    } else {
      redirect_to_page(FilePathEnum::REGISTER, $response);
    }
  },
  'update_account' => function ($param) use ($account_controller) {
    $response = $account_controller->update_account($param);
    redirect_to_page(FilePathEnum::ACCOUNT, $response);
  },
  'create_media' => function () use ($media_controller) {
    $response = $media_controller->create_media($_FILES);

    invalidate_cache([RouteEnum::GET_ALL_MEDIA]);
    redirect_to_page(FilePathEnum::MEDIA, $response);
  },
  'delete_media' => function ($param) use ($media_controller) {
    $response = $media_controller->delete_by_id($param);

    invalidate_cache([RouteEnum::GET_ALL_MEDIA]);
    redirect_to_page(FilePathEnum::MEDIA, $response);
  },
  'delete_account' => function () use ($account_controller, $auth_controller) {
    $response = $account_controller->delete_account();

    if ($response['is_error']) {
      redirect_to_page(FilePathEnum::ACCOUNT, $response);
    } else {
      $auth_controller->logout();
      redirect_to_page(FilePathEnum::LOGIN, $response);
    }
  },
  'create_poster' => function ($param) use ($poster_controller) {
    $response = $poster_controller->create_poster($param, $_FILES);

    invalidate_cache([RouteEnum::GET_ALL_POSTERS, RouteEnum::GET_POSTER_DETAIL, RouteEnum::GET_ALL_MEDIA]);

    if ($response['is_error']) {
      redirect_to_page(FilePathEnum::CREATE, $response);
    } else {
      redirect_to_page(FilePathEnum::HOME, $response);
    }
  },
  'update_poster' => function ($param) use ($poster_controller) {
    $response = $poster_controller->update_poster($param, $_FILES);

    invalidate_cache([RouteEnum::GET_ALL_POSTERS, RouteEnum::GET_POSTER_DETAIL, RouteEnum::GET_ALL_MEDIA]);
    redirect_to_page(FilePathEnum::HOME, $response);
  },
  'delete_poster' => function ($param) use ($poster_controller) {
    $response = $poster_controller->delete_by_id($param);

    invalidate_cache([RouteEnum::GET_ALL_POSTERS, RouteEnum::GET_POSTER_DETAIL]);
    redirect_to_page(FilePathEnum::HOME, $response);
  },
  'logout' => function () use ($auth_controller) {
    $auth_controller->logout();
    redirect_to_page(FilePathEnum::LOGIN);
  },
];

function invalidate_cache(array $routes): void
{
  foreach ($routes as $route) {
    $key = $route->get_cache_key();

    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }
  }
}

function handle_post_request(): void
{
  global $handlers;

  error_log(print_r($_POST, true), 3, __DIR__ . '/../debug.log');

  foreach ($handlers as $action => $callback) {
    if (isset($_POST[$action])) {
      try {
        $callback($_POST);
      } catch (Throwable $e) {
        log_error($e);
      }

      return;
    }
  }

  redirect_to_page(FilePathEnum::NOT_FOUND);
}

handle_post_request();
