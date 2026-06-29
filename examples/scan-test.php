<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
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

echo 'Project: ' . $result->getProjectName() . PHP_EOL;
echo 'Directories: ' . count($result->getDirectories()) . PHP_EOL;
echo 'Files: ' . count($result->getFiles()) . PHP_EOL;
echo 'Ignored: ' . count($result->getIgnored()) . PHP_EOL;
echo 'Errors: ' . count($result->getErrors()) . PHP_EOL;