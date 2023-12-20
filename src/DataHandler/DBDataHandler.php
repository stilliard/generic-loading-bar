<?php

namespace GLB\DataHandler;

use DB;

class DBDataHandler extends BaseDataHandler
{
    public function set(int $value): void
    {
        DB::query("UPDATE loading_bars SET `value` = ? WHERE `name` = ?", [$value, $this->options['codename']]);
    }

    public function get(): int
    {
        return DB::first("SELECT `value` FROM loading_bars WHERE `name` = ?", [$this->options['codename']])->value;
    }
}
