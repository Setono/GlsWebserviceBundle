<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        __DIR__ . '/vendor/sylius-labs/coding-standard/ecs.php',
    ]);
