<?
require_once('QueryBuilder.php');
$conf = DB_CONF;
$dbDriver = $conf['driver_name'].'DBDriver';
require_once(__BACK__.'utils/dbdrivers/'.$dbDriver.'.php');

class ProductRepository {
    private $dbDriver;
    private $table = 'products';
    
    public function __construct() {
        global $dbDriver;
        $this->dbDriver = new $dbDriver();
    }
    
    public function read($params) {
        $builder = new QueryBuilder();
        $params->from = [$this->table];
        $query = $builder->select($params);
        return $this->dbDriver->select($query);
    }
}