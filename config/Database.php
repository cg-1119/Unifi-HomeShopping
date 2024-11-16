<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "apmsetup";
    private $dbname = "shopmall";
    private $con;

    public function connect() {
        $this->con = mysql_connect($this->host, $this->user, $this->password);
        if (!$this->con) {
            die("Database connection failed: " . mysql_error());
        }
        mysql_select_db($this->dbname, $this->con);
        // UTF-8 설정
        mysql_query("SET NAMES 'utf8'", $this->con);

        return $this->con;
    }

    public function close() {
        if ($this->con) {
            mysql_close($this->con);
        }
    }
}
?>
