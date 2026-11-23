<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

// use Modules\Patient\Models\Patient; // Module not available
// use Modules\Dental\Models\Appointment; // Module not available
use Closure;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modello Tenant per la gestione multi-tenant dell'applicazione.
 *
 * @property string $name
 * @property string $domain
 * @property string $database
 * @property string $slug
 * @property array<string, mixed>|null $settings
 * @property bool $is_active
 * @property string|null $logo
 * @property \Carbon\Carbon|null $last_activity_at
 * @property-read string $url
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static TenantFactory factory($count = null, $state = [])
 * @method static Builder<static>|Tenant newModelQuery()
 * @method static Builder<static>|Tenant newQuery()
 * @method static Builder<static>|Tenant query()
 * @method static Tenant|null first()
 * @method static Collection<int, Tenant> get()
 * @method static Tenant create(array<string, mixed> $attributes = [])
 * @method static Tenant firstOrCreate(array<string, mixed> $attributes = [], array<string, mixed> $values = [])
 * @method static Builder<static>|Tenant where((string|Closure) $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static Builder<static>|Tenant whereNotNull((string|Expression) $columns)
 * @method static int count(string $columns = '*')
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static Builder<static>|Tenant whereCreatedAt($value)
 * @method static Builder<static>|Tenant whereDatabase($value)
 * @method static Builder<static>|Tenant whereDeletedAt($value)
 * @method static Builder<static>|Tenant whereDomain($value)
 * @method static Builder<static>|Tenant whereId($value)
 * @method static Builder<static>|Tenant whereIsActive($value)
 * @method static Builder<static>|Tenant whereName($value)
 * @method static Builder<static>|Tenant whereSlug($value)
 * @method static Builder<static>|Tenant whereUpdatedAt($value)
 * @method static Builder<static>|Tenant whereSettings($value)
 *
 * @mixin \Eloquent
 */
class Tenant extends BaseModel
{
    /*
     * La tabella `tenants` e' del modulo User (Modules\User\Models\Tenant) e ha id UUID: senza HasUuids ogni
     * insert da questo modello falliva con "NOT NULL constraint failed: tenants.id".
     */
    use HasUuids;

    /**
     * La tabella `tenants` vive sulla connessione `user`, non su quella del modulo.
     *
     * `BaseModel` di questo modulo dichiara `$connection = 'tenant'`, e per tre delle
     * quattro tabelle del modulo e' giusto — `database_configs`, `tenant_settings` e
     * `tenant_subscriptions` stanno dove quella connessione punta. `tenants` e' l'unica
     * eccezione, perche' la creano le migration di **Modules/User** (ce ne sono tre, piu'
     * un file parcheggiato: base_quaeris_fila5#2) sulla connessione `user`, come il
     * commento sopra gia' dichiarava senza trarne la conseguenza.
     *
     * Senza questa riga ogni lettura finiva su `quaeris_data_test.tenants`, che non
     * esiste:
     *
     *     SQLSTATE[42S02]: Base table or view not found: 1146
     *     Table 'quaeris_data_test.tenants' doesn't exist
     *
     * Erano **42 dei 75 fallimenti** della suite del modulo (base_quaeris_fila5#228).
     *
     * Il nome della connessione e' scritto a mano e non letto da configurazione: e' una
     * scelta, non una dimenticanza. Questo model non e' il tenant di questo progetto —
     * quello e' `Modules\Quaeris\Models\Customer`, come dichiara
     * `XotData::getTenantClass()` — e nessun codice applicativo fuori dal modulo lo usa.
     * Renderlo configurabile aggiungerebbe un punto di variazione per un model che
     * nessuno monta in produzione.
     */
    protected $connection = 'user';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'domain',
        'database',
        'slug',
        'settings',
        'is_active',
        'logo',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'country',
        'tax_code',
        'vat_number',
        'last_activity_at',
    ];

    /**
     * Relazione con gli utenti associati al tenant.
     *
     * @return HasMany<User, $this>
     */
    public function users(): HasMany
    {
        /** @var HasMany<User, $this> $relation */
        $relation = $this->hasMany(User::class);

        return $relation;
    }

    // Commented out - Patient and Dental modules not available
    // /**
    //  * Relazione con i pazienti associati al tenant.
    //  */
    // public function patients(): HasMany
    // {
    //     return $this->hasMany(Patient::class);
    // }

    // /**
    //  * Relazione con gli appuntamenti associati al tenant.
    //  */
    // public function appointments(): HasMany
    // {
    //     return $this->hasMany(Appointment::class);
    // }

    /**
     * Verifica se il tenant è attivo.
     */
    public function isActive(): bool
    {
        $isActive = $this->attributes['is_active'] ?? false;

        return (bool) $isActive;
    }

    /**
     * Genera lo slug dal nome se non fornito.
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;

        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Restituisce l'URL del tenant.
     */
    public function getUrlAttribute(): string
    {
        $url = $this->domain ?? config('app.url');

        return is_string($url) ? $url : 'http://localhost';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
            'last_activity_at' => 'datetime',
        ];
    }
}
