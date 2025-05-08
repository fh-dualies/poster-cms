<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/post-route-enum.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: ".FilePathEnum::NOT_FOUND->getPath());
} else {
    match_call();
}

function match_call(): void
{
    $functions = PostRouteEnum::getRoutes();

    foreach($functions as $function) {
        if(isset($_POST[$function])) {
            try {
                $function($_POST[$function]);
            } catch (PDOException|Exception $e) {
                print_r($e);
            }

            return;
        }
    }

    header("location: ".FilePathEnum::NOT_FOUND->getPath());
}

function redirect(string $path): void
{
    header("location: $path");
}