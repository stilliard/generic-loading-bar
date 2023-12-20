<?php

namespace GLB;

use GLB\DataHandler\ProcessDataHandler;
use GLB\DisplayHandler\EchoDisplayHandler;

class LoadingBar
{
    protected static array $defaultOptions = [
        'codename' => '',
        'min' => 0,
        'max' => 100,
        'steps' => 100,
        'dataHandler' => null,
        'displayHandler' => null,
    ];

    protected ?string $defaultDataHandler = ProcessDataHandler::class;
    protected ?string $defaultDisplayHandler = EchoDisplayHandler::class;

    protected ?object $dataHandler;
    protected ?object $displayHandler;

    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge(static::$defaultOptions, $options);

        $this->setDataHandler($this->options['dataHandler'] ?? $this->defaultDataHandler);
        $this->setDisplayHandler($this->options['displayHandler'] ?? $this->defaultDisplayHandler);
    }

    public function get(): int
    {
        return $this->dataHandler->get();
    }

    public function set(int $value): void
    {
        $value = min($value, $this->options['max']);
        $value = max($value, $this->options['min']);
        $this->dataHandler->set(round($value));
    }

    public function step(): int
    {
        $value = $this->get();
        $value += $this->options['max'] / $this->options['steps'];
        $this->set($value);
        return $value;
    }

    public function complete(): void
    {
        $this->set($this->options['max']);
    }

    public function reset(): void
    {
        $this->set($this->options['min']);
    }

    public function isComplete(): bool
    {
        return $this->get() >= $this->options['max'];
    }

    public function isRunning(): bool
    {
        return $this->get() > $this->options['min'] && $this->get() < $this->options['max'];
    }

    public function isReset(): bool
    {
        return $this->get() <= $this->options['min'];
    }

    public function calc(array $range, array $current): void
    {
        $value = ($range[1] - $range[0]) / $current[1] * $current[0];
        $this->set($range[0] + round($value));
    }

    public function display(): string
    {
        return $this->displayHandler->display($this->get());
    }

    public function __toString(): string
    {
        return $this->display();
    }

    public function setDataHandler(string $handler): void
    {
        $this->dataHandler = new $handler($this->options);
    }

    public function setDisplayHandler(string $handler): void
    {
        $this->displayHandler = new $handler($this->options);
    }
}
