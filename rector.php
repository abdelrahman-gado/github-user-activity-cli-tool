<?php declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withComposerBased(
        phpunit: true,
    )
    ->withPreparedSets(
        codeQuality: true,
        deadCode: true,
        codingStyle: true,
        naming: true,
        privatization: true,
        typeDeclarations: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
        typeDeclarationDocblocks: true,
    )
    ->withIndent(indentChar: ' ', indentSize: 4)
    ->withParallel()
    ->withTreatClassesAsFinal();
