# AI Project Scanner

Generate AI-ready documentation for any software project.

Built by developers tired of explaining the same project to AI every day.

AI Project Scanner helps AI assistants understand existing codebases before suggesting bug fixes, feature updates, refactoring, or architecture improvements.

---

## 🚧 Current Status

AI Project Scanner is actively under development.

**Current Stable Release**

```bash
v0.3.2
```

---

## ✨ Features

* Recursive project scanning
* AI-ready project context generation
* Universal project structure detection
* Framework detection
* API route extraction
* `.gitignore` support
* `.aiscannerignore` support
* Intelligent ignore engine with directory pruning
* Command-line interface (CLI)
* Composer package installation
* PHAR build support
* Works with PHP, Laravel, CodeIgniter4, React, Node.js, Java, Python, Go, and many other projects

---

## 🔍 Supported Detection

### Framework Detection

Currently supported:

* CodeIgniter 4
* Laravel
* Node.js
* Express.js
* React
* Next.js
* Vue.js

### API Route Extraction

Currently supported:

* CodeIgniter 4
* Laravel

Planned support:

* Express.js
* NestJS
* Next.js API Routes
* Spring Boot
* FastAPI
* Django
* Go HTTP Routers

---

## 📦 Installation

### Composer

```bash
composer require mohammedsameer/ai-project-scanner
```

Run:

```bash
php vendor/bin/ai-scan scan .
```

### PHAR

Download the latest PHAR from GitHub Releases.

Run:

```bash
php ai-project-scanner.phar scan .
```

---

## 🚀 Usage Examples

### Scan Current Project

```bash
php vendor/bin/ai-scan scan .
```

### Scan Another Project

```bash
php vendor/bin/ai-scan scan /path/to/project
```

### Scan a React Project

```bash
php vendor/bin/ai-scan scan ../my-react-app
```

### Scan a Laravel Project

```bash
php vendor/bin/ai-scan scan ../my-laravel-app
```

### Scan a Spring Boot Project

```bash
php vendor/bin/ai-scan scan ../spring-boot-api
```

---

## 📁 Generated AI Documentation

```text
ai/
├── PROJECT_CONTEXT.md
├── PROJECT_STRUCTURE.md
├── API_ROUTES.md
├── PROJECT_TREE.md
├── PROJECT_MAP.json
├── SCAN_REPORT.md
└── FRAMEWORKS.md
```

---

## 🤖 Which File Should AI Read First?

Start with:

```text
ai/PROJECT_CONTEXT.md
```

Then continue with:

```text
PROJECT_STRUCTURE.md → Architecture and important files
API_ROUTES.md        → Backend routes and handlers
PROJECT_TREE.md      → Folder overview
PROJECT_MAP.json     → Complete file metadata
FRAMEWORKS.md        → Detected technology stack
SCAN_REPORT.md       → Statistics and ignored paths
```

---

# 📚 Generated Files Explained

## PROJECT_CONTEXT.md

The primary AI onboarding document.

It summarizes:

* Project name
* Detected frameworks
* Important directories
* Important files
* AI guidance for safe code changes

---

## PROJECT_STRUCTURE.md

Categorized architecture overview.

Includes:

* Backend entry points
* Frontend entry points
* Route files
* Controller files
* Service files
* Model/entity files
* Database files
* Configuration files
* Test files
* Documentation files
* Deployment files

---

## API_ROUTES.md

Generated backend route documentation.

Example:

| Method | URI               | Handler              |
| ------ | ----------------- | -------------------- |
| GET    | api/products      | Product::table       |
| POST   | api/products/save | Product::saveProduct |

Currently supports CodeIgniter 4 and Laravel route extraction.

---

## PROJECT_TREE.md

Simple project tree showing folders and files.

---

## PROJECT_MAP.json

Machine-readable project metadata for AI tools and future integrations.

---

## SCAN_REPORT.md

Project statistics including:

* File counts
* Ignored paths
* File extension counts
* Scan errors

---

## FRAMEWORKS.md

Detected technology stack and frameworks.

---

# 🚫 Ignore Files

AI Project Scanner respects:

* `.gitignore`
* `.aiscannerignore`

Default ignored directories include:

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

---

# 💡 Why This Exists

AI assistants are powerful, but they often struggle with large existing projects because they often do not know:

* Project structure
* Entry points
* Framework stack
* Routes and handlers
* Important files
* Business logic locations
* Which files should not be modified

AI Project Scanner generates structured documentation so AI can understand projects faster and suggest safer, more accurate changes.

---

# 🔮 Future Universal Installation Options

## Docker

```bash
docker run --rm -v "$PWD:/project" ai-project-scanner scan /project
```

## NPM / NPX

```bash
npx ai-project-scanner scan .
```

---

## VS Code / Cursor / Windsurf Extension

Planned capabilities:

* Scan current workspace
* Regenerate AI documentation
* Open `PROJECT_CONTEXT.md`
* Provide AI-ready project context

---

# 🗺️ Roadmap

## v0.1.x

* ✅ Project tree generation
* ✅ JSON project map generation
* ✅ Scan report generation
* ✅ CLI support
* ✅ Composer package

## v0.2.x

* ✅ Framework detection
* ✅ Framework documentation
* ✅ Project context generation
* ✅ Universal project structure detection
* ✅ Project structure documentation

## v0.3.x

* ✅ PHAR build support
* ✅ CodeIgniter 4 API route extraction
* ✅ Laravel route extraction
* ✅ API route documentation generation
* ✅ Improved route summaries

## v0.4.x

* ⏳ Spring Boot route extraction
* ⏳ Express.js route extraction
* ⏳ FastAPI route extraction
* ⏳ Docker image support

## v0.5.x

* ⏳ NPM wrapper
* ⏳ `npx ai-project-scanner scan .`
* ⏳ VS Code extension

---

# 🚀 Future Enhancements

* Database relationship detection
* Dependency graph generation
* Module discovery
* AI prompt pack generation
* Plugin architecture

---

# 🤖 Example AI Workflow

Generate documentation:

```bash
php vendor/bin/ai-scan scan .
```

Then ask your AI assistant:

> Read `ai/PROJECT_CONTEXT.md` first. Then use `ai/PROJECT_STRUCTURE.md`, `ai/API_ROUTES.md`, and `ai/PROJECT_MAP.json`. I want to fix a bug in the quotation module. Suggest which files I should inspect and what changes may be required.

---

# 🤝 Contributing

Contributions are welcome.

Please review:

* `CONTRIBUTING.md`
* `CODE_OF_CONDUCT.md`
* `SECURITY.md`

Recommended workflow:

```bash
git checkout main
git pull
git checkout -b feature/your-feature-name
```

Then create a Pull Request.

---

# 📄 License

This project is licensed under the MIT License.

See:

```text
LICENSE
```

---

# 📦 Package

**Packagist**

```bash
mohammedsameer/ai-project-scanner
```

Install:

```bash
composer require mohammedsameer/ai-project-scanner
```

---

# 🧭 Philosophy

Built by developers tired of explaining the same project to AI every day.

AI Project Scanner exists to make software projects easier for both humans and AI to understand.
