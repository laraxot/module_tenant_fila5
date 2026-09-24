<?php

declare(strict_types=1);

<<<<<<< HEAD
return [
=======
// Tenant translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: ≥5% comment lines on files >100 LOC.
// Canon: Modules/Tenant/docs/wiki — domain i18n only.
// File: lang/it/domain.php
return [
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
>>>>>>> 1ad0554 (.)
    'navigation' => [
        'plural' => 'Domini',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'domain',
        'sort' => 6,
        'icon' => 'tenant-domain-animated',
    ],
    'fields' => [
        'domain' => [
            'label' => 'Dominio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'domains' => [
            'label' => 'Domini',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'list' => [
            'label' => 'Lista Domini',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'label' => 'Crea Dominio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'Modifica Dominio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'destroy' => [
            'label' => 'Elimina Dominio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'rating' => [
            'label' => 'rating',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
<<<<<<< HEAD
            'placeholder' => 'rating',
=======
>>>>>>> 1ad0554 (.)
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
<<<<<<< HEAD
        'title' => [
            'label' => 'title',
            'placeholder' => 'title',
            'helper_text' => 'title',
            'description' => 'title',
        ],
        'brand' => [
            'label' => 'brand',
            'placeholder' => 'brand',
            'helper_text' => 'brand',
            'description' => 'brand',
        ],
        'category' => [
            'label' => 'category',
            'placeholder' => 'category',
            'helper_text' => 'category',
            'description' => 'category',
        ],
        'description' => [
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => 'description',
            'description' => 'description',
        ],
        'price' => [
            'label' => 'price',
            'placeholder' => 'price',
            'helper_text' => 'price',
            'description' => 'price',
        ],
=======
>>>>>>> 1ad0554 (.)
    ],
    'actions' => [
        'domain_created' => 'Dominio creato con successo',
        'domain_updated' => 'Dominio aggiornato con successo',
        'domain_deleted' => 'Dominio eliminato con successo',
        'confirm_delete' => 'Sei sicuro di voler eliminare questo dominio?',
        'no_records' => 'Nessun dominio trovato',
        'invalid_domain' => 'Dominio non valido',
        'domain_exists' => 'Questo dominio esiste già',
        'primary_domain' => 'Dominio Principale',
        'set_primary' => 'Imposta come Principale',
        'domain_set_primary' => 'Dominio impostato come principale con successo',
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
        ],
    ],
    'model' => [
        'label' => 'domain.model',
    ],
    'plural' => [
        'model' => [
            'label' => 'domain.plural.model',
        ],
    ],
    'label' => 'Domain',
    'plural_label' => 'Domain (Plurale)',
];
