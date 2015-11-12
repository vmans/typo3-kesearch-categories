<?php


namespace Pws\KesearchCategories\Hooks;


use Pws\KesearchCategories\Domain\Model\CategoryAwareInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IndexContentHook extends AbstractIndexHook
{

    /**
     * @var \Pws\KesearchCategories\Domain\Repository\ContentRepository
     * @inject
     */
    protected $contentRepository;


    /**
     * IndexContentHook constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->contentRepository = $this->getObjectManager()->get('Pws\\KesearchCategories\\Domain\\Repository\\ContentRepository');
    }


    public function modifyContentIndexEntry(
        $title,
        $row,
        &$tags,
        $uid,
        &$addtionalFields = array(),
        $indexerConfig = array()
    ) {

        if (($content = $this->getCurrentRecord($uid)) && ($categories = $this->getTagsOfRecord($content))) {
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
        return $this->contentRepository->findByUid($uid);
    }
}