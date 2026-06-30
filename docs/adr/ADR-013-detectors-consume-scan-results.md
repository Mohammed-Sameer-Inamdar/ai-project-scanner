# ADR-013: Detectors Consume Scan Results

## Status

Accepted

## Context

Framework and module detection should work for nested projects, monorepos, and mixed technology stacks.

Direct filesystem checks only work for simple root-level projects and can miss nested applications such as `react/package.json`.

## Decision

Detectors will consume `ScanResult` produced by `FileScanner`.

They may use `projectRoot` only when file contents need to be read, such as inspecting `package.json`.

## Consequences

### Positive

- Supports nested projects
- Avoids duplicate filesystem traversal
- Reuses scanner ignore rules
- Improves consistency across detectors and generators

### Negative

- Detection requires a scan to be completed first

## Future Considerations

Framework detection results may be added into `PROJECT_MAP.json` and dedicated `FRAMEWORKS.md`.