# ADR-017: Generate Project Context Documentation

## Status

Accepted

## Context

AI assistants need a high-level project summary before reading detailed files.

Tree, JSON, framework, and scan report outputs are useful, but they do not provide a single onboarding document.

## Decision

Generate `PROJECT_CONTEXT.md` as the primary AI onboarding document.

It will summarize project metadata, detected frameworks, important directories, important files, and AI guidance.

## Consequences

### Positive

- Gives AI tools a clear starting point
- Improves usefulness for bug fixes and feature updates
- Reduces repeated project explanation

### Negative

- Requires keeping context guidance accurate as the scanner evolves