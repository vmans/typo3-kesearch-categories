<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 27.10.15
 * Time: 16:21
 */

namespace Pws\KesearchCategories\Hooks;


use Pws\KesearchCategories\Domain\Model\Category;
use Pws\KesearchCategories\Domain\Repository\FilterRepository;
use Pws\KesearchCategories\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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