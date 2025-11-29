<?php

use App\Support\Temperature;

it('converts celsius to fahrenheit', function () {
    $result = Temperature::toFahrenheit(0);

    expect($result)->toBe(32.0);
});

it('converts boiling point correctly', function () {
    expect(Temperature::toFahrenheit(100))->toBe(212.0);
});

it('converts fahrenheit to celsius', function () {
    expect(Temperature::toCelsius(32))->toBe(0.0);
});
