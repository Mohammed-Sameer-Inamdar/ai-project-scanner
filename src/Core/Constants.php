<?php

declare(strict_types=1);

namespace AIProjectScanner\Core;

final class Constants
{
    public const DEFAULT_OUTPUT_DIRECTORY = 'ai';

    public const DEFAULT_IGNORE_FILE = '.aiscannerignore';

    public const PROJECT_TREE = 'PROJECT_TREE.md';

    public const PROJECT_MAP = 'PROJECT_MAP.json';

    public const SCAN_REPORT = 'SCAN_REPORT.md';

    public const DEFAULT_PATTERNS = [
        '.git/',
        '.idea/',
        '.vscode/',
        'vendor/',
        'node_modules/',
        'build/',
        'dist/',
        'coverage/',
    ];

    public const VERSION = '0.1.0';

    public const FRAMEWORKS = 'FRAMEWORKS.md';

    public const PROJECT_CONTEXT = 'PROJECT_CONTEXT.md';
}
