<?php

namespace controller;

use Config;
use ResponseStatusEnum;
use PDOException;

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

  public function get_all(): array
  {
    check_auth_status();

    $req = $this->config->get_pdo()->prepare('SELECT * FROM posters');
    $req->execute();

    return $req->fetchAll() ?: [];
  }

  public function get_by_id(int $id): array
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
    $req->execute(['id' => htmlspecialchars(trim($id))]);

    $rows = $req->fetchAll();

    if (!$rows) {
      return [];
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

    public function create_poster(array $data): array
    {
        check_auth_status();

        $userId = $_SESSION['user']['id'];

        $author = htmlspecialchars(trim($data['poster-author'] ?? ''));
        $creationDate = htmlspecialchars(trim($data['poster-date'] ?? ''));
        $headline = htmlspecialchars(trim($data['headline'] ?? ''));
        $metaData = htmlspecialchars(trim($data['poster-footer'] ?? ''));

        // Validierung
        if (empty($author) || empty($creationDate) || empty($headline)) {
            return create_response(ResponseStatusEnum::BAD_REQUEST, 'Author, date and headline are required.');
        }

        try {
            $pdo = $this->config->get_pdo();

            $stmt = $pdo->prepare('
      INSERT INTO posters (user_id, author, creation_date, headline, meta_data)
      VALUES (:user_id, :author, :creation_date, :headline, :meta_data)
    ');

            $stmt->execute([
                'user_id' => $userId,
                'author' => $author,
                'creation_date' => $creationDate,
                'headline' => $headline,
                'meta_data' => $metaData,
            ]);

            $posterId = $pdo->lastInsertId();

            for ($i = 1; $i <= 3; $i++) {
                $secHeadline = htmlspecialchars(trim($data["s{$i}headline"] ?? ''));
                $secText = htmlspecialchars(trim($data["s{$i}text"] ?? ''));
                $secImgId = isset($data["s{$i}img"]) && is_numeric($data["s{$i}img"]) ? (int)$data["s{$i}img"] : null;

                if (!empty($secHeadline)) {
                    $stmt = $pdo->prepare('
                    INSERT INTO sections (poster_id, headline, text, media_id)
                    VALUES (:poster_id, :headline, :text, :media_id)
                ');
                    $stmt->execute([
                        'poster_id' => $posterId,
                        'headline' => $secHeadline,
                        'text' => $secText,
                        'media_id' => $secImgId,
                    ]);
                }
            }
            $pdo->commit();
        } catch (PDOException $e) {
            return create_response(ResponseStatusEnum::SERVER_ERROR, 'An error occurred while creating the poster.');
        }

        return create_response(ResponseStatusEnum::SUCCESS, 'Poster created successfully.');
    }

  public function delete_by_id(array $data): array
  {
    check_auth_status();

    $posterId = htmlspecialchars(trim($data['poster_id'] ?? ''));

    if (!is_numeric($posterId) || $posterId <= 0) {
            return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid poster ID.');
    }

    try {
            $pdo = $this->config->get_pdo();
            $stmt = $pdo->prepare('DELETE FROM posters WHERE id = :id AND user_id = :user_id');
            $stmt->execute([
                'id' => $posterId,
                'user_id' => $_SESSION['user']['id'],
            ]);

            if ($stmt->rowCount() === 0) {
                return create_response(ResponseStatusEnum::BAD_REQUEST, 'Poster not found or access denied.');
            }
    } catch (PDOException $e) {
            return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to delete poster.');
    }

    return create_response(ResponseStatusEnum::SUCCESS, 'Poster deleted successfully.');
    }
}
