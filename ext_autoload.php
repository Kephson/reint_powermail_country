<?php
// set path for classes
$extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('reint_powermail_country') . 'Classes/';

// set array with classes that should be automatical loaded
$default = array(
	'RENOLIT\\ReintPowermailCountry\\Utility\\CountriesFromStaticInfoTables' => $extensionClassesPath . 'Utility/CountriesFromStaticInfoTables.php',
	'RENOLIT\\ReintPowermailCountry\\ViewHelpers\\Form\\CountriesViewHelper' => $extensionClassesPath . 'ViewHelpers/Form/CountriesViewHelper.php',
);

return $default;
