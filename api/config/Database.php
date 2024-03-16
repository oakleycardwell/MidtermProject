<?php

namespace api\config;
use http\Exception;
use PDO;
use PDOException;

define('DB_HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
class Database
{
    private $host;
    private $db;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->db = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;

    }


    public function getConnection()
    {
        $dsn = "pgsql:host=" . $this->host . ";port=5432;dbname=" . $this->db . ";user=" . $this->username . ";password=" . $this->password;

        try {
            return new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            // Return false or null if the connection could not be established
            return false;
        }
    }
}
