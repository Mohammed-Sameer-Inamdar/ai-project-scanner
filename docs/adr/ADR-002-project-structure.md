# ADR-002: Modular Project Structure

## Status

Accepted

## Context

The project will continue to grow with new scanners, parsers and generators.

A monolithic structure would become difficult to maintain.

## Decision

The project will be organized into independent modules with clear responsibilities.

Current structure:

- Core
- Scanner
- Generator
- DTO
- Contracts
- Utils
- Exceptions

Each module is responsible for a single area of the application.

## Consequences

### Positive

- Better maintainability
- Easier testing
- Clear separation of concerns
- Easier onboarding for contributors

### Negative

- More files in the project
- Slightly more navigation for small features

## Future Considerations

New frameworks such as Laravel, Spring Boot, React, NestJS and others should be added by extending existing modules instead of modifying the core architecture.