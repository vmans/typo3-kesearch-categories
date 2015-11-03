<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 12:53
 */

namespace Pws\KesearchCategories\Hooks;


use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

interface ObjectManagerAwareInterface
{
    /**
     * @return ObjectManagerInterface
     */
    public function getObjectManager();
}