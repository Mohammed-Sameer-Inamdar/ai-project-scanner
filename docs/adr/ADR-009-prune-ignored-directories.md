# ADR-009: Prune Ignored Directories During Scanning

## Status

Accepted

## Context

The scanner currently walks into ignored directories such as `.git`, `vendor`, `node_modules`, and `ai`.

This increases scan time and memory usage because every child path is visited even though the parent directory is already ignored.

## Decision

When a directory matches an ignore pattern, the scanner will record that directory as ignored and skip traversing its children.

## Consequences

### Positive

- Faster scans
- Lower memory usage
- Smaller ignored path lists
- Cleaner generated reports

### Negative

- Ignored child paths will not be listed individually.

## Future Considerations

Verbose mode may optionally show skipped directory summaries such as `vendor/ skipped`.