<?php
class MethodNotAllowedException {
    protected $message;

    public function __construct($message) {
        $this->message = $message;
        header($_SERVER["SERVER_PROTOCOL"].' 405 Method Not Allowed', true, 405);
        header('Allow: GET', true);
    }

    public function __toString() {
        return json_encode(["error" => $this->message]);
    }
}