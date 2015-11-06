<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 05.11.15
 * Time: 09:42
 */

namespace Pws\KesearchCategories\Tests\ViewHelpers\Link;


use Pws\KesearchCategories\Domain\Model\Category;
use Pws\KesearchCategories\Domain\Model\Filter;
use Pws\KesearchCategories\Domain\Repository\FilterRepository;
use Pws\KesearchCategories\ViewHelpers\Link\CategorySearchLinkViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use TYPO3\CMS\Fluid\Tests\Unit\ViewHelpers\ViewHelperBaseTestcase;

class CategorySearchLinkViewHelperTest extends ViewHelperBaseTestcase
{

    /**
     * @var CategorySearchLinkViewHelper
     */
    protected $viewHelper;

    /**
     * @var FilterRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $filterRepository;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->viewHelper = $this->getAccessibleMock(
            'Pws\KesearchCategories\ViewHelpers\Link\CategorySearchLinkViewHelper',
            array('renderChildren')
        );
        $this->filterRepository = $this->getMock(
            'Pws\KesearchCategories\Domain\Repository\FilterRepository',
            array('findOneByCategories'),
            array(),
            '',
            false
        );
        $this->inject($this->viewHelper, 'filterRepository', $this->filterRepository);

        $this->injectDependenciesIntoViewHelper($this->viewHelper);
        $this->viewHelper->initializeArguments();
    }

    /**
     * @dataProvider linkDataProvider
     * @test
     * @param \PHPUnit_Framework_MockObject_MockObject $categoryMock
     * @param \PHPUnit_Framework_MockObject_MockObject $filterMock
     * @param $type
     * @param $expected
     */
    public function testGetFilterByCategory(
        \PHPUnit_Framework_MockObject_MockObject $categoryMock,
        \PHPUnit_Framework_MockObject_MockObject $filterMock,
        $type,
        $expected
    ) {
        $filterMock->method('isMultiSelectFilter')->willReturn($type);

        $this->filterRepository->expects($this->once())
            ->method('findOneByCategories')
            ->with($categoryMock)
            ->willReturn($filterMock);

        $this->viewHelper->render(1, array(), 0, false, false, '', false, false, false, array(), null,
            $categoryMock);

        $this->assertSame($expected, $this->viewHelper->getAdditionalParams());
    }

    /**
     * @test
     */
    public function testViewHelperExtendsFromPageLinkViewHelper()
    {
        $this->assertInstanceOf('TYPO3\CMS\Fluid\ViewHelpers\Link\PageViewHelper', $this->viewHelper);
    }

    /**
     * @return array
     */
    public function linkDataProvider()
    {
        $categoryMock = $this->getMock(
            'Pws\KesearchCategories\Domain\Model\Category',
            array('getUid', 'getFilterOptionTag')
        );

        $categoryMock->expects($this->any())->method('getUid')->willReturn(1);
        $categoryMock->expects($this->any())->method('getFilterOptionTag')->willReturn('1test');

        $filterMock = $this->getMock(
            'Pws\KesearchCategories\Domain\Model\Filter',
            array('getUid', 'isMultiSelectFilter')
        );

        $filterMock->expects($this->any())->method('getUid')->willReturn(3);

        return array(
            array(
                $categoryMock,
                $filterMock,
                false,
                array(
                    'tx_kesearch_pi1' => array(
                        'filter' => array(
                            '3' => '1test'
                        )
                    )
                ),
            ),
            array(
                $categoryMock,
                clone $filterMock,
                true,
                array(
                    'tx_kesearch_pi1' => array(
                        'filter' => array(
                            '3' => array(
                                '1' => '1test'
                            )
                        )
                    )
                ),
            )
        );
    }
}
