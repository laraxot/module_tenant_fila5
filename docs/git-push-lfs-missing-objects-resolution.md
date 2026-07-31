---
title: "Git push bloccato — Git LFS missing objects (GH008)"
module: "Tenant"
type: incident
tags: [git, git-lfs, push, incident]
created: 2026-07-28
updated: 2026-07-28
qmd: "git lfs missing objects push rejected GH008 pre-receive hook Tenant"
related:
  - "./00-index.md"
---

# Git push bloccato — Git LFS missing objects (GH008)

## Sintomo

```
remote: error: GH008: Your push referenced at least 16 unknown Git LFS objects:
remote:     6126375ccbb3811d335007914fb1b2f90bf1ab199054855f602ad3de3d1121a1
remote:     ...
remote: Try to push them with 'git lfs push --all'.
 ! [remote rejected] dev -> dev (pre-receive hook declined)
```

`git push` verso `provtv` (remote `provtv/module_tenant_fila5.git`) rifiutato dal pre-receive
hook di GitHub. Il remote `laraxot` invece ha accettato il push senza errori.

## Causa

In 16 file (15 in `resources/img/` e `resources/svg/`, incluso `resources/svg/navigation/*`,
più `docs/screenshots/event-detail-page.png.backup-copilot`) la storia Git contiene un commit
storico in cui il file era tracciato come **puntatore Git LFS** (`version
https://git-lfs.github.com/spec/v1\noid sha256:...\nsize ...`). Il blob binario reale
corrispondente a quell'`oid` non fu mai caricato su nessun LFS store remoto (verificato: 404
sia su `provtv` che su `laraxot` via `git lfs fetch --all`).

Il commit con il puntatore era **già presente** su `laraxot/dev` (accettato in passato,
prima che l'enforcement GH008 fosse attivo o rilevante per quella storia già nota al
remote), quindi pushare *nuovi* commit sopra quello storico non ha riattivato la
validazione LFS lì. Su `provtv/dev` invece quello stesso commit storico era ancora
**nuovo per il remote**, quindi GitHub ha validato l'intero range e ha trovato gli oggetti
LFS mancanti.

In 15 dei 16 file, il commit **attuale (HEAD)** contiene il blob binario reale (non più un
puntatore LFS) — cioè in un punto successivo della storia qualcuno ha "de-LFS-ato" il file
sostituendo il puntatore con il contenuto vero, ma senza mai caricare l'oggetto LFS storico
richiesto dal push. Il 16° file (`event-detail-page.png.backup-copilot`, un backup Copilot,
già rimosso in un commit successivo) non esiste più nel working tree corrente: la storia
contiene solo il puntatore, mai il contenuto.

## Regola del progetto: git va solo in avanti

Niente `checkout`/`revert`/`rollback`/`rebase`/`filter-branch`/`git lfs migrate` per
"pulire" la storia: riscriverebbe gli hash dei commit. La soluzione doveva essere
**additiva**: fornire gli oggetti LFS mancanti, non rimuovere i riferimenti storici.

## Risoluzione (verificata, senza riscrivere la storia)

1. `git lfs ls-files --all` → lista dei 16 oid mancanti (15 presenti nel tree corrente
   con `*`, 1 assente con `-`).
2. Per i 15 file presenti: calcolato `sha256sum` del contenuto attuale su disco e
   confrontato con l'oid richiesto da `git lfs ls-files --all` → **match esatto** per
   tutti e 15 (il contenuto binario non è mai cambiato tra la versione-puntatore storica
   e la versione-blob attuale, solo il meccanismo di storage).
3. Backfill locale: copiati i 15 file in `.git/lfs/objects/{oid:0:2}/{oid:2:4}/{oid}`
   (formato di storage content-addressable di git-lfs) — nessun comando git-history-rewriting,
   solo popolamento della cache locale LFS.
4. Per il 16° file (già cancellato dal working tree): individuata una copia storica
   identica su un backup locale (`/media/zorin/nas06/.../base_fixcity_fila5_20260618-1722/
   laravel/Modules/Tenant/docs/screenshots/event-detail-page.png`, snapshot del
   2026-06-18) — verificato size (121507 byte) e `sha256sum` identici all'oid richiesto,
   poi backfillato allo stesso modo.
5. `git lfs fsck` → OK (16/16 oggetti locali validi).
6. `git lfs push provtv --all` → upload dei 16 oggetti riusciti.
7. `git push provtv dev` → accettato.

## Verifica

```bash
cd laravel/Modules/Tenant
git lfs fsck               # Git LFS fsck OK
git status                 # working tree clean, up to date with provtv/dev
git log --oneline -3       # HEAD allineato su entrambi i remote
```

## Lezione per il futuro

- Se un file viene tracciato con Git LFS e poi il tracking viene rimosso (`.gitattributes`
  modificato, file ri-aggiunto come blob normale), **il vecchio oggetto LFS storico va
  comunque caricato almeno una volta** su ogni remote a cui si farà push in futuro — altrimenti
  qualunque push che re-includa quel range storico verso un remote che non l'ha mai visto
  fallirà con GH008, anche se il file al commit attuale non è più un puntatore.
- `git lfs ls-files --all` (non solo senza `--all`) è il comando giusto per scoprire
  riferimenti LFS "fantasma" rimasti solo nella storia.
- Se il contenuto attuale su disco ha lo stesso `sha256sum` dell'oid richiesto, il backfill
  locale (`.git/lfs/objects/xx/yy/<oid>` + `git lfs push --all`) è sicuro e non tocca la
  storia — non è un workaround pericoloso, è semplicemente "fornire il blob che l'oid già
  richiedeva".
