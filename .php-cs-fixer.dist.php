<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->append([__FILE__])
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP80Migration' => true,
        '@PSR2' => true,
        '@DoctrineAnnotation' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PhpCsFixer' => true,
        'array_syntax' => ['syntax' => 'short'],
        'global_namespace_import' => true,
        'declare_strict_types' => true,
        'strict_comparison' => true,
        'yoda_style' => false,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false,
        'native_constant_invocation' => false,
        'native_function_invocation' => false,
        'concat_space' => ['spacing' => 'one'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
