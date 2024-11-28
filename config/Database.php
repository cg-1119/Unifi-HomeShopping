<?php
class Database {
    private $host = "localhost";
    private $port = 3306;
    private $user = "root";
    private $password = "root";
    private $dbname = "shopmall";
    private $pdo;
    public function connect() {
        if (!$this->pdo) {
            try {
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8";
                $this->pdo = new PDO($dsn, $this->user, $this->password);

                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
    public function close() {
        $this->pdo = null; // 연결 해제
    }
}
?>
