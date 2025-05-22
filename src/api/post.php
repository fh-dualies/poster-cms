<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/route-enum.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('location: ' . FilePathEnum::NOT_FOUND->get_path());
} else {
  match_call();
}

function match_call(): void
{
  $functions = PostRouteEnum::get_post_routes();

  foreach ($functions as $function) {
    if (isset($_POST[$function])) {
      try {
        $function($_POST[$function]);
      } catch (PDOException | Exception $e) {
        print_r($e);
      }

      return;
    }
  }

  header('location: ' . FilePathEnum::NOT_FOUND->get_path());
}

function redirect(string $path): void
{
  header("location: $path");
}
