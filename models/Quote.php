<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Quote Properties
        public $id;
        public $quote;
        public $author;
        public $category;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            // Create query
            $query = 'SELECT
                    q.id as id,
                    q.quote as quote,
                    a.author as author,
                    c.category as category
                FROM
                    ' . $this->table . ' q
                CROSS JOIN
                    authors a ON a.id = q.authorId
                CROSS JOIN
                    categories c ON c.id = q.categoryId
                ORDER BY
                    q.id DESC';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute Query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Quote by quote id
        public function read_single() {
            // Create Query
            $query = 'SELECT
                    q.id as id,
                    q.quote as quote,
                    a.author as author,
                    c.category as category
                FROM
                    ' . $this->table . ' q
                CROSS JOIN
                    authors a ON a.id = q.authorId
                CROSS JOIN
                    categories c ON c.id = q.categoryId
                WHERE
                    q.id = ?
                LIMIT 0,1';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
        }

        // Get Quote by author id
        public function read_by_author_id() {
            // Create Query
            $query = 'SELECT
                    q.id as id,
                    q.quote as quote,
                    a.author as author,
                    c.category as category
                FROM
                    ' . $this->table . ' q
                CROSS JOIN
                    authors a ON a.id = q.authorId
                CROSS JOIN
                    categories c ON c.id = q.categoryId
                WHERE
                    q.authorId = :authorId';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':authorId', $this->authorId);

            // Execute Query
            $stmt->execute();
            return $stmt;
        }

        // Get Quotes by category id
        public function read_by_category_id() {
            // Create Query
            $query = 'SELECT
                    q.id as id,
                    q.quote as quote,
                    a.author as author,
                    c.category as category
                FROM
                    ' . $this->table . ' q
                CROSS JOIN
                    authors a ON a.id = q.authorId
                CROSS JOIN
                    categories c ON c.id = q.categoryId
                WHERE
                    q.categoryId = :categoryId';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':categoryId', $this->categoryId);

            // Execute Query
            $stmt->execute();
            return $stmt;
        }

        // Get Quote by author and category id
        public function read_by_author_and_category_id() {
            // Create Query
            $query = 'SELECT
                    q.id as id,
                    q.quote as quote,
                    a.author as author,
                    c.category as category
                FROM
                    ' . $this->table . ' q
                CROSS JOIN
                    authors a ON a.id = q.authorId
                CROSS JOIN
                    categories c ON c.id = q.categoryId
                WHERE
                    q.authorId = :authorId && q.categoryId = :categoryId';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            // Execute Query
            $stmt->execute();
            return $stmt;
        }

        // Create Quote
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET
                    qoute = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            // Bind params
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something went wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;
        }

        // Update Quote
        public function update() {
            // Create query
            $query = 'UPDATE ' . $this->table . '
                SET
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId
                WHERE
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Message: '%s'\n", $stmt->error);

            return false;
        }

        // Delete Quote
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
            printf("Error: '%s'\n", $stmt->error);

            return false;            
        }
    }
?>