<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Quote Properties
        public $id;
        public $quote;
        public $author;
        public $author_id;
        public $category;
        public $category_id;

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
            $stmt->bindParam(1, $this->id);

            // Execute Query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
        }
    }
?>