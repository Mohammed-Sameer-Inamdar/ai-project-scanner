<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Detector\FrameworkDetector;
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

$result = $detector->detect(
    $scanResult,
    $realPath
);

echo 'Detected Frameworks:' . PHP_EOL;
echo PHP_EOL;

if ($result->getFrameworks() === []) {
    echo '- None detected' . PHP_EOL;
    exit(0);
}

foreach ($result->getFrameworks() as $framework) {
    echo '- ' . $framework . PHP_EOL;
}