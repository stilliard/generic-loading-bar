<?php

namespace GLB\DataHandler;

use Exception;
use PDO;
use PDOStatement;

class PDODataHandler extends BaseDataHandler
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        if (! $this->options['pdo'] || ! $this->options['pdo'] instanceof PDO) {
            throw new Exception("Option 'pdo' is required as a PDO instance");
        }
    }

    protected function query(string $query, array $params = []): PDOStatement
    {
        $stmt = $this->options['pdo']->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    protected function first(string $query, array $params = [])
    {
        $stmt = static::query($query, $params);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function set(int $value): void
    {
        static::query("UPDATE loading_bars SET `value` = ? WHERE `name` = ?", [$value, $this->options['codename']]);
    }

    public function get(): int
    {
        return static::first("SELECT `value` FROM loading_bars WHERE `name` = ?", [$this->options['codename']])->value;
    }
}
