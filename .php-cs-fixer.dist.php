<?php declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setRules([
        '@auto' => true,
        '@auto:risky' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'array_push' => true,
        'backtick_to_shell_exec' => true,
        'declare_strict_types' => true,
        'final_class' => true,
        'strict_comparison' => true,
        'modernize_strpos' => true,
        'blank_line_after_opening_tag' => false,
    ])
    // 💡 by default, Fixer looks for `*.php` files excluding `./vendor/` - here, you can groom this config
    ->setFinder(
        (new Finder())
            // 💡 root folder to check
            ->in(__DIR__)
            // 💡 additional files, eg bin entry file
            // ->append([__DIR__.'/bin-entry-file'])
            // 💡 folders to exclude, if any
            ->exclude(['vendor', '.*'])
        // 💡 path patterns to exclude, if any
        // ->notPath([/* ... */])
        // 💡 extra configs
        // ->ignoreDotFiles(false) // true by default in v3, false in v4 or future mode
        // ->ignoreVCS(true) // true by default
    );
