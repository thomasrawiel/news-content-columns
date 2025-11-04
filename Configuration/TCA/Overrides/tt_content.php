<?php
declare(strict_types=1);

defined('TYPO3') or die('Access denied.');

(static function (): void {
    $pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'NewsContentColumns',
        'NewsContentElements',
        'Render News Content Elements for this column',
        'ext-news-content-columns',
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
})();
