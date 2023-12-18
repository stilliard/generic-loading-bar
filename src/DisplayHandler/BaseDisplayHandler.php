<?php

namespace GLB\DisplayHandler;

abstract class BaseDisplayHandler
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    abstract public function display(int $value): string;
}
