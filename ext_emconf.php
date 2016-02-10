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
	'description' => 'A better viewhelper for the powermail country select field.',
	'category' => 'plugin',
	'author' => 'Ephraim Härer',
	'author_email' => 'ephraim.haerer@renolit.com',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.2.1',
	'constraints' =>
	array(
		'depends' =>
		array(
			'typo3' => '6.2.0-7.6.99',
		),
		'conflicts' =>
		array(
		),
		'suggests' =>
		array(
		),
	),
	'clearcacheonload' => false,
	'author_company' => '',
);

