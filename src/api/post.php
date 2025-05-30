<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

use controller\AuthController;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../controller/auth-controller.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect_to_page(FilePathEnum::NOT_FOUND);
  exit();
}

$config = new config();
$authController = new AuthController($config);

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

function login(): void
{
  global $authController;
  $response = $authController->login($_POST);

  if (!$response['is_error']) {
    redirect_to_page(FilePathEnum::HOME, $response);
    return;
  }

  redirect_to_page(FilePathEnum::LOGIN, $response);
}

function register(): void
{
  global $authController;

  $response = $authController->register($_POST);
  redirect_to_page(FilePathEnum::LOGIN, $response);
}

function logout(): void
{
  global $authController;

  $authController->logout();
}
