<?php

namespace api\models;

use PDO;

class Author {
    // Database connection and table name
    private $conn;
    private $table_name = "authors";

    // Object properties
    public $id;
    public $author;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // READ authors
    public function read() {
        // Create query
        $query = "SELECT
                    id, author
                  FROM
                    " . $this->table_name;

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // READ single author
    public function read_single() {
        // Create query
        $query = "SELECT id, author FROM " . $this->table_name . " WHERE id = ? LIMIT 1";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row) {
            $this->author = $row['author'];
            return true;
        }

        return false;
    }

    //CREATE an author
    public function create()
    {
        // Create query
        $query = "INSERT INTO " . $this->table_name . " (author) VALUES (:author)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind data
        $stmt->bindParam(':author', $this->author);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // UPDATE an author
    public function update() {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET author = :author WHERE id = :id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // DELETE an author
    public function delete() {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

}