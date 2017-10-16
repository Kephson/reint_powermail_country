<?php

namespace RENOLIT\ReintPowermailCountry\Utility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Alex Kellner <alexander.kellner@in2code.de>, in2code.de
 *  (c) 2017 Ephraim Härer <ephraim.haerer@renolit.com>, RENOLIT SE
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */
use \TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Get countries from static_info_tables
 *
 * @package reint_powermail_country
 * @license http://www.gnu.org/licenses/lgpl.html
 * 			GNU Lesser General Public License, version 3 or later
 */
class CountriesFromStaticInfoTables
{

	/**
	 * countryRepository
	 *
	 * @var \RENOLIT\ReintPowermailCountry\Domain\Repository\CountryRepository
	 * @inject
	 */
	protected $countryRepository;

	/**
	 * Build array with countries
	 *
	 * @param string $key
	 * @param string $value
	 * @param string $sortbyField
	 * @param string $sorting
	 * @return array
	 */
	public function getCountries($key = 'isoCodeA3', $value = 'officialNameLocal', $sortbyField = 'isoCodeA3', $sorting = 'asc')
	{
		$extSettings = $this->getTypoScriptSettings();
		if (!empty($extSettings['countriesAllowed'])) {
			$countries = $this->countryRepository->findAllowedByIsoA2($extSettings['countriesAllowed'], $sortbyField, $sorting);
		} else {
			$countries = $this->countryRepository->findAllOrderedBy($sortbyField, $sorting);
		}
		$countriesArray = array();
		foreach ($countries as $country) {
			/** @var $country \SJBR\StaticInfoTables\Domain\Model\Country */
			$countriesArray[ObjectAccess::getProperty($country, $key)] = ObjectAccess::getProperty($country, $value);
		}

		return $countriesArray;
	}

	protected function getTypoScriptSettings()
	{
		/* @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
		/* @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager */
		$configurationManager = $objectManager->get(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::class);
		$settings = $configurationManager->getConfiguration(
			\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
		);
		if (isset($settings['plugin.']['tx_reintpowermailcountry.']['settings.'])) {
			$extSettings = $settings['plugin.']['tx_reintpowermailcountry.']['settings.'];
		} else {
			$extSettings = array(
				'countriesAllowed' => '',
				'countryDefault' => '',
			);
		}
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($extSettings);
		return $extSettings;
	}
}
