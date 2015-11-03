<?php

namespace Pws\KesearchCategories\Domain\Model;

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


use TYPO3\CMS\Core\Charset\CharsetConverter;
use TYPO3\CMS\Extbase\Domain\Model\Category as BaseCategory;

/**
 * Class extends sys_categories for usage with ke_search extension
 *
 * @author Kevin Purrmann <entwicklung@purrmann-websolutions.de>
 * @package Pws\KesearchCategories\Domain\Model
 */
class Category extends BaseCategory implements FilterOptionsInterface
{

    /**
     * Returns unique string
     * @return string
     */
    public function getFilterOptionTag()
    {
        return $this->getUid() . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $this->getTitle()));
    }
}