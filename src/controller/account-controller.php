<?php

namespace controller;

use Config;
use PDO;
use PDOException;
use RegexEnum;
use ResponseStatusEnum;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class AccountController
{
  public function update_account(array $data): array
  {
    check_auth_status();

    $user_id = $_SESSION['user']['id'] ?? null;
    $current_username = $_SESSION['user']['username'] ?? '';

    if (!is_numeric($user_id) || (int) $user_id <= 0) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid user session.');
    }

    $username = htmlspecialchars(trim($data['username'] ?? ''));
    $x_username = htmlspecialchars(trim($data['x_username'] ?? ''));
    $truthsocial_username = htmlspecialchars(trim($data['truthsocial_username'] ?? ''));

    if ($username === '') {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Username is required.');
    }

    if ($x_username !== '' && !preg_match(RegexEnum::NAME->get_pattern(), $x_username)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid X username.');
    }

    if ($truthsocial_username !== '' && !preg_match(RegexEnum::NAME->get_pattern(), $truthsocial_username)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid Truth Social username.');
    }

    if ($username !== $current_username) {
      try {
        $stmt = Config::get_pdo()->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $count = (int) $stmt->fetchColumn();

        if ($count > 0) {
          return create_response(ResponseStatusEnum::BAD_REQUEST, 'Username already exists.');
        }
      } catch (PDOException $e) {
        return create_response(
          ResponseStatusEnum::SERVER_ERROR,
          'An unexpected error occurred while checking username availability.'
        );
      }
    }

    try {
      $stmt = Config::get_pdo()->prepare(
        'UPDATE users
                 SET username = :username,
                     x = :x_handle,
                     truth_social = :truthsocial_handle
                 WHERE id = :id'
      );

      $params = [
        ':username' => $username,
        ':x_handle' => $x_username === '' ? null : $x_username,
        ':truthsocial_handle' => $truthsocial_username === '' ? null : $truthsocial_username,
        ':id' => $user_id,
      ];

      if (!$stmt->execute($params)) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to execute update.');
      }

      if ($stmt->rowCount() === 0) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'No changes were made to the account.');
      }
    } catch (PDOException $e) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An unexpected error occurred while updating account.');
    }

    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['x'] = $x_username;
    $_SESSION['user']['truth_social'] = $truthsocial_username;

    return create_response(ResponseStatusEnum::SUCCESS, 'Account updated successfully.');
  }

  public function delete_account(): array
  {
    check_auth_status();

    $user_id = $_SESSION['user']['id'] ?? null;

    if (!is_numeric($user_id) || (int) $user_id <= 0) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid account id provided.');
    }

    try {
      $stmt = Config::get_pdo()->prepare('DELETE FROM users WHERE id = :id');
      $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

      if (!$stmt->execute()) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to execute delete.');
      }

      if ($stmt->rowCount() === 0) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'No account was deleted.');
      }
    } catch (PDOException $e) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An unexpected error occurred while deleting account.');
    }

    return create_response(ResponseStatusEnum::SUCCESS, 'Account deleted successfully.');
  }
}
