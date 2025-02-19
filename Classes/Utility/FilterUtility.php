<?php

namespace TRAW\NewsContentColumns\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class FilterUtility
{
    /**
     * Get all attached content elements that have this colPos
     *
     * @param ObjectStorage $contentElements
     * @param int           $colPos
     *
     * @return ObjectStorage
     */
    public static function filterContentElementsByColPos(ObjectStorage $contentElements, int $colPos): ObjectStorage
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
}