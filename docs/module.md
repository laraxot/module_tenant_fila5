<<<<<<< HEAD
---
title: "Tenant Module — Doctrine"
type: doctrine
tags: [tenant, multi-tenancy, module-doctrine]
created: 2026-09-05
updated: 2026-09-05
qmd: "Tenant module doctrine BMAD analysis purpose religion philosophy policy why zen gap enhancements split merge"
related:
  - "../../Xot/docs/module.md"
  - "../../Platform/docs/module.md"
---

# Tenant Module — Doctrine

## Scope (Scopo)

Tenant gestisce l'isolamento multi-tenant del monorepo. Ogni tenant ha il proprio database (database isolation), configurazione JSON in `database/content/tenants/`, e feature flags propri. Il middleware tenant è applicato a ogni route che richiede contesto tenant.

## Religion (Religione)

**"Un tenant, un database, una configurazione, invisibile agli altri."** La convinzione non negoziabile è che i dati di un tenant NON devono mai essere accessibili da un altro tenant, nemmeno per errore. L'isolamento è a livello di database, non di `tenant_id` column — quest'ultimo è considerato un anti-pattern per rischio di data leak.

## Philosophy (Filosofia)

- **Database isolation**: ogni tenant ha il proprio database, non una colonna `tenant_id`
- **JSON config in version control**: `database/content/tenants/` con Sushi per dati statici
- **Tenant middleware on every route**: il contesto tenant è sempre presente, mai opzionale
- **Mai hardcoded tenant reference**: tutto passa per il tenant corrente

## Policy (Politica)

- Nessuna tabella condivisa tra tenant (tranne quelle esplicitamente globali)
- Configurazione tenant in JSON, mai in database (Sushi per seed)
- Migrazioni applicate a tutti i tenant, rollback coordinato
- Feature flags per tenant: un tenant può avere feature disabilitate che altri hanno abilitate

## Why (Perché)

Tenant esiste perché il modello multi-tenant richiede isolamento a livello di database per sicurezza e compliance. Usare `tenant_id` columns invece di database isolation espone a data leak catastrofici. Tenant è la garanzia che un cliente non vede mai i dati di un altro cliente.

## Zen

*"Un database, una configurazione, una verità. L'isolamento non è opzione, è legge."*

## Gap

- ARCHITECTURE.md mancante nella root del modulo
- Azioni per il lifecycle del tenant (create, update, delete, migrate, rollback) limitate
- Test suite multi-tenant incompleta
- Nessuno strumento di audit per isolamento tenant

## Add

- Azioni per lifecycle tenant: `CreateTenantAction`, `UpdateTenantConfigAction`, `DeleteTenantAction`, `MigrateTenantAction`, `RollbackTenantAction`
- Test suite multi-tenant con verifica di isolamento
- Tenant isolation audit tool: verifica che nessuna query泄漏 dati di altri tenant
- Dashboard Filament per gestione tenant (crea, configura, migra, elimina)

## Split/Merge

**Mantenere come-is, ma considerare estrazione Config/.** La configurazione tenant (JSON files, Sushi) potrebbe essere estratta in un sotto-modulo `TenantConfig` se cresce, ma l'isolamento database è troppo critico per essere separato dal resto.

## Future Enhancements

1. **Tenant-aware queue**: job che eseguono nel contesto del tenant corretto
2. **Tenant snapshot/restore**: backup e ripristino istantaneo di un tenant
3. **Tenant migration runner**: migrazioni automatiche su nuovi tenant al momento della creazione
4. **Tenant resource quotas**: limiti di storage, DB size, CPU per tenant
5. **Tenant analytics**: dashboard con metriche per tenant (attività, errori, performance)
6. **Tenant template**: configurazioni predefinite per diversi tipi di cliente
=======
# Modulo Tenant - Multi-Tenancy Management

## Scopo Principale

Il modulo **Tenant** fornisce un sistema completo di **multi-tenancy per il monolite Laraxot**, permettendo di gestire multiple istanze dell'applicazione con isolamento completo dei dati, configurazioni e utenti.

## Funzionalità Implementate

### ✅ Core Tenancy System
1. **Tenant Management**
   - Complete CRUD operations per tenant
   - Dynamic database connection per tenant
   - Tenant domain/subdomain routing
   - Tenant configuration management

2. **Data Isolation**
   - Database-per-tenant pattern
   - Schema isolation strategies
   - Tenant-specific data segregation
   - Cross-tenant data protection

3. **Configuration Management**
   - Per-tenant settings storage
   - Dynamic configuration loading
   - Tenant feature toggles
   - Customizable tenant parameters

### ✅ Advanced Features
1. **Tenant Identification**
   - Subdomain-based detection
   - Domain-based routing
   - Header-based identification
   - API key tenant resolution

2. **Resource Management**
   - Per-tenant resource allocation
   - Usage tracking and limits
   - Performance monitoring per tenant
   - Resource billing integration

3. **Migration System**
   - Tenant-specific migrations
   - Schema synchronization
   - Cross-tenant data operations
   - Tenant bootstrap process

## Architettura del Sistema

### Component Architecture
```
Tenant Module Stack:
├── Identification Layer
│   ├── TenantResolver (Subdomain/Domain)
│   ├── TenantMiddleware
│   ├── TenantRouteManager
│   └── ApiTenantDetector
├── Management Layer
│   ├── TenantManager
│   ├── TenantRepository
│   ├── TenantConfigService
│   └── TenantLifecycleService
├── Database Layer
│   ├── TenantDatabaseManager
│   ├── ConnectionManager
│   ├── MigrationManager
│   └── SchemaIsolationService
└── Resource Layer
    ├── ResourceManager
    ├── UsageTracker
    ├── LimitEnforcer
    └── BillingIntegration
```

### Tenant Resolution Flow
```
HTTP Request → TenantResolver → TenantManager → Database Switch → Application
     ↓
Tenant Detection → Configuration Load → Bootstrap → Response
```

## Componenti Principali

### Core Services
- `TenantManager` - Central tenant management
- `TenantResolver` - Tenant identification
- `TenantDatabaseManager` - Database connections
- `TenantConfigService` - Configuration management
- `TenantResourceService` - Resource allocation

### Models & Relationships
- `Tenant` - Tenant entity model
- `TenantDomain` - Domain mappings
- `TenantDatabase` - Database configurations
- `TenantSetting` - Per-tenant settings
- `TenantUsage` - Resource usage tracking

### Database Layer
- `TenantConnectionManager` - Dynamic connections
- `TenantMigrationService` - Migration management
- `SchemaIsolationService` - Data segregation
- `CrossTenantOperationService` - Admin operations

### Middleware & Routing
- `TenantIdentificationMiddleware` - Request tenant detection
- `TenantRouteMiddleware` - Route tenant binding
- `TenantApiMiddleware` - API tenant resolution
- `TenantEnforcementMiddleware` - Access enforcement

## Configurazione e Setup

### Tenant Resolution Strategies
```php
// config/tenant.php
'resolution_strategies' => [
    'subdomain' => SubdomainResolver::class,
    'domain' => DomainResolver::class,
    'header' => HeaderResolver::class,
    'api_key' => ApiKeyResolver::class,
],

'default_strategy' => 'subdomain',
'fallback_strategy' => 'domain',
```

### Database Configuration
```php
// Dynamic tenant database connection
'tenant_database' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT'),
    'database' => '{tenant_database}',
    'username' => '{tenant_username}',
    'password' => '{tenant_password}',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
],
```

## Dipendenze e Integration

### Dependencies Esterne
- Laravel multi-database support
- Dynamic connection management
- Subdomain routing capabilities

### Inter-Modulo Dependencies
- **User**: Tenant-aware user management
- **Activity**: Tenant-isolated activity logging
- **Limesurvey**: Tenant-specific survey data
- **<nome progetto>**: Tenant-scoped reporting
- **Notify**: Tenant notification channels

## Lacune e Funzionalità Mancanti

### 🔴 CRITICHE (Priorità Alta)
1. **Advanced Tenant Management**
   - Missing: Hierarchical tenant structure
   - No tenant templates system
   - Missing tenant cloning capabilities
   - No bulk tenant operations

2. **Resource Management & Billing**
   - Basic resource tracking only
   - Missing advanced billing integration
   - No usage analytics
   - Missing cost optimization

3. **Security & Isolation**
   - Missing advanced isolation verification
   - No cross-tenant intrusion detection
   - Missing tenant-level security policies
   - No audit trail isolation

### 🟡 ALTE (Priorità Media)
1. **Performance Optimization**
   - Missing: Tenant-specific caching strategies
   - No connection pooling management
   - Missing query optimization per tenant
   - No load balancing for tenants

2. **Administrative Features**
   - Limited admin capabilities
   - Missing tenant health monitoring
   - No automated tenant maintenance
   - Missing tenant backup/restore

3. **Developer Experience**
   - No tenant development environment
   - Missing tenant testing utilities
   - No debugging per tenant
   - Missing tenant documentation generator

### 🟢 MEDIE (Priorità Bassa)
1. **Advanced Analytics**
   - No tenant behavior analytics
   - Missing performance comparisons
   - No usage <nome progetto>ions
   - Missing optimization recommendations

2. **Integration Features**
   - No external SSO integration
   - Missing webhook system per tenant
   - No API management per tenant
   - Missing third-party integrations

## Performance e Scaling

### Current Optimizations
✅ Implemented:
- Connection pooling for tenant databases
- Caching of tenant configurations
- Database query optimization
- Lazy loading of tenant data

### Scaling Challenges
❌ Issues:
- Database connection overhead for many tenants
- Memory usage with many configurations
- Complex migration management
- Limited horizontal scaling capabilities

### Raccomandazioni
1. **Connection Pooling**: Advanced connection reuse
2. **Caching Strategy**: Multi-level tenant caching
3. **Database Sharding**: Partition tenants by usage
4. **Load Balancing**: Distribute tenant load

## Security Implementation

### Data Isolation
- Physical database separation
- Tenant-scoped database connections
- Cross-tenant access prevention
- Data encryption at rest

### Access Control
- Tenant-level user isolation
- Admin cross-tenant capabilities
- API key-based tenant access
- Secure tenant switching

### Compliance Features
- Data segregation verification
- Audit trail per tenant
- GDPR compliance per tenant
- Data export/import controls

## Use Cases Comuni

### 1. Tenant Registration
```php
// New tenant setup
$tenant = TenantService::create([
    'name' => $request->name,
    'domain' => $request->domain,
    'database' => $request->database_config,
]);

TenantDatabaseService::createDatabase($tenant);
TenantMigrationService::runMigrations($tenant);
TenantConfigService::initializeSettings($tenant);
```

### 2. Request Resolution
```php
// Automatic tenant detection
$tenant = TenantResolver::resolve($request);
TenantManager::setCurrent($tenant);
TenantDatabaseManager::switchTo($tenant);
```

### 3. Cross-Tenant Operations
```php
// Admin operations across tenants
$reports = CrossTenantService::aggregateData([
    'tenants' => $selectedTenants,
    'metrics' => ['user_count', 'survey_count'],
    'period' => 'last_30_days',
]);
```

## Roadmap Sviluppo

### Fase 1: Core Enhancement (2-3 settimane)
- [ ] Hierarchical tenant structure
- [ ] Tenant templates system
- [ ] Advanced billing integration
- [ ] Resource optimization

### Fase 2: Performance & Scaling (3-4 settimane)
- [ ] Advanced caching strategies
- [ ] Connection pooling improvements
- [ ] Query optimization per tenant
- [ ] Load balancing capabilities

### Fase 3: Security & Compliance (2-3 settimane)
- [ ] Advanced isolation verification
- [ ] Cross-tenant intrusion detection
- [ ] Tenant security policies
- [ ] Enhanced audit trails

### Fase 4: Developer Experience (3-4 settimane)
- [ ] Tenant development environment
- [ ] Testing utilities
- [ ] Debugging tools
- [ ] Documentation automation

## Best Practices

### Development Guidelines
1. **Tenant Isolation**: Always use tenant context
2. **Resource Efficiency**: Minimize resource usage
3. **Security First**: Never expose cross-tenant data
4. **Scalability**: Design for many tenants

### Operational Guidelines
1. **Regular Monitoring**: Track tenant performance
2. **Resource Planning**: Plan capacity needs
3. **Backup Strategy**: Regular tenant backups
4. **Compliance Reviews**: Regular isolation verification

### Security Guidelines
1. **Data Segregation**: Strict tenant separation
2. **Access Control**: Minimal cross-tenant access
3. **Audit Trails**: Complete operation logging
4. **Encryption**: Protect tenant data

## Collegamenti Documentation

### Internal Links
- `../User/docs/MODULE_ANALYSIS.md` - Tenant-aware users
- `../Activity/docs/MODULE_ANALYSIS.md` - Isolated activity logging
- `../Limesurvey/docs/MODULE_ANALYSIS.md` - Tenant survey data
- `./tenant-management-guide.md` - Operational procedures

### External References
- [Laravel Multi-Tenancy](https://laravel.com/docs/multi-tenancy)
- [Database Design Patterns](https://aka.ms/vs-code-extensions/database-design-patterns)

---

**Versione**: v2.2.0-beta  
**Stato**: Production Ready with Enterprise Scaling
>>>>>>> 1ad0554 (.)
