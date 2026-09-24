<<<<<<< .merge_file_pBLOZU
<<<<<<< HEAD
---
title: Tenant Module Configuration Reference
module: Tenant
type: reference
tags: [config, settings, customization]
last_updated: 2026-08-04
---
=======
# Tenant Configuration (source of truth)
>>>>>>> .merge_file_M4sqkJ

 ## Scopo

 Questo documento descrive la risoluzione **tenant-aware** dei valori di configurazione tramite `TenantService::config()` e l'action `ResolveTenantConfigValueAction`.

 ## Regola d'uso

 - Usare `TenantService::config('app.name')` quando il valore può variare per tenant.
 - Evitare `config('app.name')` nel business code quando si richiede tenant-awareness.

 ## Strategia di merge

 Per una chiave `group.index` (es. `app.name`):

 1. leggere la configurazione base `config('app')`
 2. risolvere il tenant corrente con `GetTenantNameAction`
 3. leggere gli override tenant-specific `config("{tenant}.app")` dove `{tenant}` è convertito in prefisso con `str_replace('/', '.', $tenantName)`
 4. fare merge in modo che gli override vincano sulla base
 5. restituire il valore risolto (con supporto a default)

 ## Decision record (litigata): `runningInConsole()` e mutazioni globali

 ### Posizione A (perdente): bypass in console

 "Se siamo in console, usiamo direttamente `config($key, $default)` e saltiamo la logica tenant-aware."

 **Perché sembra sensato**:

 - in console spesso manca `$_SERVER['SERVER_NAME']`
 - si vuole evitare I/O e lookup tenant

 **Perché perde**:

 - nel nostro codice la console **non** significa assenza di tenant: `GetTenantNameAction` ha fallback su `config('app.url')`
 - queue worker, scheduler e composer scripts possono richiedere config tenant-aware (es. `morph_map.*`)
 - bypassare crea incoerenza tra ambienti e rompe bootstrap e risoluzioni dinamiche

 ### Posizione B (vincente): tenant risolvibile ≠ web, console ≠ no-tenant

 "Il criterio non è console vs web, ma la capacità di risolvere il tenant (con fallback) e di applicare override in modo deterministico."

 **Perché vince**:

 - mantiene coerenza tra HTTP, queue, scheduler, package discovery
 - rispetta la filosofia del modulo: tenant-awareness esplicita e ripetibile

 ### Ulteriore decisione: evitare `Config::set()`

 La risoluzione deve evitare mutazioni globali (`Config::set('app', ...)`) perché nei processi long-lived (queue) il config rimarrebbe contaminato tra esecuzioni.

 ## Note operative

<<<<<<< .merge_file_pBLOZU
### Strategy Selection

Choose isolation strategy for your deployment:

```php
return [
    'strategy' => env('TENANT_DB_STRATEGY', 'separate'),
    // Options: 'separate', 'schema', 'row-level', 'hybrid'
];
```

#### Strategy Details

| Strategy | Setup | Isolation | Scalability | Complexity |
|----------|-------|-----------|-------------|-----------|
| **separate** | Each tenant = new database | Strongest | Best (scale ∞) | Medium |
| **schema** | Multiple schemas in 1 DB | Good | Limited (~50) | Low |
| **row-level** | Shared DB + middleware scoping | Good | Limited | High |
| **hybrid** | Schema + row-level fallback | Very Good | Medium | Very High |

### Connection Management

```php
'connections' => [
    'default' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', 3306),
        'database' => 'master_db',
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
],
```

### Per-Tenant Overrides

Each tenant can override host/port/database:

```php
'tenant_overrides' => [
    'allowed_keys' => ['host', 'port', 'database', 'username'],
    'fallback_to_default' => true, // Use default if override missing
],
```

**Example**: Tenant table can have `DatabaseConfig` with custom host:

```php
// DatabaseConfig model
$config = DatabaseConfig::where('tenant_id', $id)->first();
// Returns:
// {
//   'host' => 'tenant-host.com',
//   'database' => 'tenant_db_2024'
// }
```

### Connection Caching

```php
'cache' => [
    'enabled' => true,
    'ttl' => 3600,  // 1 hour (seconds)
    'driver' => 'redis', // 'file', 'redis', 'memcached'
],
```

**Important**: Invalidate cache after tenant config update:
```php
ConfigurationResolver::clearCache();
```

---

## config/metatag.php

Per-tenant meta tag and SEO configuration.

### Meta Tag Defaults

```php
return [
    'defaults' => [
        'og:type' => 'website',
        'og:site_name' => env('APP_NAME'),
        'twitter:card' => 'summary_large_image',
    ],
];
```

### Per-Tenant Overrides

Each tenant can customize meta tags:

```php
$tenant->settings = [
    'metatag:og:image' => 'https://tenant.example.com/og.jpg',
    'metatag:twitter:creator' => '@tenant_account',
    'metatag:description' => 'Tenant custom description',
];
```

Resolved at runtime:
```php
$og_image = TenantService::setting('metatag:og:image') 
    ?? config('metatag.defaults.og:image');
```

---

## Environment Variables

### Core Configuration

```bash
# Database Strategy
TENANT_DB_STRATEGY=separate          # 'separate', 'schema', 'row-level'

# Multi-Domain
TENANT_MULTI_DOMAIN_ENABLED=true
TENANT_DOMAIN_ROUTING_ENABLED=true

# Features
TENANT_SUBSCRIPTIONS_ENABLED=true
TENANT_AUDIT_TRAIL_ENABLED=true

# Caching
TENANT_CACHE_ENABLED=true
TENANT_CACHE_TTL=3600
```

### Database Credentials (Per-Tenant)

For separate DB strategy, create environment vars per tenant:

```bash
# Tenant A
TENANT_A_DB_HOST=tenant-a.db.com
TENANT_A_DB_NAME=tenant_a_prod
TENANT_A_DB_USER=tenant_a
TENANT_A_DB_PASS=secret_a

# Tenant B
TENANT_B_DB_HOST=tenant-b.db.com
TENANT_B_DB_NAME=tenant_b_prod
TENANT_B_DB_USER=tenant_b
TENANT_B_DB_PASS=secret_b
```

Or use `DatabaseConfig` model (preferred):

```php
DatabaseConfig::create([
    'tenant_id' => 1,
    'host' => 'tenant-a.db.com',
    'database' => 'tenant_a_prod',
    'username' => 'tenant_a',
    'password' => encrypted('secret_a'), // Encrypted at rest
]);
```

---

## Runtime Configuration

### Getting Settings

```php
use Modules\Tenant\Services\ConfigurationResolver;

// Current tenant setting with fallback
$theme = ConfigurationResolver::get('theme', 'default');

// Direct model access
$setting = Tenant::current()->settings['key'] ?? null;

// From config file
$feature = config('tenant.features.subscriptions');
```

### Setting Values

```php
// Update per-tenant setting
$tenant = Tenant::find(1);
$tenant->settings = array_merge(
    $tenant->settings ?? [],
    ['theme' => 'dark', 'locale' => 'it']
);
$tenant->save();

// Clear cache after update
ConfigurationResolver::clearCache();
```

### Using in Blade

```blade
<!-- Meta tags -->
<meta property="og:image" content="{{ config('tenant.metatag.og_image') }}">

<!-- Conditionals -->
@if(config('tenant.features.subscriptions'))
    <!-- Show subscription UI -->
@endif

<!-- Loops -->
@foreach(config('tenant.navigation') as $item)
    <!-- Render nav item -->
@endforeach
```

### Using in PHP

```php
// Conditional features
if (config('tenant.features.domain_routing')) {
    // Enable domain-based routing
}

// Service configuration
$resolver = resolve(ConfigurationResolver::class);
$db_config = $resolver->getConnection(Tenant::current());

// Tenant context
$tenant = app('tenant')->current();
$locale = $tenant->settings['locale'] ?? 'en';
```

---

## Customization Patterns

### Override Module Config

Create `config/tenant.php` in root Laravel app:

```php
// config/tenant.php
return [
    'routes' => [
        'prefix' => 'admin/tenants',
    ],
    'features' => [
        'subscriptions' => false, // Disable subscriptions
    ],
];
```

Laravel automatically merges with module config.

### Add Custom Settings

Define new settings in tenant model:

```php
// Create migration
Schema::table('tenants', function (Blueprint $table) {
    $table->json('metadata')->nullable();
});

// In Tenant model
protected $casts = [
    'metadata' => 'array',
];

// Use
$tenant->metadata['custom_key'] = 'value';
$tenant->save();
```

### Cache Custom Config

For frequently-accessed settings, cache them:

```php
$setting = Cache::remember(
    "tenant.{$tenantId}.setting_key",
    3600, // TTL
    fn() => Tenant::find($tenantId)->settings['setting_key']
);
```

Invalidate on update:
```php
Cache::forget("tenant.{$tenantId}.setting_key");
ConfigurationResolver::clearCache(); // Clear all tenant caches
```

---

## Best Practices

1. **Use Environment Variables for Deployment**: Don't hardcode database credentials
2. **Cache Tenant Settings**: Settings fetches are frequent; use Redis/Memcached
3. **Validate Configuration**: Run migrations/seeders before going live
4. **Document Tenant-Specific Setup**: Keep playbook for onboarding new tenants
5. **Audit Configuration Changes**: Log all updates via audit trail
6. **Test Isolation**: Verify other tenants can't access overridden settings

---

## Related Documentation

- [Architecture Reference](architecture.md)
- [Module README](../README.md)
- [Testing Guide](../tests/Feature/README.md)
=======
# Tenant Configuration (source of truth)

 ## Scopo

 Questo documento descrive la risoluzione **tenant-aware** dei valori di configurazione tramite `TenantService::config()` e l'action `ResolveTenantConfigValueAction`.

 ## Regola d'uso

 - Usare `TenantService::config('app.name')` quando il valore può variare per tenant.
 - Evitare `config('app.name')` nel business code quando si richiede tenant-awareness.

 ## Strategia di merge

 Per una chiave `group.index` (es. `app.name`):

 1. leggere la configurazione base `config('app')`
 2. risolvere il tenant corrente con `GetTenantNameAction`
 3. leggere gli override tenant-specific `config("{tenant}.app")` dove `{tenant}` è convertito in prefisso con `str_replace('/', '.', $tenantName)`
 4. fare merge in modo che gli override vincano sulla base
 5. restituire il valore risolto (con supporto a default)

 ## Decision record (litigata): `runningInConsole()` e mutazioni globali

 ### Posizione A (perdente): bypass in console

 "Se siamo in console, usiamo direttamente `config($key, $default)` e saltiamo la logica tenant-aware."

 **Perché sembra sensato**:

 - in console spesso manca `$_SERVER['SERVER_NAME']`
 - si vuole evitare I/O e lookup tenant

 **Perché perde**:

 - nel nostro codice la console **non** significa assenza di tenant: `GetTenantNameAction` ha fallback su `config('app.url')`
 - queue worker, scheduler e composer scripts possono richiedere config tenant-aware (es. `morph_map.*`)
 - bypassare crea incoerenza tra ambienti e rompe bootstrap e risoluzioni dinamiche

 ### Posizione B (vincente): tenant risolvibile ≠ web, console ≠ no-tenant

 "Il criterio non è console vs web, ma la capacità di risolvere il tenant (con fallback) e di applicare override in modo deterministico."

 **Perché vince**:

 - mantiene coerenza tra HTTP, queue, scheduler, package discovery
 - rispetta la filosofia del modulo: tenant-awareness esplicita e ripetibile

 ### Ulteriore decisione: evitare `Config::set()`

 La risoluzione deve evitare mutazioni globali (`Config::set('app', ...)`) perché nei processi long-lived (queue) il config rimarrebbe contaminato tra esecuzioni.

 ## Note operative

 - Se un valore non esiste e viene passato un default, il default viene restituito senza side effects.
 - Gli override tenant-specific devono essere espressi nei file di configurazione del tenant.
>>>>>>> 1ad0554 (.)
=======
 - Se un valore non esiste e viene passato un default, il default viene restituito senza side effects.
 - Gli override tenant-specific devono essere espressi nei file di configurazione del tenant.
>>>>>>> .merge_file_M4sqkJ
