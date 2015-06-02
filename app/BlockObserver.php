<?php namespace App;

class BlockObserver
{
    public function saving(Block $block)
    {
        $block->brightness = sqrt(0.2126 * pow($block->red, 2) + 0.7152 * pow($block->green, 2) + 0.0722 * pow($block->blue, 2));
    }
}