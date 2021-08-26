<?php
require_once(__BACK__.'dao/DBLogRepository.php');
require_once(__BACK__.'utils/loggers/FileLogger.php');

class DBLogService {
    private $dbLogRepository;
    private $fileLogger;

    public function __construct() {
        $this->dbLogRepository = new DBLogRepository();
        $this->fileLogger = new FileLogger();
    }

    public function logFromFile() {
        $data = trim($this->fileLogger->read());
        if (!$data)
            return false;
        $data = explode("\n", $data);
        for ($a = 0; $a < count($data); $a++)
            $data[$a] = explode(';', $data[$a]);
        $result = $this->dbLogRepository->create($data);
        if ($result)
            $this->fileLogger->clear();
        return ['affected' => $result];
    }
}