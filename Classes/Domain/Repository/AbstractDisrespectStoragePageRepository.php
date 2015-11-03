<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 12:47
 */

namespace Pws\KesearchCategories\Domain\Repository;


use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class AbstractDisrespectStoragePageRepository
 * Class sets setRespectStoragePage to false for default query settings
 *
 * @package Pws\KesearchCategories\Domain\Repository
 */
abstract class AbstractDisrespectStoragePageRepository extends Repository
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