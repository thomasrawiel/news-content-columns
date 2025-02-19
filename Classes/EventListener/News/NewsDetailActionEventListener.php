<?php
declare(strict_types=1);

namespace TRAW\NewsContentColumns\EventListener\News;

use GeorgRinger\News\Event\NewsDetailActionEvent;
use TRAW\NewsContentColumns\Utility\AttributeUtility;
use TRAW\NewsContentColumns\Utility\FilterUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class NewsDetailActionEventListener
 */
class NewsDetailActionEventListener
{
    /**
     * @param NewsDetailActionEvent $event
     *
     * @return void
     */
    public function __invoke(NewsDetailActionEvent $event)
    {
        $request = $event->getRequest();
        $assignedValues = $event->getAssignedValues();
        $newsItem = $assignedValues['newsItem'] ?? null;

        if (!empty($newsItem)
            && $request->getArgument('controller') === 'News'
            && $request->getArgument('action') === 'detail') {

            $newsPluginColPos = AttributeUtility::getCurrentColPos($request);

            $contentElements = $newsItem->getContentElements();

            if ($contentElements->count() > 0 && !is_null($newsPluginColPos)) {
                $filteredContentElements = FilterUtility::filterContentElementsByColPos($contentElements, $newsPluginColPos);

                if ($filteredContentElements->count() < $contentElements->count()) {
                    $newsItem->_setProperty('contentElements', $filteredContentElements);
                }

                $assignedValues['newsItem'] = $newsItem;
                $event->setAssignedValues($assignedValues);
            }
        }
    }

    
}