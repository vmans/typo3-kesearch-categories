<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 27.10.15
 * Time: 16:25
 */

namespace Pws\KesearchCategories\Domain\Repository;


use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class FilterRepository extends Repository
{

    /**
     * Set default query settings to avoid to set an storage page
     */
    public function initializeObject()
    {
        /* @var $querySettings QuerySettingsInterface */
        $querySettings = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface');
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

}