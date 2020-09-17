<?php
/* * *************************************************************
 * Extension Manager/Repository config file for ext "reint_powermail_country".
 *
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 * ************************************************************* */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Powermail Country Viewhelper',
    'description' => 'An extended ViewHelper for the powermail country select field.',
    'category' => 'plugin',
    'author' => 'Ephraim Härer',
    'author_email' => 'ephraim.haerer@renolit.com',
    'author_company' => 'RENOLIT SE',
    'state' => 'stable',
    'uploadfolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => false,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.17-10.4.99',
            'static_info_tables' => '6.9.0-6.9.99',
            'php' => '7.2.0-0.0.0',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'psr-4' => [
        'classmap' => [
            'RENOLIT\\ReintPowermailCountry\\' => 'Classes'
        ],
    ],
];

