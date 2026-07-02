# Architectural Decisions

## ADR-001

Decision:
Use PHP as the implementation language.

Reason:
- Fast MVP
- Composer ecosystem
- Existing expertise
- Easy CI4 integration

Future:
Core architecture remains language independent.

## API Route Extraction

Route extraction is implemented as part of the scanner output because AI assistants need route-to-handler mapping before suggesting backend or frontend integration changes.

Current route extraction supports:

- CodeIgniter4
- Laravel

Future framework support will be added incrementally.