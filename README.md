# AI Project Scanner

Generate AI-ready project documentation for any software project.

🚧 Currently under development.

## Features

- Recursive project scanning
- Framework detection
- `.gitignore` support
- `.aiscannerignore` support
- Ignore engine with directory pruning
- CLI support
- Composer package installation
- AI-ready documentation generation

## Supported Frameworks

### Backend

- CodeIgniter 4
- Laravel
- Node.js
- Express.js

### Frontend

- React
- Next.js
- Vue.js

## Installation

```bash
composer require mohammedsameer/ai-project-scanner
```

## Usage

Scan current project:

```bash
php vendor/bin/ai-scan scan .
```

Scan specific directory:

```bash
php vendor/bin/ai-scan scan /path/to/project
```

## Generated Files

After scanning:

```text
ai/
├── PROJECT_TREE.md
├── PROJECT_MAP.json
├── SCAN_REPORT.md
└── FRAMEWORKS.md
```

# Detected Frameworks

## Frameworks

- CodeIgniter4
- Node.js
- React

# Project Modules

## Product

Files:
- app/Controllers/ProductController.php
- app/Models/ProductModel.php
- react/src/pages/ProductPage.tsx

## Order

Files:
- app/Controllers/OrderController.php
- app/Models/OrderModel.php

## Company

Files:
- app/Controllers/CompanyController.php

# License

This project is licensed under the MIT License.