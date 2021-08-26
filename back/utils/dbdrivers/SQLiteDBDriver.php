<?php
require_once(__BACK__.'exceptions/BadRequestException.php');

class SQLiteDBDriver {
    private $config;
    private $pdo;

    public function __construct() {
        $this->config = DB_CONF;
    }

    public function connect() {
        if (!$this->pdo) {
            $path = $this->config['abs_path_to_db'];
            $path .= $this->config['db_name'];
            $path = realpath($path);
            $path = $this->config['driver_url'].$path;
            $this->pdo = new PDO($path);
        }
    }

    public function insert($query) {
        if (!$this->pdo)
            $this->connect();
        $query = SQLite3::escapeString($query);
        $stmt = $this->pdo->query($query);
        if ($stmt)
            return $stmt->rowCount();
        else
            die(new BadRequestException('stmt is false.'));
    }

    public function select($query) {
        if (!$this->pdo)
            $this->connect();
        $query = SQLite3::escapeString($query);
        $stmt = $this->pdo->query($query);
        $result = [];
        if ($stmt) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $entry = [];
                foreach ($row as $name => $value)
                    $entry[$name] = $value;
                $result[] = $entry;
            }
        } else
            die(new BadRequestException('stmt is false.'));
        return $result;
    }
}