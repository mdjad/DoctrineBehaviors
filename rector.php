<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/utils'])
    ->withPhpSets(php84: true)
    ->withComposerBased(doctrine: true, symfony: true, phpunit: true, netteUtils: true);
