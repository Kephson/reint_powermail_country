<?php /** @noinspection PhpUndefinedVariableInspection */
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
    'version' => '3.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'static_info_tables' => '6.9.0-11.5.99',
            'powermail' => '7.0.0-10.99.99',
            'php' => '7.4.0-8.1.99',
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

