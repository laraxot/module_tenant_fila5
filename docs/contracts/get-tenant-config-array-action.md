---
title: "Contratto — GetTenantConfigArrayAction"
type: contract
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigArrayAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetTenantConfigArrayAction

Sorgente: `app/Actions/Config/GetTenantConfigArrayAction.php`.

## Input

- `string $name`: nome del file senza estensione; il percorso passa da `GetTenantFilePathAction`.

## Output

- `array<string, mixed>`: contenuto del file, con le chiavi intere convertite in stringa.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-CFG-ARR-INV-1 | File mancante, errore di esecuzione o valore non array producono `[]` senza errore (`catch Throwable` attorno a `File::getRequire`). | — (non dimostrato) |
| TENANT-CFG-ARR-INV-2 | Le chiavi intere diventano stringhe. | — (non dimostrato) |
| TENANT-CFG-ARR-INV-3 | Un nome con traversal o assoluto lancia `InvalidArgumentException` e non viene inghiottito: `GetTenantFilePathAction` è chiamata fuori dal `try`. | — (non dimostrato) |
## Effetti collaterali

- Legge il file con `File::getRequire`, quindi esegue il PHP del file di config. Nessuna scrittura, evento o cache.

## Errori

- `InvalidArgumentException` dal percorso (INV-3): propagata.
- Limite noto: qualunque `Throwable` durante la lettura è inghiottito e diventa `[]`: il chiamante non distingue «file assente» da «file rotto».

## Non fa

- Non fonde con la configurazione Laravel caricata e non usa cache.
