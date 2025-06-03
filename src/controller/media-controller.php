<?php

namespace controller;

use Config;
use RegexEnum;
use ResponseStatusEnum;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class MediaController
{
  private Config $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function get_all(): ?array
  {
    check_auth_status();

    $req = $this->config->get_pdo()->prepare('SELECT * FROM medias');
    $req->execute();

    return $req->fetchAll() ?: null;
  }
}
