<<<<<<< .merge_file_mJQSMi
<<<<<<< HEAD
---
title: "Indice della Documentazione - Modulo Tenant"
module: "Tenant"
type: concept
tags: [index]
created: 2026-07-14
updated: 2026-07-24
qmd: "index modulo tenant bridge readme"
related:
  - "./README.md"
---

# Indice della Documentazione - Modulo Tenant

> **Verificato 2026-07-24**: la maggior parte dei link di questo indice autogenerato punta a file/sottocartelle
> mai esistiti (`architecture/`, `models/`, `forms/`, `phpstan/index.md`, `actions/index.md`, `console/index.md`,
> `enums/index.md`, `filament/index.md`, `services/index.md`, `traits/index.md`, `domain-management.md`,
> `data-isolation.md`, `separate-databases.md`, ecc.). Consolidato: usare **[README.md](./README.md)** come
> punto di ingresso — a sua volta corretto in questa sessione perché descriveva un'architettura
> (`TenantService`, `TenantSwitcher`, `SetTenant`, `BelongsToTenant`) in gran parte non implementata nel codice.

Doc verificati e presenti in `docs/`:
- [structure.md](./structure.md)
- [events.md](./events.md)
- [core-functionality.md](./core-functionality.md)
- [configuration.md](./configuration.md)
- [filament-resources.md](./filament-resources.md)
- [API.md](./API.md)
- [translations.md](./translations.md)
- [phpstan-cluster.md](./phpstan-cluster.md)
- [testing.md](./testing.md)
- [architecture.md](./architecture.md)
- [troubleshooting.md](./troubleshooting.md)
- [conflict-resolution.md](./conflict-resolution.md)

---

<!-- Merged from INDEX.md, which collided with this file on case-insensitive filesystems. -->

---
title: Tenant Module Documentation Index
module: Tenant
status: production
last_updated: 2026-07-28
---

# Tenant Module Documentation Index

**Last updated: 2026-07-28**

---

## Navigation

- [Overview](README.md) — Module description and quick start
- [Architecture](ARCHITECTURE.md) — System design and isolation strategies
- [API Reference](API.md) — Core models, contracts, and services
- [Patterns](PATTERNS.md) — Design patterns and best practices
- [Troubleshooting](TROUBLESHOOTING.md) — Common issues and solutions
- [Contributing](../../docs/wiki/how-to/contributing.md) — Development guidelines

---

## Module Statistics

**Last Generated: 2026-07-28**

| Category | Count | Description |
|----------|-------|-------------|
| Models | 15 | Tenant, Domain, TenantDomain, TenantSetting, TenantSubscription, etc. |
| Actions | 15 | Business logic components grouped by feature (Config, Domains, Models, etc.) |
| Services | 7 | Configuration resolvers, domain services, and utility services |
| Filament Resources | 7 | Admin panel resources and form components |
| Migrations | 3 | Database schema setup and evolution |
| Seeders | 9 | Database seed data for testing and development |
| Factories | 8 | Eloquent model factories for testing |
| Policies | 2 | Authorization policies for models |
| Traits | 4 | Reusable model traits |
| Providers | 4 | Service providers and registration |
| Contracts | 2 | Interfaces and abstraction contracts |
| Commands | 1 | Artisan console commands |

**Total: 78 PHP files**

---

## Recently Updated Files

| Date | File | Category |
|------|------|----------|
| 2026-07-28 | README.md | Documentation |
| 2026-07-28 | ARCHITECTURE.md | Documentation |
| 2026-07-28 | API.md | Documentation |
| 2026-07-28 | PATTERNS.md | Documentation |
| 2026-07-28 | TROUBLESHOOTING.md | Documentation |
| 2026-07-22 | Tenant.php | Model |
| 2026-07-22 | Domain.php | Model |
| 2026-07-22 | TenantDomain.php | Model |
| 2026-07-22 | TenantSubscription.php | Model |
| 2026-07-22 | TenantSetting.php | Model |

---

## Key Concepts

### Tenant Isolation
Each tenant operates in complete isolation:
- **Database Isolation**: Separate database per tenant or shared database with scoping
- **Configuration Isolation**: Per-tenant configuration settings
- **Domain Routing**: Automatic tenant resolution via domain/subdomain

### Core Models

- **Tenant**: Root tenant entity with settings and metadata
- **Domain**: Domain/subdomain associations for tenant routing
- **TenantDomain**: Junction model linking tenant to multiple domains
- **TenantSetting**: Key-value configuration storage
- **TenantSubscription**: Subscription and billing model

---

## Quick Links

- **Config**: `config/config.php`, `config/database.php`
- **Service Provider**: `app/Providers/TenantServiceProvider.php`
- **Contracts**: `app/Contracts/`
- **Tests**: `tests/` (refer to main project structure)

---

## Related Modules

- **[Xot](../../Xot/docs/index.md)** — Core framework and abstractions
- **[User](../../User/docs/index.md)** — User management and authentication

---

## Development Guidelines

1. Always maintain tenant isolation in queries
2. Use actions for complex business logic
3. Document patterns in PATTERNS.md
4. Add troubleshooting entries for known issues
5. Keep migrations atomic and reversible

For detailed development guidance, see [Contributing Guide](../../docs/wiki/how-to/contributing.md).


---

## Contenuto assorbito da `INDEX.md`

# Documentation Index

Modulo: Tenant

## File disponibili

<!-- auto-generato: elencare i file .md presenti -->
=======
# Indice della Documentazione - Modulo Tenant

=======
# Indice della Documentazione - Modulo Tenant

>>>>>>> .merge_file_LdSJvd
## Panoramica
Questo documento serve come indice centrale per il modulo Tenant, fornendo una guida per la gestione del multi-tenancy all'interno di un'applicazione Laravel. Il modulo Tenant gestisce la creazione, configurazione e isolamento di tenant multipli con supporto per database separati e isolamento dei dati.

## Principi Chiave
1. **Modularità**: Il modulo Tenant è progettato per essere riutilizzabile in diversi progetti, mantenendo funzionalità generiche
2. **Estensibilità**: Consente personalizzazione e aggiunta di nuove funzionalità di multi-tenancy senza alterare il codice principale
3. **Affidabilità**: Garantisce l'isolamento sicuro dei dati tra tenant attraverso gestione robusta degli errori e logging

## Funzionalità Principali
- **Gestione Tenant**: Creazione, aggiornamento e eliminazione di profili tenant
- **Isolamento Dati**: Isolamento completo dei dati tra tenant diversi
- **Database Separati**: Supporto per database separati per ogni tenant
- **Routing per Tenant**: Routing dinamico basato sul dominio del tenant
- **Configurazione Dinamica**: Personalizzazione delle impostazioni per ogni tenant
- **Autenticazione per Tenant**: Supporto per autenticazione basata su tenant
- **Controllo Accessi**: Sistema di ruoli e permessi per tenant
- **Migrazioni Automatiche**: Migrazioni automatiche per nuovi tenant

## Collegamenti Correlati
- [Documentazione Generale <nome progetto>](../../../../../docs/readme.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)
- [Standard di Documentazione](../../../../../docs/documentation_standards.md)
- [Modulo Xot](../../xot/docs/readme.md)
- [Modulo Lang](../../lang/docs/readme.md)
- [Modulo UI](../../ui/docs/readme.md)

## Categorie Principali

### Architettura e Struttura
- [README](./readme.md) - Panoramica generale del modulo
- [Architettura](./architecture/readme.md) - Architettura generale del modulo
- [Struttura](./structure.md) - Struttura delle directory e dei componenti
- [Modelli](./models/readme.md) - Documentazione dei modelli Eloquent
- [Eventi](./events.md) - Eventi e listeners

### Gestione Tenant
- [Funzionalità Core](./core-functionality.md) - Funzionalità principali del modulo
- [Gestione Domini](./domain-management.md) - Sistema di gestione domini
- [Configurazione Tenant](./configuration.md) - Configurazione specifica per tenant
- [Isolamento Dati](./data-isolation.md) - Meccanismi di isolamento dei dati
- [Database Separati](./separate-databases.md) - Gestione di database separati per tenant

### Filament UI
- [Risorse Filament](./filament-resources.md) - Componenti Filament Resources
- [Pagine Filament](./filament-pages.md) - Componenti Filament Pages
- [Form Filament](./forms/readme.md) - Form personalizzati
- [Convenzioni Filament](./filament_extension_pattern.md) - Pattern di estensione per Filament

### API e Integrazione
- [API RESTful](./api.md) - API per la gestione dei tenant
- [Integrazione Servizi Esterni](./external-services.md) - Integrazione con servizi esterni
- [Webhooks](./webhooks.md) - Sistema di webhook per eventi tenant

### Configurazione
- [Struttura Config](./config_structure.md) - Struttura dei file di configurazione
- [Configurazione Multi-Tenant](./multi-tenant-config.md) - Configurazione sistema multi-tenant
- [Principi di Configurazione](./configurations_usage_principles.md) - Principi per l'utilizzo delle configurazioni

### Pattern e Architettura
- [Pattern Factory](./factory_pattern_analysis.md) - Analisi del pattern Factory
- [Risoluzione Dinamica delle Classi](./dynamic_class_resolution.md) - Pattern di risoluzione dinamica delle classi
- [Queueable Actions](./queueable-action.md) - Utilizzo di Spatie Queueable Actions

### Standard e Traduzioni
- [Convenzioni di Naming](./naming_conventions.md) - Standard per i nomi di file e classi
- [Traduzioni](./translations.md) - Sistema di traduzioni
- [Standard Traduzioni](./translation_standards.md) - Standard per le chiavi di traduzione

### Testing e Qualità
- [PHPStan Level 10](./phpstan/index.md) - Correzioni per PHPStan Level 10
- [PHPStan Cluster 2026-03-10](./phpstan-cluster.md) - Factory `DatabaseConfig` e modello canonico mancante
- [Testing](./testing.md) - Strategie e approcci per il testing
- [Test Multi-Tenant](./multi-tenant-testing.md) - Test specifici per ambiente multi-tenant

## Linee Guida per l'Implementazione

### 1. Struttura del Modulo
Il modulo Tenant segue una struttura standard con directory per modelli, servizi, provider e componenti Filament per garantire chiarezza e manutenibilità.

### 2. Tipi di Isolamento Supportati
Supporta diversi tipi di isolamento per i tenant:
```php
// Esempio Configurazione Isolamento
return [
    'isolation' => [
        'type' => 'database', // 'database' o 'schema'
        'connection' => 'tenant',
        'prefix' => 'tenant_',
    ],
    'domains' => [
        'enabled' => true,
        'pattern' => '{tenant}.example.com',
    ],
];
```

### 3. Servizi Disponibili
- **TenantService**: Servizio principale per la gestione dei tenant
- **DomainService**: Servizio per la gestione dei domini
- **TenantMigrationService**: Servizio per le migrazioni tenant
- **TenantBackupService**: Servizio per backup e ripristino tenant

### 4. Gestione Errori
Implementare una gestione robusta degli errori per gestire i fallimenti nell'accesso ai tenant o nella creazione di nuovi tenant.

## Problemi Comuni e Soluzioni
- **Errori di Connessione**: Assicurarsi della corretta configurazione delle connessioni database per ogni tenant
- **Errori di Routing**: Verificare la configurazione del routing basato su dominio
- **Problemi di Isolamento**: Controllare le impostazioni di isolamento dati tra tenant
- **Colli di Bottiglia Performance**: Utilizzare il queueing per operazioni pesanti come la creazione di nuovi tenant

## Documentazione e Aggiornamenti
- Documentare qualsiasi implementazione personalizzata o nuove funzionalità di multi-tenancy nella cartella di documentazione pertinente
- Aggiornare questo indice se vengono introdotte nuove funzionalità o modifiche significative al modulo Tenant

## Sottocartelle

### Actions
- [Index](./actions/index.md) - Indice della documentazione sulle azioni

### Architettura
- [Index](./architecture/index.md) - Indice della documentazione sull'architettura

### Console
- [Index](./console/index.md) - Indice della documentazione sui comandi console

### Enums
- [Index](./enums/index.md) - Indice della documentazione sugli enum

### Filament
- [Index](./filament/index.md) - Indice della documentazione sui componenti Filament

### Modelli
- [Index](./models/index.md) - Indice della documentazione sui modelli

### PHPStan
- [Index](./phpstan/index.md) - Indice della documentazione PHPStan

### Servizi
- [Index](./services/index.md) - Indice della documentazione sui servizi

### Traits
- [Index](./traits/index.md) - Indice della documentazione sui traits

## Collegamenti alla Documentazione Correlata
- [Panoramica Architettura](./architecture.md)
- [Funzionalità Core](./core-functionality.md)
- [Gestione Domini](./domain-management.md)
- [Isolamento Dati](./data-isolation.md)
- [Troubleshooting](./troubleshooting.md)

## Note sulla Manutenzione
Questa documentazione viene aggiornata regolarmente. Prima di apportare modifiche al codice, consultare la documentazione pertinente e aggiornare i documenti correlati.

## Risoluzione Conflitti e Standard
- **Gennaio 2025**: Risoluzione sistematica di tutti i conflitti Git nei file di documentazione
- Il file `lang/it/tenant_theme.php` è stato risolto manualmente mantenendo PSR-12, strict_types, array short syntax e solo chiavi effettive, come richiesto dagli standard PHPStan livello 10
- **Filosofia di risoluzione**: Approccio olistico con analisi manuale approfondita, mantenimento integrità architetturale, documentazione bidirezionale aggiornata
- Vedi anche: [../../../../../docs/README.md](../../../../../docs/readme.md)
- Per dettagli sulle scelte architetturali e funzionali, consultare la doc globale e la sezione "Standard e Traduzioni".

*Ultimo aggiornamento: Gennaio 2025*

- [Conflict Resolution](conflict-resolution.md)
<<<<<<< .merge_file_mJQSMi
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_LdSJvd
