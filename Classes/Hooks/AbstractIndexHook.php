<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Pws\KesearchCategories\Hooks;


use Pws\KesearchCategories\Domain\Model\CategoryAwareInterface;
use Pws\KesearchCategories\Domain\Model\FilterOptionsInterface;

abstract class AbstractIndexHook extends AbstractHook
{
    /**
     * @var array
     */
    protected $tags;

    /**
     * @var array
     */
    protected $keSearchExtensionConfig;

    /**
     * @param int $uid
     * @return CategoryAwareInterface
     */
    abstract protected function getCurrentRecord($uid);

    /**
     * @return \Iterator
     */
    protected function getTagsOfRecord(CategoryAwareInterface $categoryAwareInterface)
    {
        return $categoryAwareInterface->getCategories();
    }


    /**
     * @param FilterOptionsInterface $option
     */
    protected function addTag(FilterOptionsInterface $option)
    {
        array_push(
            $this->tags,
            $this->keSearchExtensionConfig['prePostTagChar'] . $option->getFilterOptionTag() . $this->keSearchExtensionConfig['prePostTagChar']
        );
    }

    /**
     * Injects ke_search extension config
     */
    protected function injectKeSearchExtensionConfig()
    {
        $this->keSearchExtensionConfig = \tx_kesearch_helper::getExtConf();
    }
}