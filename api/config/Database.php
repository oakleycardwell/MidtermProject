<?php

namespace api\config;
use http\Exception;
use PDO;
use PDOException;

class Database
{
    private $host = getenv('DB_HOST');
    private $db = getenv('DB_NAME');
    private $username = getenv('DB_USER');
    private $password = getenv('DB_PASSWORD');


    public function getConnection()
    {
        ini_set('error_log', 'C:\Users\oakle\OneDrive\Desktop\Spring 2024\Backend Dev\MidtermProject\error.log');
        $dsn = "pgsql:host=" . $this->host . ";port=5432;dbname=" . $this->db . ";user=" . $this->username . ";password=" . $this->password;
        try {
            return new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            // Return false or null if the connection could not be established
            return false;
        }
    }
}
