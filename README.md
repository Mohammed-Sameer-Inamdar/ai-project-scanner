# AI Project Scanner

Generate AI-ready project documentation for any software project.

🚧 Currently under development.

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
└── SCAN_REPORT.md
```
# Detected Frameworks

## Frameworks

- CodeIgniter4
- Node.js
- React