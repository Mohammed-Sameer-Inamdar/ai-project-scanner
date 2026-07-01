# AI Project Scanner

Generate AI-ready project documentation for any software project.

Built by developers tired of explaining the same project to AI every day.

AI Project Scanner helps AI assistants understand an existing codebase before suggesting bug fixes, feature updates, refactoring, or architecture improvements.

---

## Current Status

🚧 Actively under development.

Current stable release:

```bash
v0.2.0
```

---

## Features

* Recursive project scanning
* AI-ready project context generation
* Universal project structure detection
* Framework detection
* `.gitignore` support
* `.aiscannerignore` support
* Ignore engine with directory pruning
* CLI support
* Composer package installation
* Works with PHP, React, Node, Express, Java, Python, Go, and other project folders

---

## Supported Detection

### Backend

* CodeIgniter 4
* Laravel
* Node.js
* Express.js
* Java / Spring Boot structure
* Python project structure
* Go project structure

### Frontend

* React
* Next.js
* Vue.js

More framework-specific detection will be added in future releases.

---

## Installation

### Current Installation: Composer

```bash
composer require mohammedsameer/ai-project-scanner
```

Then scan your project:

```bash
php vendor/bin/ai-scan scan .
```

Scan another project folder:

```bash
php vendor/bin/ai-scan scan /path/to/project
```

---

## Usage Examples

### PHP / Composer Project

```bash
composer require mohammedsameer/ai-project-scanner
php vendor/bin/ai-scan scan .
```

### React Project

```bash
php vendor/bin/ai-scan scan ../my-react-app
```

### Node / Express Project

```bash
php vendor/bin/ai-scan scan ../my-express-api
```

### Java / Spring Boot Project

```bash
php vendor/bin/ai-scan scan ../spring-boot-api
```

### Python Project

```bash
php vendor/bin/ai-scan scan ../python-fastapi-service
```

### Go Project

```bash
php vendor/bin/ai-scan scan ../go-service
```

---

## Generated AI Documentation

After scanning, the tool creates:

```text
ai/
├── PROJECT_CONTEXT.md
├── PROJECT_STRUCTURE.md
├── PROJECT_TREE.md
├── PROJECT_MAP.json
├── SCAN_REPORT.md
└── FRAMEWORKS.md
```

---

## Which File Should AI Read First?

Start with:

```text
ai/PROJECT_CONTEXT.md
```

Then use:

```text
PROJECT_STRUCTURE.md  → architecture and important files
PROJECT_TREE.md       → folder overview
PROJECT_MAP.json      → complete file metadata
FRAMEWORKS.md         → detected technology stack
SCAN_REPORT.md        → statistics and ignored paths
```

---

## Generated Files Explained

### `PROJECT_CONTEXT.md`

The main AI onboarding document.

It summarizes:

* project name
* detected frameworks
* important directories
* important files
* AI guidance for safe code changes

Use this file first when asking AI for help.

---

### `PROJECT_STRUCTURE.md`

Categorized architecture overview.

Includes:

* backend entry points
* frontend entry points
* route files
* controller files
* service files
* model/entity files
* database files
* config files
* test files
* documentation files
* deployment files

---

### `PROJECT_TREE.md`

Simple project tree showing folders and files.

Useful for quickly understanding the repository layout.

---

### `PROJECT_MAP.json`

Machine-readable project metadata.

Useful for AI tools, scripts, and future integrations.

---

### `SCAN_REPORT.md`

Project statistics.

Includes:

* total files
* total directories
* ignored paths
* file extension counts
* scan errors

---

### `FRAMEWORKS.md`

Detected technology stack.

Example:

```md
# Detected Frameworks

## Frameworks

- CodeIgniter4
- Node.js
- React
```

---

## Ignore Files

AI Project Scanner respects:

```text
.gitignore
.aiscannerignore
```

Default ignored folders include:

```text
.git/
vendor/
node_modules/
build/
dist/
coverage/
system/
ai/
```

You can create a custom `.aiscannerignore` file:

```text
# AI Project Scanner ignore file

ai/
vendor/
node_modules/
system/
storage/
cache/
```

---

## Why This Exists

AI assistants are powerful, but they often struggle with large existing projects because they do not know:

* project structure
* entry points
* framework stack
* important files
* where business logic lives
* which files should not be modified

AI Project Scanner generates structured documentation so AI can understand the project faster and suggest safer changes.

---

## Future Universal Installation Options

The current version is distributed through Composer.

Planned installation options:

### PHAR

```bash
php ai-project-scanner.phar scan .
```

### Docker

```bash
docker run --rm -v "$PWD:/project" ai-project-scanner scan /project
```

### NPM / NPX

```bash
npx ai-project-scanner scan .
```

### Java / JAR Wrapper

```bash
java -jar ai-project-scanner.jar scan .
```

### VS Code / Windsurf / Cursor Extension

Planned extension support:

* scan current workspace
* regenerate AI docs
* open `PROJECT_CONTEXT.md`
* provide AI-ready project context

---

## Roadmap

### v0.1.x

* [x] Project tree generation
* [x] JSON project map generation
* [x] Scan report generation
* [x] CLI support
* [x] Composer package

### v0.2.x

* [x] Framework detection
* [x] Framework documentation
* [x] Project context generation
* [x] Universal project structure detection
* [x] Project structure documentation

### v0.3.x

* [ ] PHAR build
* [ ] Docker image
* [ ] Improved CLI options
* [ ] Config file support

### v0.4.x

* [ ] NPM wrapper
* [ ] `npx ai-project-scanner scan .`
* [ ] Better Node / React / Express detection

### v0.5.x

* [ ] Java / Spring Boot structure improvements
* [ ] Python / FastAPI / Django detection
* [ ] Go project detection
* [ ] Microservice workspace detection

### Future

* [ ] Route extraction
* [ ] API documentation generation
* [ ] Database relationship detection
* [ ] Module discovery
* [ ] AI prompt pack generation
* [ ] VS Code extension
* [ ] Cursor / Windsurf integration

---

## Example AI Workflow

After running:

```bash
php vendor/bin/ai-scan scan .
```

Ask your AI assistant:

```text
Read ai/PROJECT_CONTEXT.md first.
Then use ai/PROJECT_STRUCTURE.md and ai/PROJECT_MAP.json.
I want to fix a bug in the quotation module.
Suggest which files I should inspect and what changes may be required.
```

---

## Contributing

Contributions are welcome.

Please read:

```text
CONTRIBUTING.md
CODE_OF_CONDUCT.md
SECURITY.md
```

Before submitting pull requests.

Recommended workflow:

```bash
git checkout main
git pull
git checkout -b feature/your-feature-name
```

Then create a pull request.

---

## License

This project is licensed under the MIT License.

See:

```text
LICENSE
```

---

## Package

Packagist:

```text
mohammedsameer/ai-project-scanner
```

Install:

```bash
composer require mohammedsameer/ai-project-scanner
```

---

## Philosophy

Built by developers tired of explaining the same project to AI every day.

AI Project Scanner exists to make software projects easier for both humans and AI to understand.
