<?php

namespace TRAW\NewsContentColumns\Controller;

use TRAW\NewsContentColumns\Domain\Repository\NewsRepository;
use Psr\Http\Message\ResponseInterface;
use TRAW\NewsContentColumns\Utility\AttributeUtility;
use TRAW\NewsContentColumns\Utility\FilterUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class ContentElementController
 */
class ContentElementController extends ActionController
{
    /**
     * @var NewsRepository|null
     */
    protected ?NewsRepository $newsRepository = null;

    /**
     * @param NewsRepository $newsRepository
     *
     * @return void
     */
    public function injectNewsRepository(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $requestArguments = $this->request->getAttribute('routing')->getArguments();
        $controller = $requestArguments['tx_news_pi1']['controller'] ?? null;
        $action = $requestArguments['tx_news_pi1']['action'] ?? null;
        $newsId = (int)$requestArguments['tx_news_pi1']['news'];

        if ($controller === 'News'
            && $action === 'detail'
            && $newsId > 0) {

            $currentColPos = AttributeUtility::getCurrentColPos($this->request);
            $newsRecord = $this->newsRepository->findByUid($newsId);

            $filteredContentElements = FilterUtility::filterContentElementsByColPos($newsRecord->getContentElements(), $currentColPos);

            if($filteredContentElements->count() > 0) {
                $newsRecord->_setProperty('contentElements', $filteredContentElements);
                $this->view->assignMultiple([
                    'newsId' => $newsRecord->getUid(),
                    'currentColPos' => $currentColPos,
                    'contentElementIdList' => $newsRecord->getContentElementIdList()
                ]);
                unset($newsRecord);
            }
        }

        return $this->htmlResponse();
    }
}