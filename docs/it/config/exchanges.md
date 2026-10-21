---
issues: []
discussions: []
title: "Exchanges"
module: "Tenant"
type: concept
tags: [exchanges]
created: 2026-07-14
updated: 2026-07-14
qmd: "exchanges"
related:
<<<<<<< .merge_file_2aNpBq
  - "./phpstan-corrections-january.md"
=======
  - "../../phpstan-corrections-january.md"
>>>>>>> .merge_file_RuTidJ
---
<?php

declare(strict_types=1);

return [
    'coinbase' => [
        'key' => '',
        'secret' => '',
        'passphrase' => '',  //sarebbe extra ?
        'host' => 'https://api.coinbase.com',
    ],
];
