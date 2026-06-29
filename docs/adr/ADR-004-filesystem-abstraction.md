# ADR-004: Introduce FileSystem Abstraction

## Status

Accepted

## Context

Direct use of PHP filesystem functions such as `file_exists()`, `mkdir()`, `file_get_contents()` and `scandir()` tightly couples the application to the local filesystem.

This makes testing difficult and limits future extensibility.

Future versions of AI Project Scanner may need to support:

* ZIP archives
* Remote repositories
* In-memory filesystems
* GitHub repositories
* Virtual filesystems

## Decision

Introduce a `FileSystemInterface` abstraction.

Concrete implementations will provide filesystem operations while the rest of the application depends only on the contract.

Initial implementation:

* FileSystem

Future implementations may include:

* ZipFileSystem
* MemoryFileSystem
* GitHubFileSystem

## Consequences

### Positive

* Improved testability
* Reduced coupling
* Easier future extensibility
* Cleaner architecture

### Negative

* Additional abstraction layer
* Slightly more implementation effort

## Future Considerations

All scanners, parsers and generators should depend on `FileSystemInterface` rather than directly using PHP filesystem functions.
