---
type: contract
status: proposed
action: <FQCN>
qmd: "template operazione contratto comportamento tenant"
---

# <operazione> — contratto comportamentale

Classe o superficie: `<FQCN>`  
Riferimento nel codice: `@contract docs/contracts/<file>.md`

## Input

- <input e validazione>

## Output

- <risultato osservabile>

## Invarianti

| ID | Regola | Verifica |
|---|---|---|
| `TENANT-<AREA>-INV-1` | <regola che deve restare vera> | <test o controllo ripetibile> |

Gli ID sono stabili: un test Pest li usa come `group` (`--group=TENANT-<AREA>-INV-1`).

## Effetti collaterali

- <scritture, eventi, chiamate esterne o nessuno>

## Errori

- `<eccezione/status>` — <condizione>

## Non fa

- <confine esplicito del contratto>
