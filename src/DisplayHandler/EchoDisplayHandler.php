<?php

namespace GLB\DisplayHandler;

class EchoDisplayHandler extends BaseDisplayHandler
{
    public function display(int $value): string
    {
        // display as a percentage
        return $value / $this->options['max'] * 100 . '%';
    }
}
