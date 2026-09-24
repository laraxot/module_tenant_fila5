---
id: module-tenant-readme
title: "Tenant — Multi-tenancy e Isolamento Organizzativo"
type: module-readme
category: module-documentation
module: Tenant
status: active
tags: [tenant, multitenancy, isolation, organization]
created: 2026-09-14
updated: 2026-09-14
qmd: "tenant multitenancy isolation domains configuration module documentation"
issues:
  - "https://github.com/laraxot/module_tenant_fila5/issues/46"
discussions:
  - "https://github.com/laraxot/module_tenant_fila5/discussions/47"
related:
  - "./docs/"
sources: []
---

# 🏢 Tenant

> **Multi-tenancy e isolamento organizzativo.**
<<<<<<< HEAD
=======

**Module**: `tenant` · **Namespace**: `Modules\Tenant\` · **Status**: ✅ Production
>>>>>>> c5525b6 (chore(Tenant): igiene root: un solo .code-workspace (_module_tenant_fila5), .md in root al massimo 6)

Tenant, domini, configurazione e appartenenza degli utenti.

Il modulo Tenant gestisce la multi-tenancy dell'applicazione in modo completo e robusto. Ogni tenant ha il proprio dominio (o sottodominio), le proprie configurazioni e i propri dati completamente isolati. L'isolamento avviene a livello di connessione database: ogni modulo usa automaticamente la connessione corretta basandosi sul namespace del modello.

## Cosa offre

- **Identificazione** – tenancy ID e ruoli
- **Config organizzativa** – impostazioni per entità, con override della configurazione globale
- **Utenti/tenant** – membership e permessi
<<<<<<< HEAD
- **Isolamento dati**
=======
- **Isolamento dati** – separazione completa per tenant via database/schema/scoping
- **Multi-dominio** – ogni tenant può essere raggiunto da più domini/sottodomini
- **Subscription tracking** – modello di subscription per gestire piani e accesso
- **Filament Admin Panel** – risorse Filament complete per la gestione tenant
- **Risoluzione automatica della connessione** – routing verso la connessione database corretta
>>>>>>> c5525b6 (chore(Tenant): igiene root: un solo .code-workspace (_module_tenant_fila5), .md in root al massimo 6)

## Confini architetturali

This module publishes contracts usable by other modules. Logic lives in `Actions`; admin UI follows Laraxot/XotBase.

<<<<<<< HEAD
=======
### Module Dependencies

- [Xot](../Xot/README.md) (required) — Core framework, abstractions, base models
- [User](../User/README.md) (required) — User management and authentication

>>>>>>> c5525b6 (chore(Tenant): igiene root: un solo .code-workspace (_module_tenant_fila5), .md in root al massimo 6)
## Integrazione rapida

```bash
cd laravel
php artisan module:list
<<<<<<< HEAD
./vendor/bin/phpstan analyse Modules/Tenant
```

See local docs for integration patterns.

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Keep `declare(strict_types=1);` in PHP, respect project PHPStan config, and update docs when contracts evolve.

=======
php artisan migrate   # se servono le migrazioni del modulo
./vendor/bin/phpstan analyse Modules/Tenant
```

```php
use Modules\Tenant\Models\Tenant;

// Get current tenant
$tenant = Tenant::first();

// List all domains for a tenant
$domains = $tenant->domains()->get();

// Access tenant settings
$setting = $tenant->settings['key'] ?? null;
```

See local docs for integration patterns.

### Configurazione

Configuration files:
- `config/config.php` — Module configuration, navigation, routes, providers
- `config/database.php` — Database connection isolation settings
- `config/metatag.php` — Meta tag configuration per tenant

Key settings:
- `routes.middleware` — Middleware stack for tenant routes (default: `['web', 'auth']`)
- `navigation.enabled` — Display in admin navigation (default: `true`)
- `navigation.sort` — Navigation sort order (default: `80`)

---

## Architecture

### Directory Structure

```
Tenant/
├── app/
│   ├── Models/              # 15 models (Tenant, Domain, TenantDomain, etc.)
│   ├── Actions/             # 15 business logic actions
│   ├── Services/            # 7 service classes (Config resolvers, etc.)
│   ├── Contracts/           # 2 interfaces and contracts
│   ├── Traits/              # 4 reusable model traits
│   ├── Filament/            # 7 Filament resources and components
│   ├── Http/
│   │   ├── Controllers/     # Controllers
│   │   ├── Middleware/      # Middleware for tenant routing
│   │   ├── Requests/        # Form requests
│   │   └── Livewire/        # Livewire components
│   ├── Console/Commands/    # 1 Artisan command
│   ├── Providers/           # 4 service providers
│   ├── Enums/               # Enumerations
│   └── View/                # Blade components
├── database/
│   ├── migrations/          # 3 migrations
│   ├── seeders/             # 9 seeders
│   └── factories/           # 8 model factories
├── config/
│   ├── config.php           # Module configuration
│   ├── database.php         # Database connection config
│   └── metatag.php          # Meta tag configuration
├── routes/                  # Route definitions (if any)
├── docs/
│   ├── index.md             # Documentation index
│   ├── README.md            # Technical map
│   ├── architecture.md      # Detailed architecture
│   ├── PATTERNS.md          # Design patterns
│   └── TROUBLESHOOTING.md   # Common issues
└── composer.json
```

### Core Models

- **Tenant** — Root multi-tenant entity with settings, domain, and metadata
- **Domain** — Domain/subdomain associations for tenant routing
- **TenantDomain** — Junction model linking tenant to multiple domains
- **TenantSetting** — Key-value configuration storage per tenant
- **TenantSubscription** — Subscription and plan tracking
- **DatabaseConfig** — Database connection configuration per tenant
- **TestSushiModel** — Testing utilities for Sushi model compatibility

### Key Components

**Actions**: Business logic organized by feature
- `Actions/Config/` — Configuration management
- `Actions/Domains/` — Domain/routing logic
- `Actions/Models/` — Model-level operations
- `Actions/Modules/` — Module integration
- `Actions/Translations/` — Localization support
- `Actions/Markdown/` — Markdown processing

**Services**: System services for isolation and configuration
- Configuration resolvers (per-tenant settings)
- Domain routing services
- Database connection management

**Filament Resources**: Admin panel interface
- DomainResource with custom forms and tables
- Form components for tenant management
- Pages for administration

---

## Usage Examples

### Creating a Tenant

```php
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\Domain;

// Create a new tenant
$tenant = Tenant::create([
    'name' => 'Customer Company',
    'slug' => 'customer-company',
    'domain' => 'customer.example.com',
    'database' => 'customer_db',
    'is_active' => true,
]);

// Add domains
Domain::create([
    'tenant_id' => $tenant->id,
    'domain' => 'customer.example.com',
    'is_primary' => true,
]);
```

### Accessing Tenant Data

```php
use Modules\Tenant\Models\Tenant;

// Query is automatically scoped to current tenant
$tenant = Tenant::currentTenant();

// Access related domains
$domains = $tenant->domains()->get();

// Get settings
$theme = $tenant->settings['theme'] ?? 'default';
```

### Setting Tenant Configuration

```php
$tenant = Tenant::find($id);
$tenant->settings = [
    'theme' => 'dark',
    'locale' => 'it',
    'timezone' => 'Europe/Rome',
];
$tenant->save();
```

---

## Testing

### Running Tests

```bash
# Run all module tests
php artisan test Modules/Tenant

# Run specific test class
php artisan test Modules/Tenant/Tests/Feature/TenantTest

# Run with coverage
php artisan test --coverage Modules/Tenant
```

### Test Factories

```php
use Modules\Tenant\Database\Factories\TenantFactory;

// Create test tenant
$tenant = TenantFactory::new()->create();

// Create with specific attributes
$tenant = TenantFactory::new()
    ->state(['name' => 'Test Tenant'])
    ->create();
```

---

## Documentazione

The technical map is in [docs/README.md](./docs/README.md).

- [Indice documentazione](./docs/index.md)
- [Architecture](./docs/architecture.md) — design principles
- [API Reference](./docs/API.md) — model signatures, methods, service interfaces
- [Patterns](./docs/PATTERNS.md) — tenant isolation, database strategy selection, middleware scoping, query scoping, context switching
- [Troubleshooting](./docs/TROUBLESHOOTING.md) — isolation failures, context leaks, routing errors, database connection errors, permission issues, sync problems
- [Story BMAD del modulo](./docs/stories/)
- [Regole del progetto](../../../docs/wiki/)
- [README del progetto](../../README.md)

## Qualità e manutenzione

Keep `declare(strict_types=1);` in PHP, respect project PHPStan config, and update docs when contracts evolve.

Per contribuire: leggi [Architecture](./docs/architecture.md), segui [Patterns](./docs/PATTERNS.md), aggiungi voci di troubleshooting per i problemi noti, tieni presenti i vincoli di isolamento e documenta la logica di business complessa.

>>>>>>> c5525b6 (chore(Tenant): igiene root: un solo .code-workspace (_module_tenant_fila5), .md in root al massimo 6)
---

**Modulo** `tenant` · **Laraxot ecosystem** · **Project-agnostic**
