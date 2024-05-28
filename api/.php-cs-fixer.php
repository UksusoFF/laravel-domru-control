<?php

use AdamWojs\PhpCsFixerPhpdocForceFQCN\Fixer\Phpdoc\ForceFQCNFixer;
use UksusoFF\PhpCsFixer\Factory;
use UksusoFF\PhpCsFixer\RuleSet\Laravel;

$config = Factory::fromRuleSet(new Laravel())
    ->registerCustomFixers([
        new ForceFQCNFixer(),
    ])
    ->setUsingCache(false);

$config->getFinder()
    ->name('*.php')
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/lang',
        __DIR__ . '/database',
    ])
    ->notPath('vendor');

return $config;
