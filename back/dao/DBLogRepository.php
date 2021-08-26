<?php
require_once('QueryBuilder.php');
$conf = DB_CONF;
$dbDriver = $conf['driver_name'].'DBDriver';
require_once(__BACK__.'utils/dbdrivers/'.$dbDriver.'.php');

class DBLogRepository {
    private $dbDriver;
    private $table = 'logs';

    public function __construct() {
        global $dbDriver;
        $this->dbDriver = new $dbDriver();
    }

    public function create($data) {
        $builder = new QueryBuilder();
        $params = new stdClass();
        $params->data = $data;
        $params->cols = ['search', 'quantity', 'datetime'];
        $params->into = $this->table;
        $query = $builder->insert($params);
        return $this->dbDriver->insert($query);
    }
}