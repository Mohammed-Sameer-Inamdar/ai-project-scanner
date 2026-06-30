<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\Detector\ProjectStructureDetector;
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

$result = (new ProjectStructureDetector())->detect($scanResult);

echo 'Detected Structure:' . PHP_EOL;
echo PHP_EOL;

printSection('Backend Entry Points', $result->getBackendEntryPoints());
printSection('Frontend Entry Points', $result->getFrontendEntryPoints());
printSection('Route Files', $result->getRouteFiles());
printSection('Controller Files', $result->getControllerFiles());
printSection('Service Files', $result->getServiceFiles());
printSection('Model Files', $result->getModelFiles());
printSection('Database Files', $result->getDatabaseFiles());
printSection('Config Files', $result->getConfigFiles());
printSection('Test Files', $result->getTestFiles());
printSection('Documentation Files', $result->getDocumentationFiles());
printSection('Deployment Files', $result->getDeploymentFiles());

function printSection(string $title, array $items): void
{
    echo $title . ':' . PHP_EOL;

    if ($items === []) {
        echo '- None' . PHP_EOL . PHP_EOL;
        return;
    }

    foreach ($items as $item) {
        echo '- ' . $item . PHP_EOL;
    }

    echo PHP_EOL;
}