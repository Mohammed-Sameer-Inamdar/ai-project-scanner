# ADR-011: Introduce ProjectScanner Orchestrator

## Status

Accepted

## Context

Multiple generators exist and require coordination.

Running generators individually leads to duplicated setup and fragmented workflows.

## Decision

Introduce ProjectScanner as the central orchestrator.

ProjectScanner will:

- execute FileScanner
- obtain ScanResult
- invoke all configured generators

## Consequences

### Positive

- Single entry point
- Reduced duplication
- Easier CLI integration
- Better extensibility

### Negative

- Additional orchestration layer