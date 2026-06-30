<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Detector\FrameworkDetector;
use AIProjectScanner\Generator\FrameworksGenerator;
use AIProjectScanner\Scanner\FileScanner;
use AIProjectScanner\Utils\FileSystem;
use AIProjectScanner\Utils\IgnoreMatcher;
use AIProjectScanner\Utils\IgnorePatternLoader;

$projectRoot = $argv[1] ?? dirname(__DIR__);
$realPath = realpath($projectRoot);

if ($realPath === false) {
    echo 'Invalid project path.' . PHP_EOL;
    exit(1);
}

$fileSystem = new FileSystem();

$fileScanner = new FileScanner(
    $fileSystem,
    new IgnorePatternLoader($fileSystem),
    new IgnoreMatcher()
);

$scanResult = $fileScanner->scan(
    new ScanContext(
        projectRoot: $realPath
    )
);

$detector = new FrameworkDetector($fileSystem);
$detectionResult = $detector->detect($scanResult, $realPath);

$generator = new FrameworksGenerator($fileSystem);

$generator->generate(
    $detectionResult,
    $realPath . DIRECTORY_SEPARATOR . 'ai'
);

echo 'FRAMEWORKS.md generated successfully.' . PHP_EOL;