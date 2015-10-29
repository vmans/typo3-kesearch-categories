<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 17:21
 */

namespace Pws\KesearchCategories\Tests\Functional;


use TYPO3\CMS\Core\Tests\FunctionalTestCase;

class IndexCategoriesByPagesTest extends FunctionalTestCase
{

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
    protected function setUp()
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');
    }

    public function testInit()
    {
        exec(__DIR__ . '/../../.Build/Web/typo3/cli_dispatch.phpsh ke_search startIndexing');
//        var_dump($response);
    }
}
