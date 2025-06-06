<?php

namespace controller;

use Config;
use PDOException;
use ResponseStatusEnum;
use RouteEnum;

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

    try {
      $stmt = $this->config->get_pdo()->prepare('SELECT * FROM posters');
      $stmt->execute();
      return $stmt->fetchAll() ?: [];
    } catch (PDOException $e) {
      return [];
    }
  }

  public function get_by_id(int $id): array
  {
    check_auth_status();

    if ($id <= 0) {
      return [];
    }

    $query = '
            SELECT
                p.id            AS poster_id,
                p.user_id       AS user_id,
                p.author        AS author,
                p.creation_date AS creation_date,
                p.headline      AS headline,
                p.meta_data     AS meta_data,
                s.id            AS section_id,
                s.headline      AS section_headline,
                s.text          AS section_text,
                m.id            AS media_id,
                m.type          AS media_type,
                m.path          AS media_path,
                m.alt           AS media_alt
            FROM posters AS p
            LEFT JOIN sections AS s ON s.poster_id = p.id
            LEFT JOIN medias   AS m ON s.media_id  = m.id
            WHERE p.id = :id
        ';

    try {
      $stmt = $this->config->get_pdo()->prepare($query);
      $stmt->execute([':id' => $id]);
      $rows = $stmt->fetchAll();
    } catch (PDOException $e) {
      return [];
    }

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

    $user_id = $_SESSION['user']['id'] ?? null;
    $author = trim(htmlspecialchars($data['poster-author'] ?? ''));
    $creation_date = trim(htmlspecialchars($data['poster-date'] ?? ''));
    $headline = trim(htmlspecialchars($data['headline'] ?? ''));
    $meta_data = trim(htmlspecialchars($data['poster-footer'] ?? ''));

    if (!$user_id || $author === '' || $creation_date === '' || $headline === '') {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Author, date and headline are required.');
    }

    $pdo = $this->config->get_pdo();

    try {
      $pdo->beginTransaction();

      $insert_poster_sql = '
                INSERT INTO posters
                    (user_id, author, creation_date, headline, meta_data)
                VALUES
                    (:user_id, :author, :creation_date, :headline, :meta_data)
            ';
      $poster_stmt = $pdo->prepare($insert_poster_sql);
      $poster_stmt->execute([
        ':user_id' => $user_id,
        ':author' => $author,
        ':creation_date' => $creation_date,
        ':headline' => $headline,
        ':meta_data' => $meta_data,
      ]);

      if ($poster_stmt->rowCount() === 0) {
        $pdo->rollBack();
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to create poster.');
      }

      $poster_id = (int) $pdo->lastInsertId();

      $insert_media_sql = '
                INSERT INTO medias
                    (name, alt, path, size, type)
                VALUES
                    (:name, :alt, :path, :size, :type)
            ';
      $media_stmt = $pdo->prepare($insert_media_sql);

      $insert_section_sql = '
                INSERT INTO sections
                    (poster_id, section_index, headline, text, media_id)
                VALUES
                    (:poster_id, :section_index, :headline, :text, :media_id)
            ';
      $section_stmt = $pdo->prepare($insert_section_sql);

      for ($i = 1; $i <= 3; $i++) {
        $sec_headline = trim(htmlspecialchars($data["s{$i}headline"] ?? ''));
        $sec_text = trim(htmlspecialchars($data["s{$i}text"] ?? ''));
        $sec_img_path = trim($data["s{$i}img"] ?? '');

        if ($sec_headline === '') {
          continue;
        }

        $media_id = null;
        if ($sec_img_path !== '') {
          $path = htmlspecialchars($sec_img_path);
          $name = basename($path);
          $alt = "Image for section {$i}";
          $size = 0;
          $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
          $type = match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'application/octet-stream',
          };

          $media_stmt->execute([
            ':name' => $name,
            ':alt' => $alt,
            ':path' => $path,
            ':size' => $size,
            ':type' => $type,
          ]);

          $media_id = (int) $pdo->lastInsertId();
        }

        $section_stmt->execute([
          ':poster_id' => $poster_id,
          ':section_index' => $i,
          ':headline' => $sec_headline,
          ':text' => $sec_text,
          ':media_id' => $media_id,
        ]);
      }

      $pdo->commit();
    } catch (PDOException $e) {
      $pdo->rollBack();
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An error occurred while creating the poster.');
    }

    // Invalidate cache
    $_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()] = [];

    return create_response(ResponseStatusEnum::SUCCESS, 'Poster created successfully.');
  }

  public function update_poster(array $data): array
  {
    check_auth_status();

    $poster_id = isset($data['poster_id']) ? (int) $data['poster_id'] : 0;
    $user_id = $_SESSION['user']['id'] ?? null;
    $author = trim(htmlspecialchars($data['poster-author'] ?? ''));
    $creation_date = trim(htmlspecialchars($data['poster-date'] ?? ''));
    $headline = trim(htmlspecialchars($data['headline'] ?? ''));
    $meta_data = trim(htmlspecialchars($data['poster-footer'] ?? ''));

    if ($poster_id <= 0 || !$user_id || $author === '' || $creation_date === '' || $headline === '') {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid input or missing fields.');
    }

    $pdo = $this->config->get_pdo();

    try {
      $pdo->beginTransaction();

      $update_poster_sql = '
                UPDATE posters
                SET
                    author        = :author,
                    creation_date = :creation_date,
                    headline      = :headline,
                    meta_data     = :meta_data
                WHERE
                    id      = :poster_id
                    AND user_id = :user_id
            ';
      $poster_stmt = $pdo->prepare($update_poster_sql);
      $poster_stmt->execute([
        ':author' => $author,
        ':creation_date' => $creation_date,
        ':headline' => $headline,
        ':meta_data' => $meta_data,
        ':poster_id' => $poster_id,
        ':user_id' => $user_id,
      ]);

      if ($poster_stmt->rowCount() === 0) {
        $pdo->rollBack();
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'Poster update failed or no changes made.');
      }

      $insert_media_sql = '
                INSERT INTO medias
                    (name, alt, path, size, type)
                VALUES
                    (:name, :alt, :path, :size, :type)
            ';
      $media_stmt = $pdo->prepare($insert_media_sql);

      $select_section_sql = '
                SELECT id
                FROM sections
                WHERE poster_id     = :poster_id
                  AND section_index = :section_index
            ';
      $select_section_stmt = $pdo->prepare($select_section_sql);

      $insert_section_sql = '
                INSERT INTO sections
                    (poster_id, section_index, headline, text, media_id)
                VALUES
                    (:poster_id, :section_index, :headline, :text, :media_id)
            ';
      $insert_section_stmt = $pdo->prepare($insert_section_sql);

      $update_section_sql = '
                UPDATE sections
                SET
                    headline = :headline,
                    text     = :text,
                    media_id = :media_id
                WHERE
                    poster_id     = :poster_id
                    AND section_index = :section_index
            ';
      $update_section_stmt = $pdo->prepare($update_section_sql);

      for ($i = 1; $i <= 3; $i++) {
        $sec_headline = trim(htmlspecialchars($data["s{$i}headline"] ?? ''));
        $sec_text = trim(htmlspecialchars($data["s{$i}text"] ?? ''));
        $sec_img_path = trim($data["s{$i}img"] ?? '');

        if ($sec_headline === '') {
          continue;
        }

        $media_id = null;
        if ($sec_img_path !== '') {
          $path = htmlspecialchars($sec_img_path);
          $name = basename($path);
          $alt = "Image for section {$i}";
          $size = 0;
          $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
          $type = match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'application/octet-stream',
          };

          $media_stmt->execute([
            ':name' => $name,
            ':alt' => $alt,
            ':path' => $path,
            ':size' => $size,
            ':type' => $type,
          ]);

          $media_id = (int) $pdo->lastInsertId();
        }

        $select_section_stmt->execute([
          ':poster_id' => $poster_id,
          ':section_index' => $i,
        ]);

        if ($select_section_stmt->fetchColumn()) {
          // Update existing section
          $update_section_stmt->execute([
            ':headline' => $sec_headline,
            ':text' => $sec_text,
            ':media_id' => $media_id,
            ':poster_id' => $poster_id,
            ':section_index' => $i,
          ]);
        } else {
          // Insert new section
          $insert_section_stmt->execute([
            ':poster_id' => $poster_id,
            ':section_index' => $i,
            ':headline' => $sec_headline,
            ':text' => $sec_text,
            ':media_id' => $media_id,
          ]);
        }
      }

      $pdo->commit();
    } catch (PDOException $e) {
      $pdo->rollBack();
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An error occurred while updating the poster.');
    }

    // Invalidate cache
    $_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()] = [];

    return create_response(ResponseStatusEnum::SUCCESS, 'Poster updated successfully.');
  }

  public function delete_by_id(array $data): array
  {
    check_auth_status();

    $poster_id = trim(htmlspecialchars($data['poster_id'] ?? ''));

    if (!is_numeric($poster_id) || (int) $poster_id <= 0) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid poster ID.');
    }

    $poster_id = (int) $poster_id;
    $user_id = $_SESSION['user']['id'] ?? null;

    try {
      $stmt = $this->config->get_pdo()->prepare('DELETE FROM posters WHERE id = :id AND user_id = :user_id');
      $stmt->execute([
        ':id' => $poster_id,
        ':user_id' => $user_id,
      ]);

      if ($stmt->rowCount() === 0) {
        return create_response(ResponseStatusEnum::BAD_REQUEST, 'Poster not found or access denied.');
      }
    } catch (PDOException $e) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to delete poster.');
    }

    // Invalidate cache
    $_SESSION[RouteEnum::GET_ALL_POSTERS->get_cache_key()] = [];

    return create_response(ResponseStatusEnum::SUCCESS, 'Poster deleted successfully.');
  }
}
