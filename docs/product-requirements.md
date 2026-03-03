# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Core Team |
| **Module** | Tenant |
| **Repository** | laraxot/module_tenant_fila3 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Tenant implementa l'architettura **multi-tenant** per l'ecosistema Laraxot. Permette a una singola istanza dell'applicazione di servire organizzazioni multiple con **isolamento dati completo**.

### Visione
Fornire un sistema di multi-tenancy trasparente che:
- Isola i dati tra tenant automaticamente
- Semplifica lo sviluppo per contesti multi-tenant
- Non richiede modifiche al codice dei moduli
- Scala_orizzontalmente

### Target Users
- **SaaS Providers**: applicazioni che servono multiple aziende
- **Admin**: gestione tenant
- **Developer**: integrazione tenant-aware

---

## 2. Problema

### Problema Risolto
Le applicazioni multi-tenant richiedono:
1. **Isolamento dati**: Query automaticamente limitate al tenant
2. **Identificazione tenant**: Determinare quale tenant sta operando
3. **Configurazione**: Ogni tenant ha impostazioni diverse
4. **Resource sharing**: Possibilità di condividere dati tra tenant

Senza un modulo dedicato, ogni modulo deve implementare la logica manualmente → errori e inconsistenza.

### Pain Points Attuali
- Query dimenticate che espongono dati di altri tenant
- Difficoltà nel gestire tenant hierarchies
- Configurazione tenant-fragmented
- Testing di scenari multi-tenant complesso

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Amministratore | creare nuovo tenant | dare accesso a nuova organizzazione |
| Utente | vedere solo i miei dati | lavorare nel mio contesto |
| Developer | fare query tenant-aware | non preoccuparmi di filtri |
| Sistema | cambiare tenant utente | impersonare un utente |

---

## 3. Stakeholder

| Ruolo | Responsabilità |
|-------|----------------|
| Product Owner | Feature decisioni |
| Architect | Schema database, caching |
| Developer | Integrazione moduli |

---

## 4. Soluzione Proposta

### Architettura

```
Request
    ↓
Tenant Detection (subdomain, header, user)
    ↓
Tenant Context Set
    ↓
Query Scope Applied (automatic)
    ↓
Response
```

### Strategie Multi-Tenancy

#### 4.1 Tenant by Subdomain
```
tenant1.app.com → tenant_id = 1
tenant2.app.com → tenant_id = 2
```

#### 4.2 Tenant by Header
```
X-Tenant-ID: 1
```

#### 4.3 Tenant by User
```
Utente.logged → tenant_id = user.tenant_id
```

### Funzionalità Core

#### 4.1 Tenant Identification
- [x] Subdomain resolution
- [x] Header-based detection
- [x] User-based fallback
- [x] Custom resolvers

#### 4.2 Tenant Scoping
- [x] Global query scope
- [x] Model trait automatic
- [x] Exclude models (es. settings globali)
- [x] Cross-tenant queries (admin)

#### 4.3 Tenant Management
- [x] CRUD tenant
- [x] Tenant settings
- [x] Domain management
- [x] Tenant switching (super-admin)

#### 4.4 Tenant Isolation
- [x] Database per tenant (opzionale)
- [x] Row-level isolation
- [x] File storage isolation
- [x] Cache per tenant

#### 4.5 Tenant Features
- [x] Feature flags per tenant
- [x] Usage tracking
- [x] Subscription status
- [x] Plan management

### Flussi Utente

#### Flusso: Identificazione Tenant
```
1. Request arriva
2. Sistema verifica subdomain
3. Se non trovato, verifica header X-Tenant-ID
4. Se non trovato, usa tenant dell'utente loggato
5. Imposta Tenant Context
6. Tutte le query automaticamente filtrate
```

---

## 5. Scope

### In Scope
- [x] Identificazione tenant
- [x] Query scoping automatico
- [x] Gestione tenant CRUD
- [x] Isolamento dati
- [x] Feature flags

### Out of Scope
- [ ] Billing/Subscription management
- [ ] White-labeling
- [ ] Multi-region

---

## 6. Metriche di Successo

| KPI | Target |
|-----|--------|
| Data Leakage | 0 occorrenze |
| Query Performance | <+10ms overhead |
| Tenant Switch | <100ms |

---

## 7. Dipendenze

### Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende |
| User | Dipende (tenant association) |

### Esterne
Nessuna dipendenza esterna core. Opzionali:
- Laravel-cashier (billing)
- Spatie-permission (tenant roles)

---

## 8. Appendici

### Glossario
| Termine | Definizione |
|---------|-------------|
| Tenant | Singola organizzazione/azienda |
| Tenant Context | Variabile globale tenant corrente |
| Row-Level Isolation | Filtro automatico per tenant_id |
| Feature Flag | Toggle funzionalità per tenant |

### Schema Database
```
tenants
├── id
├── name
├── slug
├── domain
├── settings (JSON)
├── is_active
├── plan_id
├── created_by
├── activated_at
├── deactivated_at
└── timestamps

tenant_domains
├── id
├── tenant_id
├── domain
├── is_primary
├── is_verified
└── timestamps

tenant_users
├── id
├── tenant_id
├── user_id
├── role
├── is_owner
└── timestamps

tenant_settings
├── id
├── tenant_id
├── key
├── value
└── timestamps
```

---

## 9. Specifiche Tecniche Dettagliate

### 9.1 Tenant Resolution Priority

```
1. Subdomain matching (tenant.app.com)
   └── lookup tenant_domains table
   
2. Custom domain matching (www.client.com)
   └── lookup tenant_domains table
   
3. Header X-Tenant-ID
   └── validate tenant exists and active
   
4. Header X-Tenant-Slug
   └── lookup by slug
   
5. Authenticated user
   └── user.tenant_id
   
6. Default tenant (config)
   └── fallback for public routes
```

### 9.2 Query Scope Implementation

#### Automatic Scope Trait
```php
trait TenantScope
{
    public static function bootTenantScope()
    {
        static::addGlobalScope(new TenantScope);
    }
    
    public function getTenantKey(): ?int
    {
        return TenantManager::getCurrentId();
    }
}
```

#### Exclude from Tenant Scope
```php
// In model
class GlobalSetting extends Model
{
    protected $table = 'settings';
    
    // Override to skip tenant scope
    public function newQuery()
    {
        return parent::newQuery()->withoutGlobalScope(TenantScope::class);
    }
}
```

### 9.3 Tenant Context API

```php
// Get current tenant
$tenant = tenant();

// Get tenant by ID
$tenant = tenant($id);

// Check if tenant is active
if (tenant()->isActive()) {
    // proceed
}

// Switch tenant (super-admin)
tenant()->switch($tenantId);

// Impersonate tenant user
tenant()->impersonate($userId);
```

### 9.4 Cache Strategy

| Tipo Cache | TTL | Invalidation |
|------------|-----|--------------|
| Tenant config | 1 ora | Settings update |
| Tenant users | 15 min | User changes |
| Domain lookup | 24 ore | Domain changes |
| Feature flags | 5 min | Flag changes |

### 9.5 Eventi

| Evento | Descrizione | Listeners |
|--------|-------------|-----------|
| TenantCreated | Nuovo tenant creato | SendWelcomeEmail, SetupDefaultData |
| TenantActivated | Tenant attivato | LogActivity, NotifyOwner |
| TenantDeactivated | Tenant disattivato | LogActivity, RevokeAccess |
| TenantSettingsUpdated | Impostazioni cambiate | ClearCache, LogActivity |
| DomainAdded | Dominio aggiunto | VerifyDomain, SendDNSInstructions |
| DomainRemoved | Dominio rimosso | ClearCache |

### 9.6 Middleware

```php
// In HTTP Kernel
protected $middlewareAliases = [
    'tenant.resolve' => \Tenant\Http\Middleware\ResolveTenant::class,
    'tenant.required' => \Tenant\Http\Middleware\TenantRequired::class,
    'tenant.guest' => \Tenant\Http\Middleware\TenantGuest::class,
];
```

---

## 10. Sicurezza

### 10.1 Data Isolation

- **Row-level**: WHERE tenant_id = X su TUTTE le query
- **File storage**: tenant_{id}/ prefix su paths
- **Cache**: tenant:{id}: prefix
- **Queue**: tenant_id tag su jobs

### 10.2 Super Admin

- Accesso a TUTTI i tenant
- Require super_admin role
- Audit log di TUTTE le azioni
- Two-factor obbligatorio

### 10.3 Cross-Tenant Prevention

- Query scope NON-removable da utenti normali
- middleware verifica tenant_id su POST/PUT/DELETE
- Database constraints (foreign keys)
- Regular penetration testing

---

## 11. Performance

### 11.1 Benchmarks

| Operazione | Target | Maximum |
|------------|--------|---------|
| Tenant resolution | <5ms | 20ms |
| Tenant switch | <50ms | 100ms |
| Query con scope | <+5ms | +10ms |
| Cache hit | <1ms | 5ms |

### 11.2 Ottimizzazioni

- Domain lookup: DNS + DB cache
- Tenant config: Redis cache
- User list per tenant: eager loading
- Bulk operations: chunking

### 11.3 Scaling

- Read replicas per query tenant
- Queue per operazioni bulk tenant
- CDN per asset tenant-specific

---

## 12. Testing

### 12.1 Test Cases

#### Tenant Resolution
- [ ] Subdomain resolution works
- [ ] Custom domain resolution works
- [ ] Header X-Tenant-ID works
- [ ] User fallback works
- [ ] Invalid tenant returns 404
- [ ] Inactive tenant returns 403

#### Query Scoping
- [ ] All queries are scoped
- [ ] WithoutScope works for admin
- [ ] Cross-tenant queries blocked for normal users
- [ ] Relations are properly scoped

#### Tenant Management
- [ ] CRUD operations work
- [ ] Domain management works
- [ ] Settings are persisted
- [ ] User association works

### 12.2 Fixtures

```php
// In tests/TestCase.php
protected function setUp(): void
{
    parent::setUp();
    
    $this->tenant = Tenant::factory()->create();
    $this->user = User::factory()->for($this->tenant)->create();
    
    $this->actingAs($this->user);
}
```

---

## 13. Criteri di Accettazione

- [ ] Tenant può essere creato via API
- [ ] Subdomain routing funziona
- [ ] Query sono automaticamente scoped
- [ ] Super admin può accedere a tutti i dati
- [ ] Tenant isolation funziona (nessun data leak)
- [ ] Performance overhead <10ms
- [ ] Cache invalidation funziona
- [ ] Eventi vengono dispatchati
