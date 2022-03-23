<?php
    class Category {
        // DB stuff
        private $conn;
        private $table = 'categories';

        // Category Properties
        public $id;
        public $category;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get categories
        public function read() {
            // Create query
            $query = 'SELECT
                    id,
                    category
                FROM
                    ' . $this->table;

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        // Get Single category by category id
        public function read_single() {
            // Create Query
            $query = 'SELECT
                    id,
                    category
                FROM
                    ' . $this->table . '
                WHERE
                    id = ?
                LIMIT 0,1';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->category = $row['category'];
        }

        // Create Category
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '(category)
                VALUES (:category)';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(':category', $this->category);
            
            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something went wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;
        }

        // Update Category
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    category = :category
                WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;
        }

        // Delete Category
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind Param
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;            
        }
    }
?>