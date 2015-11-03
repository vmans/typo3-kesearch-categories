<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 12:25
 */

namespace Pws\KesearchCategories\Hooks;


use Pws\KesearchCategories\Domain\Model\FilterOptionsInterface;
use Pws\KesearchCategories\Domain\Model\Page;
use Pws\KesearchCategories\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IndexPagesHook extends AbstractHook
{

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var array
     */
    protected $keSearchExtensionConfig;

    /**
     * IndexPagesHook constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageRepository = $this->getObjectManager()->get('Pws\\KesearchCategories\\Domain\\Repository\\PageRepository');
    }


    /**
     * @param $pageUid
     * @param string $pageContent
     * @param string $tags
     * @param array $cachedPageRecords
     * @param array $addtionalFields
     * @param array $indexerConfig
     * @param array $defaultValues
     */
    public function modifyPagesIndexEntry(
        $pageUid,
        &$pageContent = '',
        &$tags = '',
        $cachedPageRecords = array(),
        &$addtionalFields = array(),
        $indexerConfig = array(),
        $defaultValues = array()
    ) {

        $this->tags = GeneralUtility::trimExplode(',', $tags, true);

        $page = $this->findPageRecord($pageUid);
        if (($categories = $this->getCategoriesByPage($page))) {
            $this->injectKeSearchExtensionConfig();
            foreach ($categories as $category) {
                $this->addTag($category);
            }
            $tags = implode(',', $this->tags);
        }

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
     * @param Page $page
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected function getCategoriesByPage(Page $page)
    {
        return $page->getCategories();
    }

    /**
     * @param $pageUid
     * @return Page
     */
    protected function findPageRecord($pageUid)
    {
        return $this->pageRepository->findByUid($pageUid);
    }

    /**
     * Injects ke_search extension config
     */
    protected function injectKeSearchExtensionConfig()
    {
        $this->keSearchExtensionConfig = \tx_kesearch_helper::getExtConf();
    }
}