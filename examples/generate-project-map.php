<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Generator\JsonGenerator;
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

$generator = new JsonGenerator($fileSystem);

$generator->generate(
    $result,
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ai'
);

echo 'PROJECT_MAP.json generated successfully.' . PHP_EOL;