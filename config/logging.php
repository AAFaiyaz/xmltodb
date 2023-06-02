<?php

return [
    'default' => 'stack',
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('../logs/xml_processor.log'),
            'level' => 'error',
        ],
    ],
];
