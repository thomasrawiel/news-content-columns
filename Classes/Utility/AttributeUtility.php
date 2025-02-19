<?php
declare(strict_types=1);

namespace TRAW\NewsContentColumns\Utility;

use Psr\Http\Message\RequestInterface;

class AttributeUtility
{
    public static function getCurrentColPos(RequestInterface $request): ?int
    {
        return $request->getAttribute('currentContentObject')->data['colPos'] ?? null;
    }
}