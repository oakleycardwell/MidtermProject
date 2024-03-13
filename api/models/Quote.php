<?php

namespace api\models;

use PDO;

class Quote
{
    // Database connection and table name
    private $conn;
    private $table_name = "quotes";

    // Object properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author;    // to hold the name of the author from the authors table
    public $category;  // to hold the category name from the categories table

    // Constructor with DB connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ quotes
    public function read()
    {
        // Create query
        $query = "SELECT
                    q.id, q.quote, q.author_id, q.category_id, a.author, c.category
                  FROM
                    " . $this->table_name . " q
                    LEFT JOIN
                      authors a ON q.author_id = a.id
                    LEFT JOIN
                      categories c ON q.category_id = c.id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // READ single quote
    public function read_single()
    {
        // Create query
        $query = "SELECT
                q.id, q.quote, q.author_id, q.category_id, a.author, c.category
              FROM
                " . $this->table_name . " q
                LEFT JOIN
                  authors a ON q.author_id = a.id
                LEFT JOIN
                  categories c ON q.category_id = c.id
              WHERE
                  q.id = ?
              LIMIT 1";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        if ($row) {
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            return true;
        }

        return false;
    }

    // CREATE a quote
    public function create()
    {
        // Create query
        $query = "INSERT INTO " . $this->table_name . " (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // UPDATE a quote
    public function update()
    {
        // Update query
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                    WHERE
                    id = :id";
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // DELETE a quote
    public function delete()
    {
        // Delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

