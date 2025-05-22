<?php

function include_with_prop($fileName, $prop): void
{
  extract($prop);
  include $fileName;
}


function redirect_to_not_found(): void
{
    header('location: ' . FilePathEnum::NOT_FOUND->get_path());
    exit();
}

function log_error(Throwable $e): void
{
    error_log($e->getMessage());
    print_r($e);
}