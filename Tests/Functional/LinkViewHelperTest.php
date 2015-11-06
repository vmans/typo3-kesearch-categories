<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 06.11.15
 * Time: 09:28
 */

namespace Pws\KesearchCategories\Tests\Functional;


use TYPO3\CMS\Core\Tests\Functional\Framework\Frontend\Response;
use TYPO3\CMS\Core\Tests\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LinkViewHelperTest extends FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = array(
        'typo3conf/ext/ke_search',
        'typo3conf/ext/kesearch_categories'
    );
    /**
     * @var array
     */
    protected $coreExtensionsToLoad = array('fluid');

    public function setUp()
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/sys_category.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/sys_category_record_mm.xml');


        $this->setUpFrontendRootPage(1, array('EXT:kesearch_categories/Tests/Functional/Fixtures/Frontend/Basic.ts'));
    }

    /**
     * @test
     */
    public function testMultiFilterCategory()
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database/tx_kesearch_filters_multiselect.xml');
        $expectedContent = urlencode('tx_kesearch_pi1[filter][1][1]') . '=1firstcategory';
        $content = $this->getFrontendResponse(1)->getContent();
        $this->assertTrue(strpos($content, $expectedContent) > 0,
            'CONTENT: ' . $content . 'EXPECTED: ' . $expectedContent);
    }

    /**
     * @test
     */
    public function testSingleFilterCategory()
    {
        $this->importDataSet(__DIR__ . '/Fixtures/Database/tx_kesearch_filters_singleselect.xml');
        $expectedContent = urlencode('tx_kesearch_pi1[filter][1]') . '=1firstcategory';
        $content = $this->getFrontendResponse(1)->getContent();
        $this->assertTrue(strpos($content, $expectedContent) > 0,
            'CONTENT: ' . $content . 'EXPECTED: ' . $expectedContent);
    }


    /**
     * @param array $requestArguments
     * @param bool $failOnFailure
     * @return Response
     */
    protected function fetchFrontendResponse(array $requestArguments, $failOnFailure = true)
    {
        if (!empty($requestArguments['url'])) {
            $requestUrl = '/' . ltrim($requestArguments['url'], '/');
        } else {
            $requestUrl = '/?' . GeneralUtility::implodeArrayForUrl('', $requestArguments);
        }
        $arguments = array(
            'documentRoot' => ORIGINAL_ROOT . 'typo3temp/functional-' . substr(sha1(get_class($this)), 0, 7),
            'requestUrl' => 'http://localhost' . $requestUrl,
        );
        $template = new \Text_Template(ORIGINAL_ROOT . 'typo3/sysext/core/Tests/Functional/Fixtures/Frontend/request.tpl');
        $template->setVar(
            array(
                'arguments' => var_export($arguments, true),
                'originalRoot' => ORIGINAL_ROOT,
            )
        );
        $php = \PHPUnit_Util_PHP::factory();
        $response = $php->runJob($template->render());
        $result = json_decode($response['stdout'], true);
        if ($result === null) {
            $this->fail('Frontend Response is empty');
        }
        if ($failOnFailure && $result['status'] === Response::STATUS_Failure) {
            $this->fail('Frontend Response has failure:' . LF . $result['error']);
        }
        $response = new Response($result['status'], $result['content'], $result['error']);
        return $response;
    }

}