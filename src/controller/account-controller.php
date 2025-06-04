<?php

namespace controller;

use Config;
use RegexEnum;
use ResponseStatusEnum;
use PDO;
use RouteEnum;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class AccountController
{
  private Config $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function update_account(array $data): array
  {
    check_auth_status();

    $username = htmlspecialchars(trim($data['username']));
    $x_username = htmlspecialchars(trim($data['x_username']));
    $truthsocial_username = htmlspecialchars(trim($data['truthsocial_username']));

    if (empty($username)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Username is required.');
    }

    if (!empty($x_username) && !preg_match(RegexEnum::NAME->get_pattern(), $x_username)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid X username.');
    }

    if (!empty($truthsocial_username) && !preg_match(RegexEnum::NAME->get_pattern(), $truthsocial_username)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid Truth Social username.');
    }

    if ($username !== $_SESSION['user']['username']) {
      $req = $this->config->get_pdo()->prepare('SELECT * FROM users WHERE username = :username');
      $req->execute(['username' => $username]);
      $user = $req->fetch();

      if ($user) {
        return create_response(ResponseStatusEnum::BAD_REQUEST, 'Username already exists.');
      }
    }

    $req = $this->config
      ->get_pdo()
      ->prepare(
        'UPDATE users SET username = :username, x = :x_username, truth_social = :truthsocial_username WHERE id = :id'
      );
    $result = $req->execute([
      'username' => $username,
      'x_username' => $x_username === '' ? null : $x_username,
      'truthsocial_username' => $truthsocial_username === '' ? null : $truthsocial_username,
      'id' => $_SESSION['user']['id'],
    ]);

    if (!$result) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to update account.');
    }

    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['x'] = $x_username;
    $_SESSION['user']['truth_social'] = $truthsocial_username;

    return create_response(ResponseStatusEnum::SUCCESS, 'Account updated successfully.');
  }

  public function delete_auth_user(): array
  {
    check_auth_status();

    if (!isset($_SESSION['user']['id'])) {
        return create_response(ResponseStatusEnum::BAD_REQUEST, 'No user authenticated.');
    }

    $id = $_SESSION['user']['id'];

    if (!is_numeric($id) || $id <= 0) {
        return create_response(ResponseStatusEnum::BAD_REQUEST, 'Invalid account id provided.');
    }

    try {
        $req = $this->config->get_pdo()->prepare('DELETE FROM users WHERE id = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
    } catch (\PDOException $e) {
        if ($e->getCode() == 23503) {
            return create_response(
                ResponseStatusEnum::SERVER_ERROR,
                'Failed to delete account. This account is currently in use and cannot be deleted.'
            );
        }

        return create_response(ResponseStatusEnum::SERVER_ERROR, 'An unexpected error occurred while deleting account.');
    }

    return create_response(ResponseStatusEnum::SUCCESS, 'Account deleted successfully.');
  }
}
