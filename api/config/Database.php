<?php

namespace api\config;
use PDO;
use PDOException;

class Database
{
    private $host = "34.133.234.4";
    private $db = "quotesdb";
    private $username = "postgres";
    private $password = "]Q%\"6nPKEIje:>[^";


    public function getConnection()
    {
        $dsn = "pgsql:host=" . $this->host . ";port=5432;dbname=" . $this->db . ";user=" . $this->username . ";password=" . $this->password;
        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return $pdo;
    }
}
