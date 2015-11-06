<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 05.11.15
 * Time: 09:41
 */

namespace Pws\KesearchCategories\ViewHelpers\Link;


use Pws\KesearchCategories\Domain\Model\Category;
use Pws\KesearchCategories\Domain\Model\Filter;
use Pws\KesearchCategories\Domain\Repository\CategoryRepository;
use Pws\KesearchCategories\Domain\Repository\FilterRepository;
use TYPO3\CMS\Fluid\ViewHelpers\Link\PageViewHelper;

class CategorySearchLinkViewHelper extends PageViewHelper
{

    /**
     * @var array
     */
    protected $additionalParams = array();

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\FilterRepository
     * @inject
     */
    protected $filterRepository;

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @param null $pageUid
     * @param array $additionalParams
     * @param int $pageType
     * @param bool|false $noCache
     * @param bool|false $noCacheHash
     * @param string $section
     * @param bool|false $linkAccessRestrictedPages
     * @param bool|false $absolute
     * @param bool|false $addQueryString
     * @param array $argumentsToBeExcludedFromQueryString
     * @param null $addQueryStringMethod
     * @param Category|null $category
     * @return string
     */
    public function render(
        $pageUid = null,
        array $additionalParams = array(),
        $pageType = 0,
        $noCache = false,
        $noCacheHash = false,
        $section = '',
        $linkAccessRestrictedPages = false,
        $absolute = false,
        $addQueryString = false,
        array $argumentsToBeExcludedFromQueryString = array(),
        $addQueryStringMethod = null,
        $category = null
    ) {

        $this->additionalParams = $additionalParams;
        /* @var $filter \Pws\KesearchCategories\Domain\Model\Filter */
        if (($category instanceof Category || (is_numeric($category) && $category = $this->categoryRepository->findByUid($category)))
            && ($filter = $this->filterRepository->findOneByCategories($category))
        ) {
            $this->additionalParams['tx_kesearch_pi1']['filter'] = $this->setUpFilterQuery($category, $filter);
        }

        return parent::render($pageUid, $this->additionalParams, $pageType, $noCache, $noCacheHash, $section,
            $linkAccessRestrictedPages, $absolute, $addQueryString, $argumentsToBeExcludedFromQueryString,
            $addQueryStringMethod);
    }

    /**
     * @param Category $category
     * @param Filter $filter
     * @return array
     */
    protected function setUpFilterQuery(Category $category, Filter $filter)
    {
        if ($filter->isMultiSelectFilter()) {
            $param = array($category->getUid() => $category->getFilterOptionTag());
        } else {
            $param = $category->getFilterOptionTag();
        }

        return array($filter->getUid() => $param);
    }

    /**
     * @return array
     */
    public function getAdditionalParams()
    {
        return $this->additionalParams;
    }


}