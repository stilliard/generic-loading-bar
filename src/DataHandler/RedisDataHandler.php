<?php

namespace GLB\DataHandler;

use Redis;
use Exception;

class RedisDataHandler extends BaseDataHandler
{
    protected Redis $redis;
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        if (! $this->options['codename']) {
            throw new Exception("Option 'codename' is required for the cache key.");
        }

        $this->redis = new Redis;
        if (! isset($this->options['redis_host'])) {
            $this->options['redis_host'] = 'localhost';
        }
        if (! isset($this->options['redis_port'])) {
            $this->options['redis_port'] = 6379;
        }
        if (! isset($this->options['redis_prefix'])) {
            $this->options['redis_prefix'] = 'loading-bar-';
        }
        $this->redis->connect($this->options['redis_host'], $this->options['redis_port']);
        if (isset($this->options['redis_password'])) {
            $this->redis->auth($this->options['redis_password']);
        }
        if (isset($this->options['redis_database'])) {
            $this->redis->select($this->options['redis_database']);
        }
        if ($this->options['redis_prefix']) {
            $this->redis->setOption(Redis::OPT_PREFIX, $this->options['redis_prefix']);
        }
        // set default value if it doesn't already exist
        if (! $this->redis->exists($this->options['codename'])) {
            $this->redis->set($this->options['codename'], $this->options['min']);
        }
    }

    public function set(int $value): void
    {
        $this->redis->set($this->options['codename'], $value);
    }

    public function get(): int
    {
        return $this->redis->get($this->options['codename']) ?? $this->options['min'];
    }
}
