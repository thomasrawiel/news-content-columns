<?php
declare(strict_types=1);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'NewsContentColumns',
    'NewsContentElements',
    [\TRAW\NewsContentColumns\Controller\ContentElementController::class => 'list'],
    [],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);