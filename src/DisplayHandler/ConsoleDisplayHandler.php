<?php

namespace GLB\DisplayHandler;

class ConsoleDisplayHandler extends BaseDisplayHandler
{
    protected int $length = 25; // length of the loading bar
    protected string $indictorEnd = '>'; // the end of the loading bar

    protected function refreshOutput(string $value): string
    {
        // auto refresh the console output
        return "\r" . str_repeat(' ', 80) . "\r" . $value;
    }
    
    public function display(int $value): string
    {
        // display as a percentage
        $percent = $value / $this->options['max'] * 100;

        // display as a loading bar
        $repeat = $value / $this->options['max'] * $this->length;
        $output = $this->refreshOutput('[' . str_pad(str_repeat('=', $repeat) . $this->indictorEnd, $this->length + 1) . '] ' . $percent . '%');

        // if we are at 100% then add a new line
        if ($value === $this->options['max']) {
            $output .= "\n";
        }

        return $output;
    }
}
