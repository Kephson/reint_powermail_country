<?php

namespace RENOLIT\ReintPowermailCountry\Utility;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020-2022 Ephraim Härer <ephraim@ephespage.de>
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

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to get a comma separated string of cat breeds by id
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class SiteLanguageUtility extends AbstractViewHelper
{

    /**
     * Returns the currently configured "site language" if a site is configured (= resolved) in the current request.
     */
    public static function getCurrentSiteLanguage(): ?SiteLanguage
    {
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        return $request
        && $request instanceof ServerRequestInterface
        && $request->getAttribute('language') instanceof SiteLanguage
            ? $request->getAttribute('language')
            : null;
    }

    /**
     * @return string
     */
    public static function getTwoLetterIsoCode(): string
    {
        $siteLanguage = self::getCurrentSiteLanguage();
        if ($siteLanguage !== null && is_object($siteLanguage)) {
            $twoLetterIsoCode = $siteLanguage->getTwoLetterIsoCode();
        } else {
            $twoLetterIsoCode = 'en';
        }
        return $twoLetterIsoCode;
    }
}
