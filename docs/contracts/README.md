---
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-26
qmd: "contratti tenant metodo harness contratto comportamento action input output invarianti effetti collaterali"
---

# Contratti

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `TENANT-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

- [GetTenantNameAction](get-tenant-name-action.md) — risolve il nome del tenant corrente dall'host; da qui dipende l'isolamento di tutti i file tenant (5 invarianti, 0 dimostrate).
- [GetTenantFilePathAction](get-tenant-file-path-action.md) — percorso assoluto di un file tenant, con difesa da path traversal e isolamento dei JSON nei test (3 invarianti, 3 dimostrate).
- [SaveTenantConfigAction](save-tenant-config-action.md) — fonde dati nuovi nel file di config del tenant e lo riscrive (file versionato del sito) (4 invarianti, 3 dimostrate).
- [CreateJsonFileByRecordAction](create-json-file-by-record-action.md) — aggiunge al JSON del tenant la riga di un record Sushi in creazione (3 invarianti, 2 dimostrate).
- [UpdateJsonFileByRecordAction](update-json-file-by-record-action.md) — sostituisce nel JSON del tenant la riga di un record Sushi in aggiornamento (4 invarianti, 0 dimostrate).
- [DeleteJsonFileByRecordAction](delete-json-file-by-record-action.md) — rimuove dal JSON del tenant la riga di un record Sushi in cancellazione (3 invarianti, 0 dimostrate).
- [GetEnteDataAction](get-ente-data-action.md) — legge `config('ente')` e restituisce i dati dell'ente già normalizzati e validati per il front office (6 invarianti, 0 dimostrate).
- [GetTenantConfigValueAction](get-tenant-config-value-action.md) — valore di config con i valori del tenant sovrapposti a quelli base (4 invarianti, 0 dimostrate).
- [GetTenantModelClassAction](get-tenant-model-class-action.md) — risolve la classe di un model dal nome, usando la morph map del tenant e persistendola se manca (5 invarianti, 0 dimostrate).
- [GetTenantModelInstanceAction](get-tenant-model-instance-action.md) — istanza nuova del model risolto dal nome (2 invarianti, 0 dimostrate).
- [GetTenantConfigArrayAction](get-tenant-config-array-action.md) — legge un file di config del tenant come array, senza errori (3 invarianti, 0 dimostrate).
- [GetTenantConfigNamesAction](get-tenant-config-names-action.md) — elenca i file `.php` di config del tenant corrente (2 invarianti, 0 dimostrate).
- [GetTenantConfigPathAction](get-tenant-config-path-action.md) — prefissa una chiave di config con il percorso del tenant in notazione a punti (2 invarianti, 0 dimostrate).
- [GetTenantModulesAction](get-tenant-modules-action.md) — elenca i moduli abilitati nel `modules_statuses.json` del tenant (2 invarianti, 0 dimostrate).
- [GetDomainsArrayAction](get-domains-array-action.md) — elenca i domini dei tenant scansionando le cartelle di `config_path()` (3 invarianti, 0 dimostrate).
- [GetLocalizedMarkdownPathAction](get-localized-markdown-path-action.md) — percorso del markdown del tenant nella lingua corrente, con ripiego sul file senza lingua (4 invarianti, 0 dimostrate).
- [TranslateTenantKeyAction](translate-tenant-key-action.md) — traduce una chiave dai file di lingua del tenant (3 invarianti, 0 dimostrate).
- [FilterConfigStringKeysAction](filter-config-string-keys-action.md) — tiene solo le voci con chiave stringa di un array di config (3 invarianti, 0 dimostrate).
- [MergeRecursiveStringKeyConfigAction](merge-recursive-string-key-config-action.md) — fonde più array di config tenendo solo le chiavi stringa (2 invarianti, 0 dimostrate).

- [index](index.md) — registro operativo: operazione, classe, invarianti, copertura, comando.

## Stato di copertura

Contratti: 19. Invarianti: 63, dimostrate da un test `->group('<ID>')`: 8 (conteggio del 2026-11-26 con `rg "group\(" tests`). Le altre portano «— (non dimostrato)» nella colonna Group.

## Backlog contract

Nessuno: tutte le 19 Action con `@contract` in `app/Actions` hanno un contratto. `Config/ResolveTenantConfigValueAction.php` è un alias che delega a `GetTenantConfigValueAction` (contratto già coperto) e non ha `@contract`.

## Backlog test

Invarianti senza test con group (da scrivere o da annotare quando un test esistente le prova davvero):

- `TENANT-NAME-INV-1` (get-tenant-name-action)
- `TENANT-NAME-INV-2` (get-tenant-name-action)
- `TENANT-NAME-INV-3` (get-tenant-name-action)
- `TENANT-NAME-INV-4` (get-tenant-name-action)
- `TENANT-NAME-INV-5` (get-tenant-name-action)
- `TENANT-CONFIG-SAVE-INV-4` (save-tenant-config-action)
- `TENANT-JSON-CREATE-INV-3` (create-json-file-by-record-action)
- `TENANT-JSON-UPDATE-INV-1` (update-json-file-by-record-action)
- `TENANT-JSON-UPDATE-INV-2` (update-json-file-by-record-action)
- `TENANT-JSON-UPDATE-INV-3` (update-json-file-by-record-action)
- `TENANT-JSON-UPDATE-INV-4` (update-json-file-by-record-action)
- `TENANT-JSON-DELETE-INV-1` (delete-json-file-by-record-action)
- `TENANT-JSON-DELETE-INV-2` (delete-json-file-by-record-action)
- `TENANT-JSON-DELETE-INV-3` (delete-json-file-by-record-action)
- `TENANT-ENTE-INV-1` (get-ente-data-action)
- `TENANT-ENTE-INV-2` (get-ente-data-action)
- `TENANT-ENTE-INV-3` (get-ente-data-action)
- `TENANT-ENTE-INV-4` (get-ente-data-action)
- `TENANT-ENTE-INV-5` (get-ente-data-action)
- `TENANT-ENTE-INV-6` (get-ente-data-action)
- `TENANT-CONFIG-VALUE-INV-1` (get-tenant-config-value-action)
- `TENANT-CONFIG-VALUE-INV-2` (get-tenant-config-value-action)
- `TENANT-CONFIG-VALUE-INV-3` (get-tenant-config-value-action)
- `TENANT-CONFIG-VALUE-INV-4` (get-tenant-config-value-action)
- `TENANT-MODEL-CLASS-INV-1` (get-tenant-model-class-action)
- `TENANT-MODEL-CLASS-INV-2` (get-tenant-model-class-action)
- `TENANT-MODEL-CLASS-INV-3` (get-tenant-model-class-action)
- `TENANT-MODEL-CLASS-INV-4` (get-tenant-model-class-action)
- `TENANT-MODEL-CLASS-INV-5` (get-tenant-model-class-action)
- `TENANT-MODEL-INST-INV-1` (get-tenant-model-instance-action)
- `TENANT-MODEL-INST-INV-2` (get-tenant-model-instance-action)
- `TENANT-CFG-ARR-INV-1` (get-tenant-config-array-action)
- `TENANT-CFG-ARR-INV-2` (get-tenant-config-array-action)
- `TENANT-CFG-ARR-INV-3` (get-tenant-config-array-action)
- `TENANT-CFG-NAMES-INV-1` (get-tenant-config-names-action)
- `TENANT-CFG-NAMES-INV-2` (get-tenant-config-names-action)
- `TENANT-CFG-PATH-INV-1` (get-tenant-config-path-action)
- `TENANT-CFG-PATH-INV-2` (get-tenant-config-path-action)
- `TENANT-MODULES-INV-1` (get-tenant-modules-action)
- `TENANT-MODULES-INV-2` (get-tenant-modules-action)
- `TENANT-DOMAINS-INV-1` (get-domains-array-action)
- `TENANT-DOMAINS-INV-2` (get-domains-array-action)
- `TENANT-DOMAINS-INV-3` (get-domains-array-action)
- `TENANT-MD-INV-1` (get-localized-markdown-path-action)
- `TENANT-MD-INV-2` (get-localized-markdown-path-action)
- `TENANT-MD-INV-3` (get-localized-markdown-path-action)
- `TENANT-MD-INV-4` (get-localized-markdown-path-action)
- `TENANT-TRANS-INV-1` (translate-tenant-key-action)
- `TENANT-TRANS-INV-2` (translate-tenant-key-action)
- `TENANT-TRANS-INV-3` (translate-tenant-key-action)
- `TENANT-FILTER-INV-1` (filter-config-string-keys-action)
- `TENANT-FILTER-INV-2` (filter-config-string-keys-action)
- `TENANT-FILTER-INV-3` (filter-config-string-keys-action)
- `TENANT-MERGE-INV-1` (merge-recursive-string-key-config-action)
- `TENANT-MERGE-INV-2` (merge-recursive-string-key-config-action)
