<?php

namespace Pws\KesearchCategories\Hooks;

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


use Pws\KesearchCategories\Domain\Model\Category;
use Pws\KesearchCategories\Domain\Repository\FilterRepository;
use Pws\KesearchCategories\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class FilterOptionHook
 * @package Pws\KesearchCategories\Hooks
 */
class FilterOptionHook extends AbstractHook
{

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\FilterRepository
     * @inject
     */
    protected $filterRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @param array $filters
     * @param \tx_kesearch_filters $lib
     */
    public function modifyFilters(array &$filters, \tx_kesearch_filters $lib)
    {
        if (!empty($filters)) {
            foreach ($filters as $key => $filter) {
                if ($categories = $this->getCategoriesByFilter($filter['uid'])) {
                    unset($filters[$key]['options']);
                    /* @var $category \Pws\KesearchCategories\Domain\Model\Category */
                    foreach ($categories as $category) {
                        $filters[$key]['options'][$category->getUid()] = $this->getFilterOptionByCategory($category);
                    }
                }

                if (!isset($filters[$key]['options'])) {
                    unset($filters[$key]);
                }

            }
        }

    }

    /**
     * @param Category $category
     * @return array
     */
    protected function getFilterOptionByCategory(Category $category)
    {
        return array(
            'uid' => $category->getUid(),
            'title' => $category->getTitle(),
            'tag' => $category->getFilterOptionTag()
        );
    }

    /**
     * @param $filterUid
     * @return bool|\TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected function getCategoriesByFilter($filterUid)
    {
        /* @var $filterObject \Pws\KesearchCategories\Domain\Model\Filter */
        if (($filterObject = $this->getFilterRepository()->findByUid($filterUid))
            && $filterObject->isUseCategoriesForFilterOptions()
            && ($categories = $filterObject->getCategories())
        ) {

            if ($filterObject->isUseSubcategories()) {
                $categories = $this->getChildCategories($categories);
            }

            return $categories;
        }

        return false;
    }

    /**
     * @param ObjectStorage $categories
     * @return ObjectStorage
     */
    protected function getChildCategories(ObjectStorage $categories)
    {
        $childCategories = new ObjectStorage();
        foreach ($categories as $category) {
            if (($children = $this->getCatgeoryRepository()->findByParent($category))) {
                while ($children->current()) {
                    $childCategories->attach($children->current());
                    $children->next();
                }
            }
        }

        return $childCategories;
    }

    /**
     * Inject won't work in hooks, therefore need to use getter method
     *
     * @return FilterRepository
     */
    public function getFilterRepository()
    {
        if (is_null($this->filterRepository)) {
            $this->filterRepository = $this->getObjectManager()->get('Pws\\KesearchCategories\\Domain\\Repository\\FilterRepository');
        }

        return $this->filterRepository;
    }

    /**
     * @return CategoryRepository
     */
    public function getCatgeoryRepository()
    {
        if (is_null($this->categoryRepository)) {
            $this->categoryRepository = $this->getObjectManager()->get('Pws\\KesearchCategories\\Domain\\Repository\\CategoryRepository');
        }

        return $this->categoryRepository;
    }

}