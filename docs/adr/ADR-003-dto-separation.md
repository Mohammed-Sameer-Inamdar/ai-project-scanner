# ADR-003: Separate DTOs from Core Classes

## Status

Accepted

## Context

Some classes represent application behavior while others only carry data.

Mixing both responsibilities increases coupling and makes maintenance more difficult.

## Decision

Data Transfer Objects (DTOs) will reside in a dedicated DTO namespace.

Business logic and application services will remain inside the Core namespace.

Examples:

Core

- AIProjectScanner
- ScanContext

DTO

- ScanResult
- FileNode
- DirectoryNode

## Consequences

### Positive

- Clear responsibilities
- Easier unit testing
- Better scalability
- Cleaner architecture

### Negative

- Additional namespaces
- Slightly more files

## Future Considerations

As more parsers and generators are added, new DTOs should always be created inside the DTO namespace rather than inside Core.