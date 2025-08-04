<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return ECSConfig::configure()
    ->withSets([SetList::SYMPLIFY, SetList::COMMON, SetList::CLEAN_CODE, SetList::PSR_12])
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/utils',
    ])
    ->withRootFiles()
    ->withSkip([
        __DIR__ . '/tests/Fixtures/Entity/AbstractTimestampableMappedSuperclassEntity.php',
        __DIR__ . '/src/Bundle/DoctrineBehaviorsBundle.php',
        __DIR__ . '/src/DoctrineBehaviorsBundle.php',
    ]);
