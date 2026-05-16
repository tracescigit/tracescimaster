<?php
return [
    'default' => 'main',

    'connections' => [
        'main' => [
            'salt' => env('HASHIDS_SALT', 'your-salt'),
            'length' => 10,
        ],
    ],
];