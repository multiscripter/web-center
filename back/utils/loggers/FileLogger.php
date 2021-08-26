<?php
class FileLogger {
    private $config;

    public function __construct() {
        $this->config = parse_ini_file(LOG_CONF);
    }

    private function createFile() {
        $file = fopen($this->config['logfile'], 'wb');
        fputs($file, "\xEF\xBB\xBF");
        fclose($file);
    }

    public function clear() {
        file_put_contents($this->config['logfile'], '');
    }

    public function read() {
        return file_get_contents($this->config['logfile']);
    }

    public function write($data) {
        if (!file_exists($this->config['logfile']))
            $this->createFile();
        $data[] = date('Y-m-d h:i:s')."\n";
        $data = implode(';', $data);
        file_put_contents($this->config['logfile'], $data, FILE_APPEND);
    }
}