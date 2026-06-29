<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use AIProjectScanner\Core\ScanContext;

$context = new ScanContext(
    projectRoot: __DIR__
);

echo "Autoload working!";