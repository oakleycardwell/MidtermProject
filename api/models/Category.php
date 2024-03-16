<?php

namespace api\models;

use PDO;

class Category {
    // Database connection and table name
    private $conn;
    private $table_name = "categories";

    // Object properties
    public $id;
    public $category;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // READ categories
    public function read() {
        // Create query
        $query = "SELECT id, category FROM " . $this->table_name;

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // READ single category
    public function read_single() {
        // Create query
        $query = "SELECT id, category FROM " . $this->table_name . " WHERE id = ? LIMIT 1";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row) {
            $this->category = $row['category'];
            return true;
        }

        return false;
    }

    // CREATE a category
    public function create() {
        // Create query
        $query = "INSERT INTO " . $this->table_name . " (category) VALUES (:category)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind data
        $stmt->bindParam(':category', $this->category);

        // Execute query
        if ($stmt->execute()) {
            // Fetch the last inserted ID and set it to the id property
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    // UPDATE a category
    public function update() {
        // Update query
        $query = "UPDATE " . $this->table_name . " SET category = :category WHERE id = :id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // DELETE a category
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