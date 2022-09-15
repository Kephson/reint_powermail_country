<?php

namespace RENOLIT\ReintPowermailCountry\ViewHelpers;

/*
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use RENOLIT\ReintPowermailCountry\Utility\SiteLanguageUtility;
use Closure;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Returns the current language from languages depending on l18n settings.
 */
class LanguageCodeViewHelper extends AbstractViewHelper
{

    /**
     * @param array $arguments
     * @param Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(
        array                     $arguments,
        Closure                   $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    )
    {
        return SiteLanguageUtility::getTwoLetterIsoCode();
    }
}
