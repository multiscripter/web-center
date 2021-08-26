<?
require_once(__BACK__.'utils/loggers/FileLogger.php');
require_once(__BACK__.'dao/ProductRepository.php');

class ProductService {
    private $fileLogger;
    private $productRepository;
    
    public function __construct() {
        $this->fileLogger = new FileLogger();
        $this->productRepository = new ProductRepository();
    }
    
    public function find($params) {
        $result = $this->productRepository->read($params);
        $this->fileLogger->write([json_encode($params), count($result)]);
        return $result;
    }
}