---
title: "ADR — Configurazione Tenant risolta da Action"
type: decision
status: accepted
created: 2026-11-23
updated: 2026-11-23
issues: []
module: Tenant
---

# ADR — Configurazione Tenant risolta da Action

## Contesto

La configurazione tenant deve essere coerente in web, console, queue e scheduler.

## Driver della decisione

- Evitare risoluzioni diverse per lo stesso tenant.

## Decisione

Tenant risolve valori e merge tramite Action condivisa in tutti i contesti applicativi.

## Alternative scartate

- Leggere configurazione tenant direttamente da ogni provider.

## Conseguenze

La precedenza è centralizzata; ogni nuova chiave deve definire fallback e isolamento.

## Conferma

Verificare Action, merge ricorsivo e test nei contesti supportati.
