<?php namespace App;

use App\Helpers\Color;

class BlockObserver
{
    public function saving(Block $block)
    {
        $block->brightness = Color::brightness([$block->red, $block->green, $block->blue]);
    }
}