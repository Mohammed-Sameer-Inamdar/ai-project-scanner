# ADR-015: Introduce Analysis Pipeline

## Status

Accepted

## Context

As the package evolves, multiple detectors and analyzers will require orchestration.

Examples include:

- Framework detection
- Module detection
- Route detection
- API detection
- Database relationship detection

## Decision

Introduce an analysis pipeline architecture.

Scanner produces ScanResult.

Detectors consume ScanResult.

Generators consume detector results.

## Consequences

### Positive

- Extensible architecture
- Single source of truth
- No duplicate filesystem traversal

### Negative

- Additional abstraction layer