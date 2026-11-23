---
status: proposed
date: 2026-11-23
decision-makers: Tenant module owner
---

# La configurazione tenant si risolve come overlay centralizzato

## Contesto

Tenant deve esporre valori coerenti nei diversi contesti applicativi senza copiare
la logica in ogni consumer. Il modello `Tenant` identifica il tenant; Actions
dedicate risolvono l'overlay e persistono i file tenant. La decisione risponde a
questa domanda: come si applica una configurazione specifica senza perdere i default?

## Driver della decisione

- mantenere i default Laravel come base;
- applicare override tenant in modo uniforme tramite un punto d'ingresso;
- distinguere risoluzione runtime e persistenza;
- evitare che ogni modulo conosca percorso e formato dei file tenant.

## Alternative scartate

- Far leggere a ogni modulo direttamente i file tenant: duplicherrebbe risoluzione,
  merge e gestione dei default.
- Usare esclusivamente `.env` per i valori tenant: non rappresenta un override per
  tenant e non segue il contesto corrente.
- Sostituire interamente la configurazione base: farebbe perdere chiavi non override.

## Decisione

Tenant usa un **overlay centralizzato**: `ResolveTenantConfigValueAction` parte dalla
configurazione base, applica con `array_replace_recursive` l'override del tenant e
restituisce la chiave richiesta; `SaveTenantConfigAction` è il punto di persistenza e
conserva le altre chiavi, distinguendo mappe da liste. `Tenant` resta l'entità di
riferimento del contesto.

## Conseguenze

- Buono, perché i consumer leggono una risoluzione uniforme e i default restano
  disponibili.
- Buono, perché la scrittura non richiede ai consumer conoscenza del filesystem.
- Cattivo, perché la risoluzione modifica il repository runtime di `Config` e il
  contesto deve essere isolato tra richieste, job e comandi.
- Cattivo, perché una chiave fuori dal tipo restituito dalle Actions richiede una
  decisione esplicita prima di essere introdotta.

## Conferma

- Risoluzione: [`ResolveTenantConfigValueAction`](../../app/Actions/Config/ResolveTenantConfigValueAction.php).
- Persistenza: [`SaveTenantConfigAction`](../../app/Actions/Config/SaveTenantConfigAction.php).
- Entità: [`Tenant`](../../app/Models/Tenant.php).
- Riferimento: [`docs/architecture.md`](../architecture.md).
