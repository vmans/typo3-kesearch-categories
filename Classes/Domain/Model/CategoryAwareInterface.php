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

namespace Pws\KesearchCategories\Domain\Model;


use Pws\KesearchCategories\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Interface CategoryAwareInterface
 * @package Pws\KesearchCategories\Domain\Model
 */
interface CategoryAwareInterface
{
    /**
     * @return ObjectStorage
     */
    public function getCategories();

    /**
     * @param $categories
     * @return void
     */
    public function setCategories($categories);

    /**
     * @param Category $category
     * @return void
     */
    public function addCategory(Category $category);

    /**
     * @param Category $category
     * @return void
     */
    public function removeCategory(Category $category);
}