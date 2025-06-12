<?php

namespace controller;

use Config;
use FilePathEnum;
use PDOException;
use RegexEnum;
use ResponseStatusEnum;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class AuthController
{
  public function login(array $data): array
  {
    if (isset($_SESSION['user'])) {
      return create_response(ResponseStatusEnum::FORBIDDEN, 'You are already logged in.');
    }

    $email = htmlspecialchars(trim($data['email'] ?? ''));
    $password = trim($data['password'] ?? '');

    if ($email === '' || $password === '') {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Email and password are required.');
    }

    if (!preg_match(RegexEnum::EMAIL->get_pattern(), $email)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid email.');
    }

    try {
      $stmt = Config::get_pdo()->prepare('SELECT * FROM users WHERE email = :email');
      $stmt->execute([':email' => $email]);
      $user = $stmt->fetch();
    } catch (PDOException $e) {
      return create_response(ResponseStatusEnum::SERVER_ERROR, 'An unexpected error occurred while retrieving user.');
    }

    if ($user === false || !password_verify($password, $user['password'])) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Email or password invalid!');
    }

    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'email' => $user['email'],
      'x' => $user['x'],
      'truth_social' => $user['truth_social'],
    ];

    redirect_to_page(FilePathEnum::HOME);

    return create_response(ResponseStatusEnum::SUCCESS, 'Login successful!');
  }

  public function register(array $data): array
  {
    if (isset($_SESSION['user'])) {
      return create_response(ResponseStatusEnum::FORBIDDEN, 'You are already logged in.');
    }

    $username = htmlspecialchars(trim($data['username'] ?? ''));
    $email = htmlspecialchars(trim($data['email'] ?? ''));
    $password = trim($data['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Username, email and password are required.');
    }

    if (!preg_match(RegexEnum::NAME->get_pattern(), $username)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid username.');
    }

    if (!preg_match(RegexEnum::EMAIL->get_pattern(), $email)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid email.');
    }

    if (!preg_match(RegexEnum::PASSWORD->get_pattern(), $password)) {
      return create_response(ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid password.');
    }

    try {
      $stmt = Config::get_pdo()->prepare('SELECT COUNT(*) FROM users WHERE email = :email OR username = :username');
      $stmt->execute([
        ':email' => $email,
        ':username' => $username,
      ]);

      $count = (int) $stmt->fetchColumn();

      if ($count > 0) {
        return create_response(ResponseStatusEnum::FORBIDDEN, 'Email or username already exists!');
      }
    } catch (PDOException $e) {
      return create_response(
        ResponseStatusEnum::SERVER_ERROR,
        'An unexpected error occurred while checking existing users.'
      );
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
      $stmt = Config::get_pdo()->prepare(
        'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
      );
      $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $hash,
      ]);

      if ($stmt->rowCount() === 0) {
        return create_response(ResponseStatusEnum::SERVER_ERROR, 'Failed to register the user.');
      }
    } catch (PDOException $e) {
      return create_response(
        ResponseStatusEnum::SERVER_ERROR,
        'An unexpected error occurred while registering the user.'
      );
    }

    redirect_to_page(FilePathEnum::LOGIN);

    return create_response(ResponseStatusEnum::SUCCESS, 'Registration successful!');
  }

  public function logout(): void
  {
    check_auth_status();

    session_destroy();

    redirect_to_page(FilePathEnum::LOGIN);
  }
}
