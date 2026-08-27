<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Das',
    'description' => 'Extends pages, content elements and RTE with additional fields to add Bootstrap 5 classes, and adds a new set of content elements, page templates, and viewhelpers to help building sites.',
    'category' => 'fe',
    'author' => 'Jaume Presas Puig',
    'author_email' => 'jaume@jaumepresas.com',
    'version' => '1.0.9',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.3.99',
            'vhs' => '7.1.0-8.0.99',
            'flux' => '11.0.0-12.0.99',
        ],
    ],
];
