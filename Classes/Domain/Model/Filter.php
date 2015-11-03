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
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class maps table tx_kesearch_filters
 *
 * @package Pws\KesearchCategories\Domain\Model
 */
class Filter extends AbstractDomainObject
{

    /**
     * @var boolean
     */
    protected $useCategoriesForFilterOptions;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Pws\KesearchCategories\Domain\Model\Category>
     */
    protected $categories;

    /**
     * @var boolean
     */
    protected $useSubcategories;

    /**
     * Filter constructor.
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage();
    }


    /**
     * @return boolean
     */
    public function isUseCategoriesForFilterOptions()
    {
        return $this->useCategoriesForFilterOptions;
    }

    /**
     * @param boolean $useCategoriesForFilterOptions
     */
    public function setUseCategoriesForFilterOptions($useCategoriesForFilterOptions)
    {
        $this->useCategoriesForFilterOptions = $useCategoriesForFilterOptions;
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

    /**
     * @return boolean
     */
    public function isUseSubcategories()
    {
        return $this->useSubcategories;
    }

    /**
     * @param boolean $useSubcategories
     */
    public function setUseSubcategories($useSubcategories)
    {
        $this->useSubcategories = $useSubcategories;
    }


}