# Indice della Documentazione - Modulo Tenant

## Panoramica
Questo documento serve come indice centrale per il modulo Tenant, fornendo una guida per la gestione del multi-tenancy all'interno di un'applicazione Laravel. Il modulo Tenant gestisce la creazione, configurazione e isolamento di tenant multipli con supporto per database separati e isolamento dei dati.

**Ultimo Aggiornamento**: 2026-06-30  
**Stato**: ✅ PHPStan Level 10 Compliant  
**Versione Modulo**: 1.8.0  

## 🎯 Lettura Essenziale
1. [README.md](./README.md) - Panoramica del sistema Multi-tenancy.
2. [prd.md](./prd.md) - Product Requirements Document (PRD).
3. [roadmap.md](./roadmap.md) - Evoluzione 2026: Dinamismo estremo e performance.
4. [philosophy.md](./philosophy.md) - "Ognuno nel suo spazio": filosofia dell'isolamento.

## 🏗️ Architettura & Logica
- 🏛️ [Modular Monolith](./modular-monolith-architecture.md) - Come il Tenant abilita la modularità.
- ⚙️ [Configuration Logic](./configuration-logic-analysis.md) - Risoluzione gerarchica della configurazione.
- 📂 [Database Population](./database-population.md) - Strategie per il seeding e la migrazione dei Tenant.
- 🧬 [Tenant Config Path](./tenant-config-path-philosophy-debate.md) - Filosofia della gestione dei path configurazione.
- 🐚 [Console Integration](./resolve-tenant-config-console-debate.md) - Risoluzione del tenant nei comandi CLI.
- 🍣 [Sushi to JSON](./sushi-to-json-fix-plan.md) - Gestione dei dati statici e semi-statici dei Tenant.
- ⚡ [Performance Optimization](./performance-optimization.md) - Ottimizzazione delle performance e del caricamento.
- 🧩 [On-Demand Pattern](./on-demand-pattern.md) - Pattern di caricamento on-demand per i tenant.

## 🧪 Qualità, Sviluppo & Testing
- ✅ [PHPStan Analysis](./phpstan-level10-fixes.md) - Report di conformità Level 10.
- 🔬 [Testing Guidelines](./testing.md) - Verifica dell'isolamento dei dati tra tenant.
- 🧹 [Cyclomatic Complexity Report](./cyclomatic-complexity-report.md) - Analisi della complessità della logica di routing.
- 🐒 [Chaos Monkey Tenant Isolation Checklist](./chaos-monkey-tenant-isolation-checklist.md) - Checklist operativa per fault su multi-tenant/database.
- 🧪 [Testing Rules](./testing-rules.md) - Regole di testing ed isolamento.

## 📈 Gestione di Prodotto & Strategia
- 🗺️ [Product Roadmap](./product-roadmap.md) - Roadmap di prodotto orientata al 2026.
- 🚀 [Product Launch Plan](./product-launch-plan.md) - Piano di lancio sul mercato.
- 📊 [Product Strategy](./product-strategy.md) - Strategia commerciale e di posizionamento.
- 👥 [User Research](./user-research.md) - Ricerche sugli utenti ed analisi dei pain point.
- 📅 [Sprint Planning](./sprint-planning.md) - Organizzazione dello sviluppo agile.

## 🧹 Manutenzione & Cleanup
- 🗑️ [Duplicate Files to Remove](./duplicate-files-to-remove.md) - Eliminazione dei file duplicati e obsoleti.
- 🔍 [Metodi Duplicati Analisi](./metodi-duplicati-analisi.md) - Risoluzione della ridondanza di codice nel modulo.
- 🔄 [Updates](./updates.md) - Registro degli aggiornamenti e correzioni architetturali.

## 🔗 Moduli Correlati
- [Xot](../../Xot/docs/README.md) - Base framework per i Service Provider.
- [User](../../User/docs/README.md) - Associatione Utente-Tenant e permessi.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
