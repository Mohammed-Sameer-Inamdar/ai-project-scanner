ignore files will be merged and deduplicated from .aiscannerignore, .gitignore, and defaults.
Module detection will be handled by a separate ModuleDetector after FileScanner. FileScanner only scans files and directories.

## Route Detection

Route detection uses framework-specific parsing.

Current supported parsers:

- CodeIgniter4 Routes.php
- Laravel routes/*.php

Route output is written to API_ROUTES.md.

Known future improvements:

- Spring Boot annotations
- Express Router parsing
- FastAPI decorators
- NestJS controller decorators