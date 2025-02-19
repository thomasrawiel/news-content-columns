<?php
declare(strict_types=1);

namespace TRAW\NewsContentColumns\Utility;

use Psr\Http\Message\RequestInterface;
use TRAW\NewsContentColumns\Domain\Model\News;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class AttributeUtility
{
    public static function getCurrentColPos(RequestInterface $request): ?int
    {
        return $request->getAttribute('currentContentObject')->data['colPos'] ?? null;
    }

    public static function generateIdList(ObjectStorage $contentElements): string
    {
        $idList = [];
        if ($contentElements) {
            foreach ($contentElements as $contentElement) {
                if ($contentElement->getColPos() >= 0) {
                    $idList[] = $contentElement->getUid();
                }
            }
        }
        return implode(',', $idList);
    }
}