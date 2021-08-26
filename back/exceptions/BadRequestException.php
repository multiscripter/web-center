<?php
class BadRequestException {
    protected $message;

    public function __construct($message) {
        $this->message = $message;
        header($_SERVER["SERVER_PROTOCOL"].' 400 Bad Request', true, 400);
    }

    public function __toString() {
        return json_encode(["error" => $this->message]);
    }
}