<?php
declare(strict_types=1);

namespace TRAW\NewsContentColumns\EventListener\News;

use GeorgRinger\News\Event\NewsDetailActionEvent;
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

            $newsPluginColPos = $this->getColPosOfNewsPlugin($request->getAttribute('currentContentObject'));

            $contentElements = $newsItem->getContentElements();

            if ($contentElements->count() > 0 && !is_null($newsPluginColPos)) {
                $filteredContentElements = $this->filterContentElementsByColPos($contentElements, $newsPluginColPos);

                if ($filteredContentElements->count() < $contentElements->count()) {
                    $newsItem->_setProperty('contentElements', $filteredContentElements);
                }

                $assignedValues['newsItem'] = $newsItem;
                $event->setAssignedValues($assignedValues);
            }
        }
    }

    /**
     * Get all attached content elements that have this colPos
     *
     * @param ObjectStorage $contentElements
     * @param int           $colPos
     *
     * @return ObjectStorage
     */
    protected function filterContentElementsByColPos(ObjectStorage $contentElements, int $colPos): ObjectStorage
    {
        $filteredContentElements = array_filter($contentElements->getArray(), function ($element) use ($colPos) {
            return $element->getColPos() === $colPos;
        });

        $objects = GeneralUtility::makeInstance(ObjectStorage::class);
        array_walk($filteredContentElements, function (&$item) use ($objects) {
            $objects->attach($item);
        });

        return $objects;
    }

    /**
     * Get the colPos of the news detail plugin
     *
     * @param ContentObjectRenderer $currentContentObject
     *
     * @return int|null
     */
    protected function getColPosOfNewsPlugin(ContentObjectRenderer $currentContentObject): ?int
    {
        return $currentContentObject->data['colPos'] ?? null;
    }
}