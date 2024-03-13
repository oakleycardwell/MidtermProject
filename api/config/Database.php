<?php

namespace api\config;
use http\Exception;
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
