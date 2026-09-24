---
title: "Memories Index"
type: index
created: 2026-05-11
<<<<<<< .merge_file_Pv2g9W
<<<<<<< HEAD
updated: 2026-07-27
tags: [memories, index, on-demand, github, remote]
=======
updated: 2026-05-11
tags: [memories, index, on-demand]
>>>>>>> 1ad0554 (.)
=======
updated: 2026-05-11
tags: [memories, index, on-demand]
>>>>>>> .merge_file_HShCsU
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
---

# Memories Index

Le Memories progettuali vivono qui, nel wiki del Module **Tenant**, e vengono caricate **on-demand**.

> Vedi anche → [Trigger Map](../rules/00-TRIGGER_MAP.md)

## Regola

1. individua il trigger del task
2. consulta `../rules/00-TRIGGER_MAP.md`
3. se serve, esegui `qmd search "<topic>"`
4. leggi solo la Memories wiki pertinente

## Pattern di caricamento

| Pattern | Comando |
|---------|---------|
| Carica Memories specifica | `Read ../memories/<name>.md` |
| Ricerca semantica | `qmd search "<topic>"` |
| Via trigger map | Consulta `../rules/00-TRIGGER_MAP.md` |

## Note

- La sorgente di verita' per le Memories e' sempre il wiki locale
- Non embeddare Memories nei prompt di avvio
<<<<<<< HEAD
- Per Memories globali, consulta il [wiki root](../../docs/wiki/memories/INDEX.md)

<<<<<<< .merge_file_Pv2g9W
## Memories locali (ricorrenti)

| Trigger | File |
|---------|------|
| Link GitHub / merge su `base_*` / `git remote -v` | [github-remote-collision-wrong-base.md](./github-remote-collision-wrong-base.md) |
=======
- Per Memories globali, consulta il [wiki root](../../../../../../docs/wiki/memories/INDEX.md)
>>>>>>> 1ad0554 (.)

=======
>>>>>>> .merge_file_HShCsU
## Aggiungere una Nuova MEMORIES

1. Crea `../memories/<nome>.md` con contenuto completo
2. Aggiungi la voce in `../rules/00-TRIGGER_MAP.md`
3. Aggiorna questo indice se la Memories e' ricorrente
4. Committa: `docs: add memories <nome>`

