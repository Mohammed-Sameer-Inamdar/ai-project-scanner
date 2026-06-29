<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ProjectScanner;
use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Generator\JsonGenerator;
use AIProjectScanner\Generator\ScanReportGenerator;
use AIProjectScanner\Generator\TreeGenerator;
use AIProjectScanner\Scanner\FileScanner;
use AIProjectScanner\Utils\FileSystem;
use AIProjectScanner\Utils\IgnoreMatcher;
use AIProjectScanner\Utils\IgnorePatternLoader;

$fileSystem = new FileSystem();

$fileScanner = new FileScanner(
    $fileSystem,
    new IgnorePatternLoader($fileSystem),
    new IgnoreMatcher()
);

$projectScanner = new ProjectScanner(
    $fileScanner,
    [
        new TreeGenerator($fileSystem),
        new JsonGenerator($fileSystem),
        new ScanReportGenerator($fileSystem),
    ]
);

$projectScanner->scan(
    new ScanContext(
        projectRoot: dirname(__DIR__)
    )
);

echo 'PROJECT_TREE.md generated successfully.' . PHP_EOL;
echo 'PROJECT_MAP.json generated successfully.' . PHP_EOL;
echo 'SCAN_REPORT.md generated successfully.' . PHP_EOL;
echo PHP_EOL;
echo 'Project scan completed successfully.' . PHP_EOL;