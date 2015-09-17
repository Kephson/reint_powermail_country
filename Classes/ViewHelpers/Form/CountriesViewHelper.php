<?php

namespace RENOLIT\ReintPowermailCountry\ViewHelpers\Form;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * View helper to get a country array
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class CountriesViewHelper extends AbstractViewHelper {

	/**
	 * Get array with countries
	 *
	 * @param \string $key
	 * @param \string $value
	 * @param \string $sortbyField
	 * @param \string $sorting
	 * @return array
	 */
	public function render($key = 'isoCodeA3', $value = 'officialNameLocal', $sortbyField = 'isoCodeA3', $sorting = 'asc') {
		$countries = $this->getCountries();

		// get countries from static_info_tables
		if (ExtensionManagementUtility::isLoaded('static_info_tables')) {
			$countriesFromStaticInfoTables = $this->objectManager->get('RENOLIT\ReintPowermailCountry\Utility\CountriesFromStaticInfoTables');

			if ($key === 'isoCodeA2') {
				$oldTableField = 'cn_iso_2';
			} else {
				$oldTableField = 'cn_iso_3';
			}

			// static_info_tables_de
			if (ExtensionManagementUtility::isLoaded('static_info_tables_de') && $GLOBALS['TSFE']->lang === 'de') {
				$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameDe', 'shortNameDe', $sorting);
			}
			// static_info_tables_fr
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_fr') && $GLOBALS['TSFE']->lang === 'fr') {
				$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameFr', 'shortNameFr', $sorting);
			}
			// static_info_tables_ru
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_ru') && $GLOBALS['TSFE']->lang === 'ru') {
				$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_ru', 'cn_short_ru', $sorting);
			}
			// static_info_tables_sv
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_sv') && $GLOBALS['TSFE']->lang === 'sv') {
				$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_sv', 'cn_short_sv', $sorting);
			}
			// static_info_tables_nl
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_nl') && $GLOBALS['TSFE']->lang === 'nl') {
				$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_nl', 'cn_short_nl', $sorting);
			}
			// static_info_tables_it
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_it') && $GLOBALS['TSFE']->lang === 'it') {
				if (version_compare(ExtensionManagementUtility::getExtensionVersion('static_info_tables_it'), '6.2.0') >= 0) {
					$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameIt', 'shortNameIt', $sorting);
				} else {
					$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_it', 'cn_short_it', $sorting);
				}
			}
			// static_info_tables_es
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_es') && $GLOBALS['TSFE']->lang === 'es') {
				if (version_compare(ExtensionManagementUtility::getExtensionVersion('static_info_tables_es'), '6.2.0') >= 0) {
					$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameEs', 'shortNameEs', $sorting);
				} else {
					$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_es', 'cn_short_es', $sorting);
				}
			}
			// static_info_tables_da
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_da') && $GLOBALS['TSFE']->lang === 'da') {
				if (version_compare(ExtensionManagementUtility::getExtensionVersion('static_info_tables_da'), '6.2.0') >= 0) {
					$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameDa', 'shortNameDa', $sorting);
				} else {
					$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_da', 'cn_short_da', $sorting);
				}
			}
			// static_info_tables_zh
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_zh') && $GLOBALS['TSFE']->lang === 'zh') {
				if (version_compare(ExtensionManagementUtility::getExtensionVersion('static_info_tables_zh'), '6.2.0') >= 0) {
					$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameZh', 'shortNameZh', $sorting);
				} else {
					$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_zh', 'cn_short_zh', $sorting);
				}
			}
			// static_info_tables_pl
			else if (ExtensionManagementUtility::isLoaded('static_info_tables_pl') && $GLOBALS['TSFE']->lang === 'pl') {
				if (version_compare(ExtensionManagementUtility::getExtensionVersion('static_info_tables_pl'), '1.2.0') >= 0) {
					$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNamePl', 'shortNamePl', $sorting);
				} else {
					$countries = $this->loadCountryFieldsViaTypo3Api($oldTableField, 'cn_short_pl', 'cn_short_pl', $sorting);
				}
			}
			// default is english
			else {
				$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameEn', 'shortNameEn', $sorting);
			}

			//DebuggerUtility::var_dump($countries);
			// load english entries if nothing was found
			if (empty($countries)) {
				$countries = $countriesFromStaticInfoTables->getCountries($key, 'shortNameEn', 'shortNameEn', $sorting);
			}
			$countries = $this->removeEmptyEntries($countries);
		}

		return $this->addNoCountry($countries);
	}

	/**
	 * load entries direct from table if static_info_tables ext has no model
	 * 
	 * @param array $countries
	 */
	protected function loadCountryFieldsViaTypo3Api($key, $field, $orderby = '', $sorting = '') {
		$fields = $key . ',' . $field;
		$table = 'static_countries';
		$entries = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				$fields, $table, '', '', $orderby . ' ' . $sorting, ''
		);
		$countries = array();
		if (!empty($entries)) {
			foreach ($entries as $e) {
				$countries[$e[$key]] = $e[$field];
			}
		}
		return $countries;
	}

	/**
	 * remove empty entries from array
	 * 
	 * @param array $countries
	 */
	protected function removeEmptyEntries($countries) {
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
	 */
	protected function addNoCountry($countries) {
		if (is_array($countries)) {
			$trans = LocalizationUtility::translate('other_country', 'reint_powermail_country');
			$countries['other'] = $trans;
		}
		return $countries;
	}

	/**
	 * Build an country array
	 *
	 * @return \array
	 */
	protected function getCountries() {
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

}
