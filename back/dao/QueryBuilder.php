<?php
require_once(__BACK__.'exceptions/BadRequestException.php');

class QueryBuilder {
    private function from($query, $params) {
        if (property_exists($params, 'from') && $params->from) {
            $query .= ' from ';
            $query .= implode(', ', $params->from);
        } else
            die(new BadRequestException('No table selected.'));
        return $query;
    }

    private function where($query, $where) {
        $query .= ' where ';
        $whereAr = [];
        foreach ($where as $item) {
            $exp = $item->name;
            $op = strtolower($item->op);
            if (in_array($op, ['=', '<', '<=', '>', '>=', '<>', '!=', 'like']))
                $exp .= ' '.$item->op.' ';
            else
                die(new BadRequestException("Incorrect operator: $op."));
            if (is_numeric($item->value) && $op != 'like')
                $exp .= $item->value;
            else
                $exp .= '"%'.$item->value.'%"';
            $whereAr[] = $exp;
        }
        $query .= implode(' and ', $whereAr);
        $query .= ' COLLATE NOCASE';
        return $query;
    }

    public function insert($params) {
        $query = 'insert into '.$params->into;
        $query .= ' ('.implode(', ', $params->cols).')';
        $query .= ' values ';
        for ($a = 0; $a < count($params->data); $a++) {
            for ($b = 0; $b < count($params->data[$a]); $b++)
                $params->data[$a][$b] = preg_replace('/"/', "'", $params->data[$a][$b]);
            $params->data[$a] = '("' . implode('", "', $params->data[$a]) . '")';
        }
        $query .= implode(', ', $params->data);
        return $query;
    }

    public function select($params) {
        $query = 'select ';

        if (property_exists($params, 'select') && $params->select)
            $query .= implode(', ', $params->select);
        else
            $query .= '*';

        $query = $this->from($query, $params);

        if (property_exists($params, 'where') && $params->where)
            $query = $this->where($query, $params->where);

        return $query;
    }
}