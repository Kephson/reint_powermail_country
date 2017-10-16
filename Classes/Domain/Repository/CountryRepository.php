<?php

namespace RENOLIT\ReintPowermailCountry\Domain\Repository;

/*
 *  Copyright notice
 *
 *  (c) 2017 Ephraim Härer <ephraim.haerer@renolit.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 */
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Extended repository for \SJBR\StaticInfoTables\Domain\Model\Country
 */
class CountryRepository extends \SJBR\StaticInfoTables\Domain\Repository\CountryRepository
{

	/**
	 * Finds a set of allowed countries
	 *
	 * @param string $allowedCountries String with allowed countries as ISO-2
	 * @return array the selected countries
	 */
	public function findAllowedByIsoA2($allowedCountries = '', $sortbyField = 'officialNameLocal', $sorting = 'asc')
	{
		if ($sorting !== 'asc' && $sorting !== 'desc') {
			throw new \InvalidArgumentException('Order direction must be "asc" or "desc".', 1316607580);
		}

		$query = $this->createQuery();

		if (!empty($allowedCountries)) {
			$countries = GeneralUtility::trimExplode(',', $allowedCountries, true);
			$query->matching(
				$query->in('isoCodeA2', $countries)
			);
		}

		$object = $this->objectManager->get($this->objectType);
		if (!array_key_exists($sortbyField, $object->_getProperties())) {
			throw new \InvalidArgumentException('The model "' . $this->objectType . '" has no property "' . $sortbyField . '" to order by.', 1316607579);
		}

		if ($sorting === 'asc') {
			$sorting = QueryInterface::ORDER_ASCENDING;
		} else {
			$sorting = QueryInterface::ORDER_DESCENDING;
		}
		$query->setOrderings(array($sortbyField => $sorting));

		return $query->execute();
	}
}
