<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 12:52
 */

namespace Pws\KesearchCategories\Hooks;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

abstract class AbstractHook implements ObjectManagerAwareInterface
{

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     *
     */
    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
    }

    /**
     * @return ObjectManagerInterface
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

}