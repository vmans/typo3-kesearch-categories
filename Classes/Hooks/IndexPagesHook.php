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

namespace Pws\KesearchCategories\Hooks;


use Pws\KesearchCategories\Domain\Model\CategoryAwareInterface;
use Pws\KesearchCategories\Domain\Model\FilterOptionsInterface;
use Pws\KesearchCategories\Domain\Model\Page;
use Pws\KesearchCategories\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IndexPagesHook extends AbstractIndexHook
{

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\PageRepository
     * @inject
     */
    protected $pageRepository;

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
        if (($page = $this->getCurrentRecord($pageUid)) && ($categories = $this->getTagsOfRecord($page))) {
            $this->tags = GeneralUtility::trimExplode(',', $tags, true);
            $this->injectKeSearchExtensionConfig();
            foreach ($categories as $category) {
                $this->addTag($category);
            }
            $tags = implode(',', $this->tags);
            $addtionalFields['sortdate'] = 1;
            $addtionalFields['orig_pid'] = (int) $addtionalFields['orig_pid'];
        }

    }

    /**
     * @param int $uid
     * @return CategoryAwareInterface
     */
    protected function getCurrentRecord($uid)
    {
        return $this->pageRepository->findByUid($uid);
    }


}