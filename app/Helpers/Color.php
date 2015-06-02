<?php namespace App\Helpers;

class Color
{
    /**
     * Get the perceived brightness of a color.
     *
     * @param array $color
     * @return int
     */
    public static function brightness(Array $color)
    {
        list($red, $green, $blue) = $color;

        return (int) sqrt(0.2126 * pow($red, 2) + 0.7152 * pow($green, 2) + 0.0722 * pow($blue, 2));
    }
}