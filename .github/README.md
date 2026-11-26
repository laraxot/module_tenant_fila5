---
title: "Tenant — GitHub"
type: note
tags: [documentation, github]
created: 2026-11-26
updated: 2026-11-26
qmd: "github readme Tenant"
---

# Tenant

Modulo Laravel (nwidart/laravel-modules), pacchetto Composer indipendente (`laraxot/module_tenant_fila5`).
Multi-tenancy.

Leggimi anche: [README del pacchetto](https://github.com/laraxot/module_tenant_fila5#readme) ·
[Documentazione](https://github.com/laraxot/module_tenant_fila5/tree/dev/docs) ·
[CHANGELOG](https://github.com/laraxot/module_tenant_fila5/blob/dev/CHANGELOG.md) (se presente).

## Link rapidi

- [Issue](https://github.com/laraxot/module_tenant_fila5/issues) · [Pull request](https://github.com/laraxot/module_tenant_fila5/pulls)
- [Discussions](https://github.com/laraxot/module_tenant_fila5/discussions) · [Actions](https://github.com/laraxot/module_tenant_fila5/actions)
- [Milestone](https://github.com/laraxot/module_tenant_fila5/milestones) · [Label](https://github.com/laraxot/module_tenant_fila5/labels)
- [Wiki](https://github.com/laraxot/module_tenant_fila5/wiki) · [Security](https://github.com/laraxot/module_tenant_fila5/security)


## Manuali

- [Manuale utente](https://github.com/laraxot/module_tenant_fila5/blob/dev/docs/manuals/manuale-utente.md)

## Sviluppo

- Repository autonomo: può essere installato in qualsiasi progetto Laravel compatibile (PHP 8.4+, Laravel 13).
- Branch di lavoro: `dev`. Mai branch personali, mai force-push.
- Conventional Commits; ogni commit di un agente cita la sua issue: `(#N)`. Se l'issue non esiste, si apre prima.
- Test e analisi statica girano nel contesto dell'applicazione host (PHPUnit/Pest, PHPStan, Pint): questo repository non include `vendor/`.

## Documentazione

- `docs/` contiene **al massimo 100 file `.md`**; il materiale non canonico vive in `archive/` o nella storia git.
- `docs/adr/` per le decisioni architetturali, `docs/contracts/` per i contratti delle Action/interfacce, `docs/stories/` per il lavoro tracciato.
- Nomi file `.md` senza date/timestamp/suffissi numerici.

## Qualità

- Licenza: module for the Laraxot ecosystem: single application instance serving multiple tenants with data isolation. MIT.
- Pipeline: vedi [Actions](https://github.com/laraxot/module_tenant_fila5/actions). 

---
_Mantenuto nel repository `laraxot/module_tenant_fila5`; per questioni sul modulo aprire una [issue](https://github.com/laraxot/module_tenant_fila5/issues)._
