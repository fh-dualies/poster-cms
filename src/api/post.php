<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

use controller\AccountController;
use controller\AuthController;
use controller\MediaController;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../controller/auth-controller.php';
require_once __DIR__ . '/../controller/account-controller.php';
require_once __DIR__ . '/../controller/media-controller.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

$config = new config();

$auth_controller = new AuthController($config);
$account_controller = new AccountController($config);
$media_controller = new MediaController($config);

handle_post_request();

function handle_post_request(): void
{
  $functions = RouteEnum::get_post_routes();

  foreach ($functions as $function) {
    if (isset($_POST[$function])) {
      execute_function($function, $_POST[$function]);
      return;
    }
  }

  redirect_to_page(FilePathEnum::NOT_FOUND);
}

function execute_function(string $function, $param): void
{
  try {
    $function($param);
  } catch (PDOException | Exception $e) {
    log_error($e);
  }
}

function redirect(string $path): void
{
  header("location: $path");
}

function login(): void
{
  global $auth_controller;
  $response = $auth_controller->login($_POST);

  if (!$response['is_error']) {
    redirect_to_page(FilePathEnum::HOME, $response);
    return;
  }

  redirect_to_page(FilePathEnum::LOGIN, $response);
}

function register(): void
{
  global $auth_controller;

  $response = $auth_controller->register($_POST);

  if (!$response['is_error']) {
    redirect_to_page(FilePathEnum::LOGIN, $response);
    return;
  }

  redirect_to_page(FilePathEnum::REGISTER, $response);
}

function update_account(): void
{
  global $account_controller;

  $response = $account_controller->update_account($_POST);
  redirect_to_page(FilePathEnum::ACCOUNT, $response);
}

function delete_media(): void
{
  global $media_controller;

  $response = $media_controller->delete_by_id($_POST);
  redirect_to_page(FilePathEnum::MEDIA, $response, true);
}

function delete_account(): void
{
  global $account_controller;

  $response = $account_controller->delete_auth_user();

  $_SESSION = [];
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
     );
  }
  session_destroy();
  redirect_to_page(FilePathEnum::ACCOUNT, $response);
}

function logout(): void
{
  global $auth_controller;

  $auth_controller->logout();
}
