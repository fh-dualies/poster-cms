<?php

namespace controller;

use Config;
use PDO;
use PDOException;
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

    try {
      $stmt = $this->config->get_pdo()->prepare('SELECT * FROM medias');
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
      $stmt = $this->config->get_pdo()->prepare('DELETE FROM medias WHERE id = :id');
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

    if (!$file || !isset($file['name'], $file['tmp_name'], $file['type'], $file['error'])) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'File is required.');
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'File upload error.');
    }

    $file_name = htmlspecialchars(trim($file['name']));
    $file_tmp = $file['tmp_name'];
    $file_size = isset($file['size']) ? (int) $file['size'] : 0;
    $file_type = $file['type'];

    if (!in_array($file_type, Config::get_allowed_file_types(), true)) {
      return create_response(
        ResponseStatusEnum::BAD_REQUEST,
        'Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.'
      );
    }

    if ($file_size > Config::get_max_file_size()) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'File size exceeds the maximum limit of 5MB.');
    }

    $upload_dir = Config::get_upload_directory();

    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0755, true)) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to create upload directory.');
    }

    $absolute_path = $upload_dir . uniqid('', true) . '-' . basename($file_name);

    if (!move_uploaded_file($file_tmp, $absolute_path)) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to move uploaded file.');
    }

    $relative_path = substr($absolute_path, strpos($absolute_path, '_uploads'));

    try {
      $stmt = $this->config->get_pdo()->prepare(
        'INSERT INTO medias (name, alt, path, size, type)
                 VALUES (:name, :alt, :path, :size, :type)'
      );
      $stmt->execute([
        ':name' => $file_name,
        ':alt' => $file_name . ' (uploaded)',
        ':path' => $relative_path,
        ':size' => $file_size,
        ':type' => $file_type,
      ]);

      if ($stmt->rowCount() === 0) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to save media.');
      }
    } catch (PDOException $e) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An error occurred while saving the media.');
    }

    return create_response(ResponseStatusEnum::SUCCESS, 'Media saved.');
  }
}
