# BMAD + Second Brain — Fix PHPStan (session)

- BMAD: docs in `Modules/<nome>/docs/` (senza date), osservazioni wiki, sprint-status.yaml.
- Second brain: MEMORY.md aggiornato, wiki_retro salvato, wiki_observe registrato.
- Ponytail: solo correzioni minime (signature, generics, fixtures mancanti), nessun re-engineering.
- Ordine: casuale, parallelo quando possibile.
- Git: solo avanti, mai destructive.
- Nessuna conferma richiesta.

# Decision: makeTestSushiModelForPath — path JSON obbligatorio

- Sorgente: `arguments.count` su `SushiToJsonIntegrationTest` — helper chiamata con 0 argomenti, 1 richiesto.
- Scopo business: i test Sushi→JSON verificano l'isolamento path per tenant. Ogni modello deve puntare a un file JSON distinto (`tenantJsonPath('tenant1')` vs `tenant2`, oppure path custom).
- Contratto corretto: `makeTestSushiModelForPath(string $jsonPath): TestSushiModelForPath` — parametro obbligatorio, niente default vuoto.
- Anti-pattern rifiutato: default `= ''` (silenzia PHPStan ma annulla l'isolamento: due modelli condividono path vuoto / comportamento trait).
- Fixture: `TestSushiModelForPath::getJsonFile()` deve restituire `$jsonPath` impostato via `setJsonPath()`, altrimenti `SushiToJson` usa `GetTenantFilePathAction` e il path iniettato è un no-op.
- Call site: passare sempre `tenantJsonPath(...)` o il path custom del test.

## Collegamenti

- [Story fixture](stories/sushitojson-test-fixtures.story.md)
- [Fix integrazione SushiToJson](testing-sushitojson-integration-fix.md)
- [Task isolamento dati](task-test-isolamento-dati.md)
