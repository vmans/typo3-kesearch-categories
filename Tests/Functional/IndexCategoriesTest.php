<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 17:21
 */

namespace Pws\KesearchCategories\Tests\Functional;


use TYPO3\CMS\Core\Tests\FunctionalTestCase;

class IndexCategoriesTest extends FunctionalTestCase
{

    /**
     * @var array
     */
    protected $coreExtensionsToLoad = array(
        'extbase',
        'scheduler'
    );

    /**
     * @var array
     */
    protected $testExtensionsToLoad = array(
        'typo3conf/ext/ke_search',
        'typo3conf/ext/kesearch_categories'
    );

    /**
     * @throws \TYPO3\CMS\Core\Tests\Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->setUpBackendUserFromFixture(1);
        \TYPO3\CMS\Core\Core\Bootstrap::getInstance()->initializeLanguageObject();
        $this->importDataSet(__DIR__ . '/Fixtures/Database/be_users.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/tt_content.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/sys_category.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/sys_category_record_mm.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/tx_kesearch_indexerconfig.xml');
    }

    /**
     * @test
     */
    public function testTagsAreSetForPages()
    {
        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ke_search']);
        $indexer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_kesearch_indexer');
        $indexer->startIndexing(true, $this->extConf);

        $row = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
            'tags',
            'tx_kesearch_index', 'type="page"');

        $this->assertEquals('#2secondcategory#,#1firstcategory#', $row['tags']);

    }

    /**
     * @test
     */
    public function testTagsAreSetForContent()
    {
        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ke_search']);
        $indexer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_kesearch_indexer');
        $indexer->startIndexing(true, $this->extConf);

        $row = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
            'tags',
            'tx_kesearch_index', 'type="content"');

        $this->assertEquals('#1firstcategory#', $row['tags']);

    }

}
