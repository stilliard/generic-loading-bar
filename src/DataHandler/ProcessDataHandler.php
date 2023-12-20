<?php

namespace GLB\DataHandler;

class ProcessDataHandler extends BaseDataHandler
{
    protected ?int $value = null;

    public function set(int $value): void
    {
        $this->value = $value;
    }

    public function get(): int
    {
        return $this->value ?? $this->options['min'];
    }
}
