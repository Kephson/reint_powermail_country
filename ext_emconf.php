<?php
/* * *************************************************************
 * Extension Manager/Repository config file for ext "reint_powermail_country".
 *
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 * ************************************************************* */

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Powermail Country Viewhelper',
	'description' => 'An extended viewhelper for the powermail country select field.',
	'category' => 'plugin',
	'author' => 'Ephraim Härer',
	'author_email' => 'ephraim.haerer@renolit.com',
	'author_company' => 'RENOLIT SE',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.3.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '7.6.0-7.99.99',
			'php' => '5.5.0-7.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'clearcacheonload' => false,
	'psr-4' => array(
		'classmap' => array(
			'RENOLIT\\ReintPowermailCountry\\' => 'Classes'
		),
	),
);

