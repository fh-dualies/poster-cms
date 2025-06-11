<?php

namespace controller;

use Config;
use InvalidArgumentException;
use PDO;
use PDOException;
use ResponseStatusEnum;
use RuntimeException;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class MediaController
{
  public function get_all(): array
  {
    check_auth_status();

    try {
      $stmt = Config::get_pdo()->prepare('SELECT * FROM medias');
      $stmt->execute();

      return $stmt->fetchAll() ?: [];
    } catch (PDOException $e) {
      return [];
    }
  }

  public function delete_by_id(array $data): array
  {
    check_auth_status();

    if (!isset($data['id'])) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Media id is required.');
    }

    $media_id = htmlspecialchars(trim($data['id']));

    if (!is_numeric($media_id) || (int) $media_id <= 0) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid media id provided.');
    }

    try {
      $stmt = Config::get_pdo()->prepare('DELETE FROM medias WHERE id = :id');
      $stmt->bindParam(':id', $media_id, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'No media was deleted.');
      }
    } catch (PDOException $e) {
      if ($e->getCode() == 23503) {
        return create_response(
          ResponseStatusEnum::SERVER_ERROR,
          'Failed to delete media. This media is currently in use and cannot be deleted.'
        );
      }

      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An unexpected error occurred while deleting media.');
    }

    return create_response(ResponseStatusEnum::SUCCESS, 'Media deleted successfully.');
  }

  public function create_media(array $data): array
  {
    check_auth_status();

    $file = $data['file'] ?? null;

    if (!$file) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'File is required.');
    }

    try {
      self::save_media_file($file);

      return create_response(ResponseStatusEnum::SUCCESS, 'Media saved.');
    } catch (InvalidArgumentException $e) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, $e->getMessage());
    } catch (RuntimeException | PDOException $e) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, $e->getMessage());
    }
  }

  public static function save_media_file(array $file): int
  {
    $fileInfo = self::validate_and_store_file($file);

    $stmt = Config::get_pdo()->prepare(
      'INSERT INTO medias (name, alt, path, size, type)
         VALUES (:name, :alt, :path, :size, :type)
         RETURNING id'
    );
    $stmt->execute([
      ':name' => $fileInfo['name'],
      ':alt' => $fileInfo['name'] . ' (uploaded)',
      ':path' => $fileInfo['path'],
      ':size' => $fileInfo['size'],
      ':type' => $fileInfo['type'],
    ]);

    $newId = $stmt->fetchColumn();

    if (!$newId) {
      throw new RuntimeException('Failed to save media.');
    }

    return (int) $newId;
  }

  private static function validate_and_store_file(array $file): array
  {
    if (!isset($file['name'], $file['tmp_name'], $file['type'], $file['error'])) {
      throw new InvalidArgumentException('File data is incomplete.');
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
      throw new InvalidArgumentException('File upload error.');
    }

    $file_name = htmlspecialchars(trim($file['name']));
    $file_tmp = $file['tmp_name'];
    $file_size = isset($file['size']) ? (int) $file['size'] : 0;
    $file_type = $file['type'];

    if (!in_array($file_type, Config::get_allowed_file_types(), true)) {
      throw new InvalidArgumentException('Invalid file type. Only JPEG, PNG, GIF, SVG, and WEBP are allowed.');
    }

    if ($file_size > Config::get_max_file_size()) {
      throw new InvalidArgumentException('File size exceeds the maximum limit of 5MB.');
    }

    $upload_dir = Config::get_upload_directory();

    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0755, true)) {
      throw new RuntimeException('Failed to create upload directory.');
    }

    $absolute_path = $upload_dir . uniqid('', true) . '-' . basename($file_name);

    if (!move_uploaded_file($file_tmp, $absolute_path)) {
      throw new RuntimeException('Failed to move uploaded file.');
    }

    $relative_path = substr($absolute_path, strpos($absolute_path, '_uploads'));

    return [
      'name' => $file_name,
      'path' => $relative_path,
      'size' => $file_size,
      'type' => $file_type,
    ];
  }
}
