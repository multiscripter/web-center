<?php
require_once(__BACK__.'dao/DBLogRepository.php');

class DBLogger {
    private $dbLogRepository;

    public function __construct() {
        $this->dbLogRepository = new DBLogRepository();
    }

    public function write($data) {
        $this->dbLogRepository->create($data);
    }
}