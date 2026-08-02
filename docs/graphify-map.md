# Tenant Module — Mappa Graphify

**Versione:** 1.0.0 | **Modulo:** Tenant | **Data:** 2026-08-02

---

## 📌 Cosa fa il modulo Tenant

Il modulo **Tenant** gestisce:
- Multi-tenancy, isolamento configurazioni, domini e moduli abilitati per ciascun ente

---

## 🏗️ Architettura Essenziale

### Entry Points

| Tipo | Classe | Path |
|------|--------|------|
| **Model** | `Tenant` | `app/Models/Tenant.php` |
| **Model** | `TenantSubscription` | `app/Models/TenantSubscription.php` |
| **Model** | `ResolveTenantModelInstanceAction` | `app/Models/ResolveTenantModelInstanceAction.php` |
| **Action** | `GetTenantNameAction` | `app/Actions/GetTenantNameAction.php` |
| **Action** | `GetTenantModulesAction` | `app/Actions/GetTenantModulesAction.php` |
| **Action** | `GetLocalizedMarkdownPathAction` | `app/Actions/GetLocalizedMarkdownPathAction.php` |
| **Action** | `ResolveTenantConfigValueAction` | `app/Actions/ResolveTenantConfigValueAction.php` |
| **Service** | `TenantService` | `app/Services/TenantService.php` |
| **Service** | `ConfigResolverRegistry` | `app/Services/ConfigResolverRegistry.php` |
| **Filament** | `DomainResource` | `app/Filament/DomainResource.php` |
| **Filament** | `DomainsTable` | `app/Filament/DomainsTable.php` |
| **Filament** | `ListDomains` | `app/Filament/ListDomains.php` |

### Dependencies (Incoming)

```
Core Framework → Tenant (risoluzione contesto richiesta)
```

### Dependencies (Outgoing)

```
Tenant → Database (connessione dinamica tenant)
```

---

## 📊 Grafo Locale (Query Rapide)

### Scoprire Entità Core

```bash
graphify query "Tenant module models and actions"
```

### Tracciare Flussi

```bash
graphify path --from "Tenant" --to "GetTenantNameAction"
```

### Trovare Dipendenze

```bash
graphify query "Tenant dependencies"
```

---

## 🎯 Task Comuni + Graphify

### Task 1: Estendere o Modificare Architettura Tenant

**Domanda Graphify:**
```bash
graphify query "Tenant module architecture and entry points"
```

**Workflow:**
1. Ispeziona classi in `app/Models` o `app/Actions`
2. Esegui query `graphify query "Tenant dependencies"` per verificare impatto
3. Esegui test del modulo

---

## 📋 Test Coverage Map

```bash
graphify query "Tenant module test coverage"
```

---

## 🚀 Comandi Rapidi

```bash
# Esplora architettura
graphify query "Tenant module architecture"

# Test coverage
graphify query "Tenant test coverage"

# Complexity
graphify query "Tenant high complexity"
```

---

## 📚 Riferimenti

- **Graphify Central:** `docs/graphify-integration.md`
- **Module Discipline:** `docs/wiki/rules/module-naming-discipline.md`

---

**Responsabile:** @marco76tv | **Last updated:** 2026-08-02
