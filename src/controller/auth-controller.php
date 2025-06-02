<?php

namespace controller;

use Config;
use function check_auth_status;

require_once __DIR__ . '/../shared/file-path-enum.php';
require_once __DIR__ . '/../shared/regex-enum.php';
require_once __DIR__ . '/../shared/response-status-enum.php';
require_once __DIR__ . '/../shared/util.php';
require_once __DIR__ . '/../lib/config.php';

class AuthController
{
  private Config $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function login(array $data): array
  {
    if (isset($_SESSION['user'])) {
      return create_response(\ResponseStatusEnum::FORBIDDEN, 'You are already logged in.');
    }

    $email = htmlspecialchars(trim($data['email']));
    $password = trim($data['password']);

    if (empty($email) || empty($password)) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Email and password are required.');
    }

    if (!preg_match(\RegexEnum::EMAIL->get_pattern(), $email)) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid email');
    }

    $req = $this->config->get_pdo()->prepare('SELECT * FROM users WHERE email = :email');
    $req->execute(['email' => $email]);
    $user = $req->fetch();

    if ($user === false || !password_verify($password, $user['password'])) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Email or password invalid!');
    }

    $this->init_session($user);
    redirect_to_page(\FilePathEnum::HOME);

    return create_response(\ResponseStatusEnum::SUCCESS, 'Login successful!');
  }

  public function register(array $data): array
  {
    if (isset($_SESSION['user'])) {
      return create_response(\ResponseStatusEnum::FORBIDDEN, 'You are already logged in.');
    }

    $username = htmlspecialchars(trim($data['username']));
    $email = htmlspecialchars(trim($data['email']));
    $password = trim($data['password']);

    if (empty($username) || empty($email) || empty($password)) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Username, email and password are required.');
    }

    if (!preg_match(\RegexEnum::NAME->get_pattern(), $username)) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid username');
    }

    if (!preg_match(\RegexEnum::EMAIL->get_pattern(), $email)) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid email');
    }

    if (!preg_match(\RegexEnum::PASSWORD->get_pattern(), $password)) {
      return create_response(\ResponseStatusEnum::BAD_REQUEST, 'Please enter a valid password');
    }

    $req = $this->config->get_pdo()->prepare('SELECT * FROM users WHERE email = :email');
    $req->execute(['email' => $email]);
    $user = $req->fetch();

    if ($user !== false) {
      return create_response(\ResponseStatusEnum::FORBIDDEN, 'Email already exists!');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $req = $this->config
      ->get_pdo()
      ->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
    $result = $req->execute(['username' => $username, 'email' => $email, 'password' => $hash]);

    if (!$result) {
      return create_response(\ResponseStatusEnum::SERVER_ERROR, 'An error occurred while registering the user.');
    }

    redirect_to_page(\FilePathEnum::LOGIN);

    return create_response(\ResponseStatusEnum::SUCCESS, 'Registration successful!');
  }

  public function logout(): void
  {
    check_auth_status();

    session_destroy();
    session_unset();

    redirect_to_page(\FilePathEnum::LOGIN);
  }

  private function init_session(array $user): void
  {
    $_SESSION['user'] = $user;
  }
}
