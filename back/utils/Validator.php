<?
require_once(__BACK__.'exceptions/BadRequestException.php');
require_once(__BACK__.'exceptions/MethodNotAllowedException.php');

class Validatior {
    public function validateGETRequest() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            die(new MethodNotAllowedException("Allow: GET"));

        if (!isset($_GET['action']))
            die(new BadRequestException("'action' is not set"));

        if (empty($_GET['action']))
            die(new BadRequestException("'action' is empty"));

        if ($_GET['action'] == 'search' && !isset($_GET['params']))
            die(new BadRequestException("'params' is not set"));

        if ($_GET['action'] == 'search' && empty($_GET['params']))
            die(new BadRequestException("'params' is empty"));
    }

    private function validateByRegex($key, $value, $regex) {
        $result = preg_match($regex, $value);
        if ($result === false)
            die(new BadRequestException("error during validation '$key'"));
        else if ($result)
            die(new BadRequestException("'$key' is incorrect"));
    }

    private function validateWhere($whereAr) {
        foreach ($whereAr as $where) {
            $this->validateByRegex('name', $where->name, '/[^\w]/');
            $this->validateByRegex(
                'op', $where->op,
                '/!(=|<|<=|>|>=|<>|\!=|like)/'
            );
            $this->validateByRegex('value', $where->value, '/[^\w\- ЁёА-я]/');
        }
    }

    public function validateParams($params) {
        if (isset($params->where) && $params->where)
            $this->validateWhere($params->where);
    }
}