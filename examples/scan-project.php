<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AIProjectScanner\Core\ProjectScanner;
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
use AIProjectScanner\Generator\ProjectContextGenerator;
use AIProjectScanner\Detector\ProjectStructureDetector;
use AIProjectScanner\Generator\ProjectStructureGenerator;
use AIProjectScanner\Detector\RouteDetector;
use AIProjectScanner\Generator\ApiRoutesGenerator;

$projectRoot = $argv[1] ?? dirname(__DIR__);

$realPath = realpath($projectRoot);

if ($realPath === false) {
    echo 'Invalid project path.' . PHP_EOL;
    exit(1);
}

$fileSystem = new FileSystem();

$projectScanner = new ProjectScanner(
    new FileScanner(
        $fileSystem,
        new IgnorePatternLoader($fileSystem),
        new IgnoreMatcher()
    ),
    [
        new TreeGenerator($fileSystem),
        new JsonGenerator($fileSystem),
        new ScanReportGenerator($fileSystem),
    ]
);

$context = new ScanContext(
    projectRoot: $realPath,
    outputDirectory: $realPath . DIRECTORY_SEPARATOR . 'ai'
);

$scanResult = $projectScanner->scan($context);

$frameworkResult = (new FrameworkDetector($fileSystem))->detect(
    $scanResult,
    $realPath
);

(new FrameworksGenerator($fileSystem))->generate(
    $frameworkResult,
    $context->getOutputDirectory()
);

$structureResult = (new ProjectStructureDetector())
    ->detect($scanResult);

(new ProjectStructureGenerator($fileSystem))
    ->generate(
        $structureResult,
        $context->getOutputDirectory()
    );

(new ProjectContextGenerator($fileSystem))->generate(
    $scanResult,
    $frameworkResult,
    $structureResult,
    $context->getOutputDirectory()
);

$routeResult = (new RouteDetector($fileSystem))->detect(
    $scanResult,
    $projectRoot
);

(new ApiRoutesGenerator($fileSystem))->generate(
    $routeResult,
    $context->getOutputDirectory()
);

echo 'PROJECT_TREE.md generated successfully.' . PHP_EOL;
echo 'PROJECT_MAP.json generated successfully.' . PHP_EOL;
echo 'SCAN_REPORT.md generated successfully.' . PHP_EOL;
echo 'FRAMEWORKS.md generated successfully.' . PHP_EOL;
echo 'PROJECT_CONTEXT.md generated successfully.' . PHP_EOL;
echo 'PROJECT_STRUCTURE.md generated successfully.' . PHP_EOL;
echo 'PROJECT_CONTEXT.md generated successfully.' . PHP_EOL;
echo 'API_ROUTES.md generated successfully.' . PHP_EOL;
echo PHP_EOL;
echo 'Project scan completed successfully.' . PHP_EOL;
