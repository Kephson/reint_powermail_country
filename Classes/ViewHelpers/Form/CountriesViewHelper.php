<?php

namespace RENOLIT\ReintPowermailCountry\ViewHelpers\Form;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2015-2020 Ephraim Härer https://github.com/Kephson
 *  (c) 2016 Hans Mayer <hans.mayer83@gmail.com>
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
use RENOLIT\ReintPowermailCountry\Utility\CountriesFromStaticInfoTables;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * View helper to get a country array
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class CountriesViewHelper extends AbstractViewHelper
{

    /**
     * register additional arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('key', 'string', 'e.g. isoCodeA3', false);
        $this->registerArgument('value', 'string', 'e.g. officialNameLocal', false);
        $this->registerArgument('sortbyField', 'string', 'e.g. isoCodeA3', false);
        $this->registerArgument('sorting', 'string', 'e.g. asc', false);
        $this->registerArgument('other', 'bool', 'e.g. true', false);
    }

    /**
     * Get array with countries
     *
     * @return array
     */
    public function render()
    {
        $key = $this->arguments['key'] ? $this->arguments['key'] : 'isoCodeA3';
        $value = $this->arguments['value'] ? $this->arguments['value'] : 'officialNameLocal';
        $sortbyField = $this->arguments['sortbyField'] ? $this->arguments['sortbyField'] : 'isoCodeA3';
        $sorting = $this->arguments['sorting'] ? $this->arguments['sorting'] : 'asc';
        $other = $this->arguments['other'] ? $this->arguments['other'] : true;
        // get countries from static_info_tables
        if (ExtensionManagementUtility::isLoaded('static_info_tables')) {
            $iso2Key = self::getTwoLetterIsoCode();
            $countriesFromStaticInfoTables = $this->objectManager->get(CountriesFromStaticInfoTables::class);

            if ($key === 'isoCodeA2') {
                $oldTableField = 'cn_iso_2';
            } else {
                $oldTableField = 'cn_iso_3';
            }

            if ($this->isLoadedLanguageVersion($iso2Key)) {
                $countries = $countriesFromStaticInfoTables->getCountries($key, 'shortName' . ucfirst($iso2Key), 'shortName' . ucfirst($iso2Key), $sorting);
            } else {
                $countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameEn', 'shortNameEn', $sorting);
            }

            $countries = $this->removeEmptyEntries($countries);
        } else {
            $countries = $this->getCountries();
        }

        if ($other) {
            return $this->addNoCountry($countries);
        } else {
            return $countries;
        }
    }

    /**
     * remove empty entries from array
     *
     * @param array $countries
     *
     * @return array $countries
     */
    protected function removeEmptyEntries($countries)
    {
        if (is_array($countries)) {
            foreach ($countries as $k => $c) {
                if (empty($c)) {
                    unset($countries[$k]);
                }
            }
        }
        return $countries;
    }

    /**
     * add a no country found option
     *
     * @param array $countries
     *
     * @return array $countries
     */
    protected function addNoCountry($countries)
    {
        if (is_array($countries)) {
            $trans = LocalizationUtility::translate('other_country', 'reint_powermail_country');
            $countries['other'] = $trans;
        }
        return $countries;
    }

    /**
     * check is static_info_tables_LANGUAGE is loaded
     *
     * @param string $langKey
     *
     * @return bool
     */
    protected function isLoadedLanguageVersion($langKey)
    {
        return ExtensionManagementUtility::isLoaded('static_info_tables_' . $langKey);
    }

    /**
     * check version of static_info_tables_LANGUAGE
     *
     * @param $langKey
     * @param $version
     *
     * @return boolean
     */
    protected function compareVersion($langKey, $version)
    {
        return version_compare(ExtensionManagementUtility::getExtensionVersion('static_info_tables_' . $langKey), $version) >= 0;
    }

    /**
     * Build an country array
     *
     * @return \array
     */
    protected function getCountries()
    {
        $countries = array(
            'AND' => 'Andorra',
            'ARE' => 'الإمارات العربيّة المتّحدة',
            'AFG' => 'افغانستان',
            'ATG' => 'Antigua and Barbuda',
            'AIA' => 'Anguilla',
            'ALB' => 'Shqipëria',
            'ARM' => 'Հայաստան',
            'ANT' => 'Nederlandse Antillen',
            'AGO' => 'Angola',
            'ATA' => 'Antarctica',
            'ARG' => 'Argentina',
            'ASM' => 'Amerika Samoa',
            'AUT' => 'Österreich',
            'AUS' => 'Australia',
            'ABW' => 'Aruba',
            'AZE' => 'Azərbaycan',
            'BIH' => 'BiH/БиХ',
            'BRB' => 'Barbados',
            'BGD' => 'বাংলাদেশ',
            'BEL' => 'Belgique',
            'BFA' => 'Burkina',
            'BGR' => 'България (Bulgaria)',
            'BHR' => 'البحري',
            'BDI' => 'Burundi',
            'BEN' => 'Bénin',
            'BMU' => 'Bermuda',
            'BRN' => 'دارالسلام',
            'BOL' => 'Bolivia',
            'BRA' => 'Brasil',
            'BHS' => 'The Bahamas',
            'BTN' => 'Druk-Yul',
            'BVT' => 'Bouvet Island',
            'BWA' => 'Botswana',
            'BLR' => 'Беларусь',
            'BLZ' => 'Belize',
            'CAN' => 'Canada',
            'CCK' => 'Cocos (Keeling) Islands',
            'COD' => 'Congo',
            'CAF' => 'Centrafrique',
            'COG' => 'Congo-Brazzaville',
            'CHE' => 'Schweiz',
            'CIV' => 'Côte d’Ivoire',
            'COK' => 'Cook Islands',
            'CHL' => 'Chile',
            'CMR' => 'Cameroun',
            'CHN' => '中华',
            'COL' => 'Colombia',
            'CRI' => 'Costa Rica',
            'CUB' => 'Cuba',
            'CPV' => 'Cabo Verde',
            'CXR' => 'Christmas Island',
            'CYP' => 'Κύπρος / Kıbrıs',
            'CZE' => 'Česko',
            'DEU' => 'Deutschland',
            'DJI' => 'Djibouti',
            'DNK' => 'Danmark',
            'DMA' => 'Dominica',
            'DOM' => 'Quisqueya',
            'DZA' => 'الجزائ',
            'ECU' => 'Ecuador',
            'EST' => 'Eesti',
            'EGY' => 'مصر',
            'ESH' => 'الصحراء الغربي',
            'ERI' => 'ኤርትራ',
            'ESP' => 'España',
            'ETH' => 'ኢትዮጵያ',
            'FIN' => 'Suomi',
            'FJI' => 'Fiji / Viti',
            'FLK' => 'Falkland Islands',
            'FSM' => 'Micronesia',
            'FRO' => 'Føroyar / Færøerne',
            'FRA' => 'France',
            'GAB' => 'Gabon',
            'GBR' => 'United Kingdom',
            'GRD' => 'Grenada',
            'GEO' => 'საქართველო',
            'GUF' => 'Guyane française',
            'GHA' => 'Ghana',
            'GIB' => 'Gibraltar',
            'GRL' => 'Grønland',
            'GMB' => 'Gambia',
            'GIN' => 'Guinée',
            'GLP' => 'Guadeloupe',
            'GNQ' => 'Guinea Ecuatorial',
            'GRC' => 'Ελλάδα',
            'SGS' => 'South Georgia and the South Sandwich Islands',
            'GTM' => 'Guatemala',
            'GUM' => 'Guåhån',
            'GNB' => 'Guiné-Bissau',
            'GUY' => 'Guyana',
            'HKG' => '香港',
            'HND' => 'Honduras',
            'HRV' => 'Hrvatska',
            'HTI' => 'Ayiti',
            'HUN' => 'Magyarország',
            'IDN' => 'Indonesia',
            'IRL' => 'Éire',
            'ISR' => 'ישראל',
            'IND' => 'India',
            'IOT' => 'British Indian Ocean Territory',
            'IRQ' => 'العراق / عيَراق',
            'IRN' => 'ايران',
            'ISL' => 'Ísland',
            'ITA' => 'Italia',
            'JAM' => 'Jamaica',
            'JOR' => 'أردنّ',
            'JPN' => '日本',
            'KEN' => 'Kenya',
            'KGZ' => 'Кыргызстан',
            'KHM' => 'Kâmpŭchea',
            'KIR' => 'Kiribati',
            'COM' => 'اتحاد القمر',
            'KNA' => 'Saint Kitts and Nevis',
            'PRK' => '북조선',
            'KOR' => '한국',
            'KWT' => 'الكويت',
            'CYM' => 'Cayman Islands',
            'KAZ' => 'Қазақстан /Казахстан',
            'LAO' => 'ເມືອງລາວ',
            'LBN' => 'لبنان',
            'LCA' => 'Saint Lucia',
            'LIE' => 'Liechtenstein',
            'LKA' => 'ශ්‍රී ලංකා / இலங்கை',
            'LBR' => 'Liberia',
            'LSO' => 'Lesotho',
            'LTU' => 'Lietuva',
            'LUX' => 'Luxemburg',
            'LVA' => 'Latvija',
            'LBY' => 'ليبيا',
            'MAR' => 'المغربية',
            'MCO' => 'Monaco',
            'MDA' => 'Moldova',
            'MDG' => 'Madagascar',
            'MHL' => 'Marshall Islands',
            'MKD' => 'Македонија',
            'MLI' => 'Mali',
            'MMR' => 'Myanmar',
            'MNG' => 'Монгол Улс',
            'MAC' => '澳門 / Macau',
            'MNP' => 'Northern Marianas',
            'MTQ' => 'Martinique',
            'MRT' => 'الموريتانية',
            'MSR' => 'Montserrat',
            'MLT' => 'Malta',
            'MUS' => 'Mauritius',
            'MDV' => 'ޖުމުހޫރިއްޔ',
            'MWI' => 'Malawi',
            'MEX' => 'México',
            'MYS' => 'مليسيا',
            'MOZ' => 'Moçambique',
            'NAM' => 'Namibia',
            'NCL' => 'Nouvelle-Calédonie',
            'NER' => 'Niger',
            'NFK' => 'Norfolk Island',
            'NGA' => 'Nigeria',
            'NIC' => 'Nicaragua',
            'NLD' => 'Nederland',
            'NOR' => 'Norge',
            'NPL' => 'नेपाल',
            'NRU' => 'Naoero',
            'NIU' => 'Niue',
            'NZL' => 'New Zealand / Aotearoa',
            'OMN' => 'عُمان',
            'PAN' => 'Panamá',
            'PER' => 'Perú',
            'PYF' => 'Polynésie française',
            'PNG' => 'Papua New Guinea  / Papua Niugini',
            'PHL' => 'Philippines',
            'PAK' => 'پاکستان',
            'POL' => 'Polska',
            'SPM' => 'Saint-Pierre-et-Miquelon',
            'PCN' => 'Pitcairn Islands',
            'PRI' => 'Puerto Rico',
            'PRT' => 'Portugal',
            'PLW' => 'Belau / Palau',
            'PRY' => 'Paraguay',
            'QAT' => 'قطر',
            'REU' => 'Réunion',
            'ROU' => 'România',
            'RUS' => 'Росси́я',
            'RWA' => 'Rwanda',
            'SAU' => 'السعودية',
            'SLB' => 'Solomon Islands',
            'SYC' => 'Seychelles',
            'SDN' => 'Sénégal',
            'SWE' => 'Sverige',
            'SGP' => 'Singapore',
            'SHN' => 'Saint Helena, Ascension and Tristan da Cunha',
            'SVN' => 'Slovenija',
            'SJM' => 'Svalbard',
            'SVK' => 'Slovensko',
            'SLE' => 'Sierra Leone',
            'SMR' => 'San Marino',
            'SEN' => 'Sénégal',
            'SOM' => 'Soomaaliya',
            'SUR' => 'Suriname',
            'STP' => 'São Tomé e Príncipe',
            'SLV' => 'El Salvador',
            'SYR' => 'سوري',
            'SWZ' => 'weSwatini',
            'TCA' => 'Turks and Caicos Islands',
            'TCD' => 'Tchad',
            'ATF' => 'Terres australes fran‡aises',
            'TGO' => 'Togo',
            'THA' => 'ไทย',
            'TJK' => 'Тоҷикистон',
            'TKL' => 'Tokelau',
            'TKM' => 'Türkmenistan',
            'TUN' => 'التونسية',
            'TON' => 'Tonga',
            'TLS' => 'Timor Lorosa\'e',
            'TUR' => 'Türkiye',
            'TTO' => 'Trinidad and Tobago',
            'TUV' => 'Tuvalu',
            'TWN' => '中華',
            'TZA' => 'Tanzania',
            'UKR' => 'Україна',
            'UGA' => 'Uganda',
            'UMI' => 'United States Minor Outlying Islands',
            'USA' => 'United States',
            'URY' => 'Uruguay',
            'UZB' => 'O‘zbekiston',
            'VAT' => 'Vaticano',
            'VCT' => 'Saint Vincent and the Grenadines',
            'VEN' => 'Venezuela',
            'VGB' => 'British Virgin Islands',
            'VIR' => 'US Virgin Islands',
            'VNM' => 'Việt Nam',
            'VUT' => 'Vanuatu',
            'WLF' => 'Wallis and Futuna',
            'WSM' => 'Samoa',
            'YEM' => 'اليمنية',
            'MYT' => 'Mayotte',
            'ZAF' => 'Afrika-Borwa',
            'ZMB' => 'Zambia',
            'ZWE' => 'Zimbabwe',
            'PSE' => 'فلسطين',
            'CSG' => 'Србија и Црна Гора',
            'ALA' => 'Åland',
            'HMD' => 'Heard Island and McDonald Islands',
            'MNE' => 'Crna Gora',
            'SRB' => 'Srbija',
            'JEY' => 'Jersey',
            'GGY' => 'Guernsey',
            'IMN' => 'Mann / Mannin',
            'MAF' => 'Saint-Martin',
            'BLM' => 'Saint-Barthélemy',
            'BES' => 'Bonaire, Sint Eustatius en Saba',
            'CUW' => 'Curaçao',
            'SXM' => 'Sint Maarten',
            'SSD' => 'South Sudan',
        );
        return $countries;
    }


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
