# ADR-014: Generate Framework Documentation

## Status

Accepted

## Context

Framework detection results should be available in a human-readable format.

## Decision

Generate `FRAMEWORKS.md` from `FrameworkDetectionResult`.

## Consequences

### Positive

- Helps developers quickly understand project technology stack
- Gives AI tools a dedicated framework summary
- Supports future framework-specific documentation

### Negative

- Adds another generated artifact