<?php
    class Database {
        // DB Params
        private $host;
        private $database;
        private $username;
        private $password;
        private $conn;

        // DB Connect
        public function connect() {
            $url = getenv('JAWSDB_URL');
            $dbparts = parse_url($url);

            $this->host = $dbparts['host'];
            $this->username = $dbparts['user'];
            $this->password = $dbparts['pass'];
            $this->database = ltrim($dbparts['path'],'/');

            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully";
            } catch(PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            return $this->conn;
        }
    }
?>