<?php
    class Author {
        // DB stuff
        private $conn;
        private $table = 'authors';

        // Author Properties
        public $id;
        public $author;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get authors
        public function read() {
            // Create query
            $query = 'SELECT
                    id,
                    author
                FROM
                    ' . $this->table;

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        // Get Single author by author id
        public function read_single() {
            // Create Query
            $query = 'SELECT
                    id,
                    author
                FROM
                    ' . $this->table . '
                WHERE
                    id = ?
                LIMIT 0,1';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->author = $row['author'];
        }

        // Create Author
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    author = :author';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind data
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something went wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;
        }

        // Update author
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    author = :author
                WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;
        }

        // Delete author
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