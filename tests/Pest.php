<?php

declare(strict_types=1);

use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Webmozart\Assert\Assert;

/*
 * Binding del TestCase per cartella, una volta sola.
 *
 * ## Perche' qui e non in testa a ogni file
 *
 * Senza binding le closure di `test()`/`it()`/`beforeEach()` restano legate a
 * `PHPUnit\Framework\TestCase`, cioe' a un caso di test **senza applicazione
 * Laravel**: `app()`, `config()` e le facade non si risolvono. Era la causa di
 * 53 fallimenti «Target class [config] does not exist» nei file che non lo
 * dichiaravano per conto proprio.
 *
 * ## La condizione da non violare mai
 *
 * Il legame per cartella e quello per file **non possono coesistere**: Pest 4
 * li rifiuta con
 *
 *     Pest\Exceptions\TestCaseAlreadyInUse — The test case [...] may not be
 *     used here. The folder [...] is already bound to the test case [...]
 *
 * e l'errore arriva in **fase di raccolta**, quindi non parte nemmeno un test
 * banale: la suite intera muore con exit 1 e nessun messaggio utile. E'
 * successo nel modulo Quaeris il 2026-11-18.
 *
 * Quindi: con questa riga attiva, **nessun file di questa cartella deve
 * dichiarare `uses(TestCase::class)`**. Verificato il 2026-11-19: nessuno dei
 * 45 lo fa. Se ne aggiungi uno, togli il suo `uses()`, oppure togli questa
 * riga e mettilo in tutti e 45 — non le due cose insieme.
 *
 * @see Modules/Tenant/docs/testing.md#binding-del-testcase
 */
uses(TestCase::class)->in(__DIR__);

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | When you're writing tests, you often need to check that values meet certain conditions. The
 * | "expect()" function gives you access to a set of "expectations" methods that you can use
 * | to assert different things. Of course, you may extend the Expectation API at any time.
 * |
 */

// NOTE: The 'toBeTenant' expectation was removed as it was not used elsewhere
// and caused PHPStan errors related to '$this' binding.

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | While Pest is very powerful out-of-the-box, you may have some testing code specific to your
 * | project that you don't want to repeat in every file. Here you can also expose helpers as
 * | global functions to help you to reduce the number of lines of code in your test files.
 * |
 */

/**
 * @param  array<string, mixed>  $attributes
 */
function createTenant(array $attributes = []): Tenant
{
    /** @var Tenant $tenant */
    $tenant = Tenant::factory()->create($attributes);
    Assert::isInstanceOf($tenant, Tenant::class); // Added for PHPStan

    return $tenant;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function makeTenant(array $attributes = []): Tenant
{
    /** @var Tenant $tenant */
    $tenant = Tenant::factory()->make($attributes);
    Assert::isInstanceOf($tenant, Tenant::class); // Added for PHPStan

    return $tenant;
}

// Removed TenantUser functions as the model doesn't exist in this module
