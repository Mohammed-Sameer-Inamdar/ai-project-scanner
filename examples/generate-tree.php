<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Generator\TreeGenerator;
use AIProjectScanner\Scanner\FileScanner;
use AIProjectScanner\Utils\FileSystem;
use AIProjectScanner\Utils\IgnoreMatcher;
use AIProjectScanner\Utils\IgnorePatternLoader;

$fileSystem = new FileSystem();

$scanner = new FileScanner(
    $fileSystem,
    new IgnorePatternLoader($fileSystem),
    new IgnoreMatcher()
);

$result = $scanner->scan(
    new ScanContext(
        projectRoot: dirname(__DIR__)
    )
);

$outputDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ai';

$generator = new TreeGenerator($fileSystem);

$generator->generate($result, $outputDirectory);

echo 'PROJECT_TREE.md generated successfully.' . PHP_EOL;
echo 'Output: ' . $outputDirectory . DIRECTORY_SEPARATOR . 'PROJECT_TREE.md' . PHP_EOL;