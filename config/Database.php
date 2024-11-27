<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "apmsetup";
    private $dbname = "shopmall";
    private $pdo;

    public function connect() {
        if (!$this->pdo) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
                $this->pdo = new PDO($dsn, $this->user, $this->password);

                // PDO 에러 모드 설정 (예외 처리 활성화)
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // 기본 페치 모드 설정 (연관 배열로 결과 반환)
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }

    public function close() {
        $this->pdo = null; // PDO 연결 해제
    }
}
?>
