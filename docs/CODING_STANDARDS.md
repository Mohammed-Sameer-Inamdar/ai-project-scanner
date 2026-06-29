# Coding Standards

## PHP Version

- PHP 8.1 or later

---

## General

- Enable `declare(strict_types=1);` in every PHP file.
- Follow PSR-12 coding standards.
- One class per file.
- Use namespaces for every class.
- Prefer immutable objects.
- Keep methods small and focused.
- Avoid duplicate code.
- Avoid magic strings and magic numbers.
- Use descriptive variable and method names.

---

## Classes

- Classes are `final` by default.
- Remove `final` only when inheritance is intentionally supported.
- Constructor injection is preferred.
- Use `readonly` properties whenever possible.
- Public properties are not allowed.
- Single Responsibility Principle should always be followed.

---

## Methods

- Keep methods focused on a single responsibility.
- Prefer early returns over nested conditions.
- Avoid methods longer than 40-50 lines unless justified.
- Public methods should have meaningful names.

---

## Git Workflow

- Create a feature branch for every feature.
- Commit frequently.
- Use meaningful commit messages.
- Merge only after review.
- Keep `main` stable.

Commit format:

feat:
fix:
refactor:
docs:
test:
chore:

---

## Documentation

- Every public class should have documentation.
- Add PHPDoc where it improves understanding.
- Maintain ADRs for important architectural decisions.
- Keep README updated.

---

## Testing

- Every new feature should eventually have unit tests.
- Bug fixes should include regression tests whenever practical.

---

## Performance

- Avoid unnecessary file reads.
- Minimize memory usage.
- Prefer streaming for large files where appropriate.
- Optimize for large projects.

---

## Future Goals

The project should remain:

- Framework independent
- Composer installable
- Extensible
- Testable
- Easy to contribute to