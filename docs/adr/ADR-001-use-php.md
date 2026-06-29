# ADR-001: Use PHP as the Primary Development Language

## Status

Accepted

## Context

AI Project Scanner is intended to become a reusable tool that generates AI-ready documentation for software projects.

The implementation language needed to satisfy the following goals:

- Fast MVP development
- Easy contribution
- Simple installation
- Native support for CodeIgniter 4
- Composer package distribution

Alternative languages considered:

- Python
- Java
- Go
- Rust

## Decision

The project will initially be implemented in PHP 8.1+.

The architecture will remain language-independent wherever possible so that the core engine can be migrated or extended in the future if required.

## Consequences

### Positive

- Fast development
- Familiar technology stack
- Easy Composer distribution
- Native integration with CodeIgniter projects

### Negative

- PHP has fewer static analysis libraries compared to Python.
- Some future AI capabilities may require external services or a separate engine.

## Future Considerations

If future requirements demand advanced semantic analysis or AI-native features, the scanning engine may be rewritten while preserving the public architecture and output format.