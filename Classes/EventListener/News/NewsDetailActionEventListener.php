<?php

namespace TRAW\NewsContentColumns\EventListener\News;

use GeorgRinger\News\Event\NewsDetailActionEvent;

class NewsDetailActionEventListener
{
    public function __invoke(NewsDetailActionEvent $event)
    {
        $assignedValues = $event->getAssignedValues();
        $newsItem = $assignedValues['newsItem'] ?? null;

        if (!empty($newsItem)) {
            $contentElementIdList = $newsItem->getContentElementIdList();
            $contentElements = $newsItem->getContentElements();
            $request = $event->getRequest();

            $newsPluginContentElement = $request->getAttribute('currentContentObject');
        }
    }
}