<?php

namespace controller;

use Config;
use PDO;
use ResponseStatusEnum;
use RouteEnum;

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

  public function get_all(): array
  {
    check_auth_status();

    $req = $this->config->get_pdo()->prepare('SELECT * FROM medias');
    $req->execute();

    return $req->fetchAll() ?: [];
  }

  public function delete_by_id(array $data): array
  {
    check_auth_status();

    if (!isset($data['id'])) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Media id is required.');
    }

    $id = $data['id'];

    if (!is_numeric($id) || $id <= 0) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid media id provided.');
    }

    $req = $this->config->get_pdo()->prepare('DELETE FROM medias WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);

    if (!$req->execute()) {
      return create_response(
        ResponseStatusEnum::SERVER_ERROR,
        'Failed to delete media. Please delete usage in posters first.'
      );
    }

    // invalidate cache
    $_SESSION[RouteEnum::GET_ALL_MEDIA->get_cache_key()] = [];

    return create_response(ResponseStatusEnum::SUCCESS, 'Media deleted successfully.');
  }
}
