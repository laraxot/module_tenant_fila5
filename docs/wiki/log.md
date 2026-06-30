---
title: "Activity Log"
module: "Tenant"
---

# Activity Log — Tenant

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

## [2026-06-30] [LINT] Removed duplicate uppercase Tests directory

- Regola: il modulo Tenant usa solo `tests/`.
- `Tests/` era duplicata rispetto a `tests/` e non deve esistere.
- Wiki: `docs/wiki/concepts/lowercase-tests-directory.md`.

### Format

```
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**
- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page

---

**Last Activity:** 2026-06-30  
**Total Operations:** 1
