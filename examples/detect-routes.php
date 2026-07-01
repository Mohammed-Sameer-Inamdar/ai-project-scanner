<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Detector\RouteDetector;
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

$routeResult = (new RouteDetector($fileSystem))->detect(
    $scanResult,
    $realPath
);


echo 'Detected Routes:' . PHP_EOL;
echo PHP_EOL;

if ($routeResult->getRoutes() === []) {
    echo '- None detected' . PHP_EOL;
    exit(0);
}

foreach ($routeResult->getRoutes() as $route) {
    echo $route->getMethod() . ' ' . $route->getUri() . ' -> ' . $route->getHandler() . PHP_EOL;
}
