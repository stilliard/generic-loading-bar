<?php

namespace GLB\DisplayHandler;

class EchoDisplayHandler extends BaseDisplayHandler
{
    public function display(int $value): string
    {
        // display as a percentage
        $current = ($value - $this->options['min']);
        $total = ($this->options['max'] - $this->options['min']);
        return round($current / $total * 100) . '%';
    }
}
