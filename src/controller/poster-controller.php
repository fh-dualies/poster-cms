<?php

namespace controller;

use Config;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class PosterController
{
  private Config $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function get_all(): ?array
  {
    check_auth_status();

    $req = $this->config->get_pdo()->prepare('SELECT * FROM posters');
    $req->execute();

    return $req->fetchAll() ?: null;
  }

  public function get_by_id(int $id): ?array
  {
    check_auth_status();

    $query = '
        SELECT 
            posters.id AS poster_id, 
            posters.user_id, 
            posters.author, 
            posters.creation_date, 
            posters.headline, 
            posters.meta_data, 
            sections.id AS section_id, 
            sections.headline AS section_headline, 
            sections.text AS section_text, 
            medias.id AS media_id, 
            medias.type AS media_type, 
            medias.path AS media_path, 
            medias.alt AS media_alt
        FROM posters
        LEFT JOIN sections ON sections.poster_id = posters.id
        LEFT JOIN medias ON sections.media_id = medias.id
        WHERE posters.id = :id
    ';

    $req = $this->config->get_pdo()->prepare($query);
    $req->execute(['id' => $id]);

    $rows = $req->fetchAll();

    if (!$rows) {
      return null;
    }

    $poster = [
      'id' => $rows[0]['poster_id'],
      'user_id' => $rows[0]['user_id'],
      'author' => $rows[0]['author'],
      'creation_date' => $rows[0]['creation_date'],
      'headline' => $rows[0]['headline'],
      'meta_data' => $rows[0]['meta_data'],
      'sections' => [],
    ];

    foreach ($rows as $row) {
      $poster['sections'][] = [
        'id' => $row['section_id'],
        'headline' => $row['section_headline'],
        'text' => $row['section_text'],
        'media' => $row['media_id']
          ? [
            'id' => $row['media_id'],
            'type' => $row['media_type'],
            'path' => $row['media_path'],
            'alt' => $row['media_alt'],
          ]
          : null,
      ];
    }

    return $poster;
  }
}
