<?php

// Custom arch test: Ensures no debugging or env functions in App namespace
arch()
    ->expect('App')
    ->not->toUse(['dd', 'dump', 'env']);

// PHP preset: Ensures no deprecated PHP functions like die, var_dump, etc.
arch()->preset()->php();

// Security preset: Ensures no insecure functions like eval, md5, sha1, etc.
arch()->preset()->security();

// Laravel preset: Ensures Laravel best practices are followed
arch()->preset()->laravel();

// Strict preset: Ensures strict types, final classes, and readonly classes
// arch()->preset()->strict();


// Custom arch test: Ensures all Enums in App\Enums are string backed for reliability
arch('app')
    ->expect('App\Enums')
    ->toBeStringBackedEnums();
