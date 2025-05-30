<?php

class Config
{
  protected string $db_host;
  protected string $db_port;
  protected string $db_user;
  protected string $db_pass;
  protected string $db_name;

  public function __construct()
  {
    $this->db_host = getenv('DB_HOST') ?: 'localhost';
    $this->db_port = getenv('DB_PORT') ?: '5432';
    $this->db_user = getenv('DB_USER') ?: 'admin';
    $this->db_pass = getenv('DB_PASS') ?: 'admin';
    $this->db_name = getenv('DB_NAME') ?: 'www';
  }

  public function get_pdo(): \PDO
  {
    $dsn = "pgsql:host=$this->db_host;port=$this->db_port;dbname=$this->db_name";

    return new \PDO($dsn, $this->db_user, $this->db_pass);
  }
}
