---
module: Tenant
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Tenant

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Tenant**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/Policies/TenantBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `active` (13 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/database/Factories/DomainFactory.php`
- `./laravel/Modules/Tenant/database/Factories/TenantFactory.php`
- `./laravel/Modules/Tenant/database/Factories/TestSushiModelFactory.php`
- `./laravel/Modules/Tenant/database/factories/DomainFactory.php`
- `./laravel/Modules/Tenant/database/factories/TenantFactory.php`
- `./laravel/Modules/Tenant/database/factories/TestSushiModelFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getRows` (11 occorrenze)

**Moduli coinvolti:** Lang, Setting, Sigma, Tenant, User, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/Domain.php`
- `./laravel/Modules/Tenant/app/Models/TenantDomain.php`
- `./laravel/Modules/Tenant/app/Models/TestSushiModel.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `inactive` (9 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/database/Factories/TenantFactory.php`
- `./laravel/Modules/Tenant/database/Factories/TestSushiModelFactory.php`
- `./laravel/Modules/Tenant/database/factories/TenantFactory.php`
- `./laravel/Modules/Tenant/database/factories/TestSushiModelFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `trans` (8 occorrenze)

**Moduli coinvolti:** Lang, Media, Tenant, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/TenantService.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `users` (7 occorrenze)

**Moduli coinvolti:** Tenant, User

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/Tenant.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `pending` (5 occorrenze)

**Moduli coinvolti:** DbForge, Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/database/Factories/TestSushiModelFactory.php`
- `./laravel/Modules/Tenant/database/factories/TestSushiModelFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `isActive` (5 occorrenze)

**Moduli coinvolti:** Sigma, Tenant, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/Tenant.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getJsonFile` (5 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonContract.php`
- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonsContract.php`
- `./laravel/Modules/Tenant/app/Models/TestSushiModel.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConnectionName` (5 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Tenant, User, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `resolve` (4 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/Config/Contracts/ConfigResolverInterface.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/DatabaseConfigResolver.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getSushiRows` (4 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/Traits/SushiToCsv.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToPhpArray.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConfig` (4 occorrenze)

**Moduli coinvolti:** Notify, Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/TenantService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `canResolve` (4 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/Config/Contracts/ConfigResolverInterface.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/DatabaseConfigResolver.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `tenant` (3 occorrenze)

**Moduli coinvolti:** Tenant, User

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Models/TenantSetting.php`
- `./laravel/Modules/Tenant/app/Models/TenantSubscription.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `highPriority` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/database/Factories/TestSushiModelFactory.php`
- `./laravel/Modules/Tenant/database/factories/TestSushiModelFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getName` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/TenantService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `ensureDirectoryExists` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonContract.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `authId` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonContract.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `sslEnabled` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/database/Factories/DomainFactory.php`
- `./laravel/Modules/Tenant/database/factories/DomainFactory.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `saveToJson` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonContract.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `primary` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/database/Factories/DomainFactory.php`
- `./laravel/Modules/Tenant/database/factories/DomainFactory.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `model` (2 occorrenze)

**Moduli coinvolti:** Rating, Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/TenantService.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `loadExistingData` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonContract.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getTenantConfig` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getOriginalConfig` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php`
- `./laravel/Modules/Tenant/app/Services/Config/Resolvers/StandardConfigResolver.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `findRowIndexById` (2 occorrenze)

**Moduli coinvolti:** Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Contracts/SushiToJsonContract.php`
- `./laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php`

[Riflessione: Duplicato interno al modulo Tenant — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `config` (2 occorrenze)

**Moduli coinvolti:** Pdnd, Tenant

**File in Tenant:**

- `./laravel/Modules/Tenant/app/Services/TenantService.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Tenant

- **Totale metodi duplicati che coinvolgono Tenant:** 28
- **Di cui cross-modulo:** 17
- **Di cui interni al modulo:** 11

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 20 metodi
- **altro:** 8 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 19 metodi in comune
- **User:** 14 metodi in comune
- **DbForge:** 5 metodi in comune
- **Lang:** 4 metodi in comune
- **Setting:** 4 metodi in comune
- **Media:** 3 metodi in comune
- **Sigma:** 3 metodi in comune
- **UI:** 3 metodi in comune
- **Notify:** 3 metodi in comune
- **Performance:** 2 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
