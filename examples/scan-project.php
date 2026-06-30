<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Detector\FrameworkDetector;
use AIProjectScanner\Generator\FrameworksGenerator;
use AIProjectScanner\Generator\JsonGenerator;
use AIProjectScanner\Generator\ScanReportGenerator;
use AIProjectScanner\Generator\TreeGenerator;
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

$context = new ScanContext(
    projectRoot: $realPath,
    outputDirectory: $realPath . DIRECTORY_SEPARATOR . 'ai'
);

$scanResult = $fileScanner->scan($context);

(new TreeGenerator($fileSystem))->generate(
    $scanResult,
    $context->getOutputDirectory()
);

(new JsonGenerator($fileSystem))->generate(
    $scanResult,
    $context->getOutputDirectory()
);

(new ScanReportGenerator($fileSystem))->generate(
    $scanResult,
    $context->getOutputDirectory()
);

$frameworkResult = (new FrameworkDetector($fileSystem))->detect(
    $scanResult,
    $realPath
);

(new FrameworksGenerator($fileSystem))->generate(
    $frameworkResult,
    $context->getOutputDirectory()
);

echo 'PROJECT_TREE.md generated successfully.' . PHP_EOL;
echo 'PROJECT_MAP.json generated successfully.' . PHP_EOL;
echo 'SCAN_REPORT.md generated successfully.' . PHP_EOL;
echo 'FRAMEWORKS.md generated successfully.' . PHP_EOL;
echo PHP_EOL;
echo 'Project scan completed successfully.' . PHP_EOL;