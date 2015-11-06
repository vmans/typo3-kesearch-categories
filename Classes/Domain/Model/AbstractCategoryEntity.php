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


use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

abstract class AbstractCategoryEntity extends AbstractEntity implements CategoryAwareInterface
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Pws\KesearchCategories\Domain\Model\Category>
     */
    protected $categories;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage();
    }

    /**
     * @return ObjectStorage
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ObjectStorage $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->detach($category);
    }

}