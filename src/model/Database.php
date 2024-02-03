<?php
    const DEFAULT_HOST = "localhost";
    const DEFAULT_USERNAME = "root";
    const DEFAULT_PASSWORD = "";
    const DEFAULT_DB_NAME = "test db";
    const DEFAULT_CHARSET = "utf8";

    class FETCH_TYPE {
        const ALL = 'all';
        const FIRST = 'first';
    }

    class Database {
        private string $host;
        private string $username;
        private string $password;
        private string $dbname;
        private string $charset;
    
        private PDO $pdo;
    
        public function __construct(string $host = DEFAULT_HOST, string $username = DEFAULT_USERNAME, string $password = DEFAULT_PASSWORD, 
                                    string $dbname = DEFAULT_DB_NAME, string $charset = DEFAULT_CHARSET) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
            $this->charset = $charset;
    
            $this->connect();
        }
    
        private function connect() {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
    
            try {
                $this->pdo = new PDO($dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
    
        public function query($sql, $params = [], ?string $fetchType = null) {
            $statement = $this->pdo->prepare($sql);

            try {
                $statement->execute($params);

                switch ($fetchType) {
                    case FETCH_TYPE::ALL:
                        return $statement->fetchAll(PDO::FETCH_ASSOC);
                        break;
                    case FETCH_TYPE::FIRST:
                            return $statement->fetch(PDO::FETCH_ASSOC);
                            break;
                    default:
                        return $statement->fetch(PDO::FETCH_ASSOC);
                        break;
                }
            } catch (PDOException $e) {
                throw new Exception("Database error: " . $e->getMessage());
            }
        }
    
        public function lastInsertId() {
            return $this->pdo->lastInsertId();
        }
    }
?>