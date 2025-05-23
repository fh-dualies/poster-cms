<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  redirect_to_not_found();
  exit();
}

use controller\AuthController;
use lib\Config;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../controller/auth-controller.php';

$config = new Config();
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

  redirect_to_not_found();
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
  $res = $authController->login($_POST);
}
