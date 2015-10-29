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
use TYPO3\CMS\Core\Category\CategoryRegistry;
use TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Frontend\Category\Collection\CategoryCollection;

class FilterOptionHook
{

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\FilterRepository
     * @inject
     */
    protected $filterRepository;

    /**
     * @var \TYPO3\CMS\Core\Category\Collection\CategoryCollection
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
                    /* @var $category \Pws\KesearchCategories\Domain\Model\Category */
                    foreach ($categories as $category) {
                        $filters[$key]['options'] = $this->getFilterOptionByCategory($category);
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
            $category->getUid() => array(
                'uid' => $category->getUid(),
                'title' => $category->getTitle(),
                'tag' => $category->getFilterOptionTag()
            )
        );
    }

    /**
     * @param $filterUid
     * @return bool|\TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected function getCategoriesByFilter($filterUid)
    {
        /* @var $filterObject \Pws\KesearchCategories\Domain\Model\Filter */
        if (($filterObject = $this->filterRepository->findByUid($filterUid))
            && $filterObject->isUseCategoriesForFilterOptions()
            && ($categories = $filterObject->getCategories())
        ) {
            return $categories;
        }

        return false;
    }
}