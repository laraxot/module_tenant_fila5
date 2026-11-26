---
title: "Contratto — GetEnteDataAction"
type: contract
action: "Modules\\Tenant\\Actions\\Ente\\GetEnteDataAction"
module: Tenant
status: accepted
created: 2026-11-24
updated: 2026-11-26
---

# GetEnteDataAction

Dati dell'ente (nome, indirizzo, contatti, DPO, social) per header, footer e pagine legali di Sixteen
(`Themes/Sixteen/resources/views/components/sections/footer/v1.blade.php`, `.../blocks/partials/dc-contacts.blade.php`).
I valori finiscono in `href` `tel:`/`mailto:`/link esterni: la validazione qui evita link malformati e URL pericolosi. Sorgente: `app/Actions/Ente/GetEnteDataAction.php`.

## Input

- `?string $locale`: lingua per i testi; se assente la lingua corrente dell'app.

## Output

- `EnteData`: testi, `pec`, `email`, `dpo_email`, `phone`, `toll_free`, `region_url` e `social` (lista di `{network, label, url, icon}`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-ENTE-INV-1 | Un valore mancante o non valido vale stringa vuota, mai un segnaposto. Se cade, il footer mostra contatti inventati. | `TENANT-ENTE-INV-1` |
| TENANT-ENTE-INV-2 | Per i testi per lingua vale: lingua richiesta, poi `app.fallback_locale`, poi il primo valore stringa (`text()`). | `TENANT-ENTE-INV-2` |
| TENANT-ENTE-INV-3 | Il telefono è valido se, tolti spazi, punti, trattini, parentesi e barre, resta `+?` seguito da 3-15 cifre; il valore restituito è l'originale, non ripulito (`phone()`). | `TENANT-ENTE-INV-3` |
| TENANT-ENTE-INV-4 | Email, PEC e email DPO devono superare una regex ASCII semplice e `FILTER_VALIDATE_EMAIL`: niente `?`, `&`, `%` che in un `mailto:` aggiungerebbero parametri (`email()`). | `TENANT-ENTE-INV-4` |
| TENANT-ENTE-INV-5 | Un URL è valido solo se `http` o `https`, con host, senza spazi, virgolette, `<>`, backslash o caratteri di controllo (`url()`). | `TENANT-ENTE-INV-5` |
| TENANT-ENTE-INV-6 | Un social è incluso solo se la rete è in `SOCIAL_NETWORKS` e l'URL è valido; l'icona è `it-<rete>`; senza etichetta vale il nome di default (`social()`). | `TENANT-ENTE-INV-6` |
## Effetti collaterali

- Nessuno: legge `config('ente')` e la lingua corrente. Nessuna scrittura, cache o chiamata esterna.

## Errori

- Nessuna eccezione propria: `Safe\parse_url` è dentro `try`/`catch Throwable` e ripiega su stringa vuota.

## Non fa

- Non verifica che gli URL siano raggiungibili e non normalizza il telefono nel formato internazionale.
