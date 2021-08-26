<?
require_once(__BACK__.'services/DBLogService.php');
require_once(__BACK__.'services/ProductService.php');
require_once(__BACK__.'utils/Validator.php');

class Controller {
    private $dbLogService;
    private $productService;
    private $validator;
    
    public function __construct() {
        $this->dbLogService = new DBLogService();
        $this->productService = new ProductService();
        $this->validator = new Validatior();
    }
    
    public function handleRequiest() {
        header('Content-Type: application/json');
        $this->validator->validateGETRequest();
        if ($_GET['action'] == 'search') {
            $params = urldecode($_GET['params']);
            $params = json_decode($params);
            $this->validator->validateParams($params);
            echo json_encode($this->productService->find($params));
        } else if ($_GET['action'] == 'log')
            echo json_encode($this->dbLogService->logFromFile());
    }
}