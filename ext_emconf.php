<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Das',
    'description' => 'Extends pages, content elements and RTE with additional fields to add Bootstrap 5 classes, and adds a new set of content elements, page templates, and viewhelpers to help building sites.',
    'category' => 'distribution',
    'author' => 'Jaume Presas Puig',
    'author_email' => 'jaume@jaumepresas.com',
    'version' => '1.0.0',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.9.99',
            'vhs' => '7.1.0-7.2.99',
            'flux' => '11.0.0-11.1.99'
        ],
    ],
];
