<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 27.10.15
 * Time: 16:14
 */

namespace Pws\KesearchCategories\Domain\Model;


use Pws\KesearchCategories\Domain\Model\Category;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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