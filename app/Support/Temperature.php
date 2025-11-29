<?php

declare(strict_types=1);

namespace App\Support;

class Temperature
{
    /**
     * Convert Celsius to Fahrenheit.
     */
    public static function toFahrenheit(float $celsius): float
    {
        return ($celsius * 9 / 5) + 32;
    }

    /**
     * Convert Fahrenheit to Celsius.
     */
    public static function toCelsius(float $fahrenheit): float
    {
        return ($fahrenheit - 32) * 5 / 9;
    }
}
