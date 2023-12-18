<?php

namespace GLB\DisplayHandler;

class HTMLDisplayHandler extends BaseDisplayHandler
{
    public function display(int $value): string
    {
        return "<progress value='{$value}' max='{$this->options['max']}'></progress>";
    }
}
