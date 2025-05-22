<?php

namespace lib;

class Config
{
    protected string $db_host;
    protected string $db_user;
    protected string $db_pass;
    protected string $db_name;

    public function __construct()
    {
        $this->db_host = getenv('DB_HOST') ?: 'localhost';
        $this->db_user = getenv('DB_USER') ?: 'root';
        $this->db_pass = getenv('DB_PASS') ?: '';
        $this->db_name = getenv('DB_NAME') ?: 'my_database';
    }

    public function get_pdo(): \PDO
    {
        $dsn = "mysql:host=$this->db_host;dbname=$this->db_name";

        return new \PDO($dsn, $this->db_user, $this->db_pass);
    }
}