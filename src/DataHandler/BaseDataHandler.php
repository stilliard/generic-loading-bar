<?php

namespace GLB\DataHandler;

abstract class BaseDataHandler
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    abstract public function get(): int;

    abstract public function set(int $value): void;
}
