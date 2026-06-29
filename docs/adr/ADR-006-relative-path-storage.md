# ADR-006: Store Relative Paths in Scan Results

## Status

Accepted

## Context

Scanner outputs may be committed to Git, shared with teammates, or generated on different machines.

Absolute paths such as `C:\xampp\htdocs\project\app\Controllers\Product.php` are machine-specific and not portable.

## Decision

Scanner DTOs and generated outputs will store project-relative paths.

Example:

`app/Controllers/Product.php`

instead of:

`C:\xampp\htdocs\project\app\Controllers\Product.php`

## Consequences

### Positive

- Portable output
- Cleaner generated documentation
- Better Git diffs
- Easier sharing across systems

### Negative

- Consumers needing absolute paths must combine `projectRoot` with the relative path.

## Future Considerations

If absolute paths are needed by internal tools, they should be calculated at runtime and not stored in generated output.