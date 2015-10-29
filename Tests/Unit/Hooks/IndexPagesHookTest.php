<?php
/**
 * Created by PhpStorm.
 * User: kpurrmann
 * Date: 29.10.15
 * Time: 14:09
 */

namespace Pws\KesearchCategories\Tests\Hooks;


use Pws\KesearchCategories\Domain\Model\Page;
use Pws\KesearchCategories\Hooks\IndexPagesHook;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class IndexPagesHookTest extends UnitTestCase
{

    /**
     * @var IndexPagesHook|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $fixture;


    /**
     * @dataProvider categoriesDataProvider
     */
    public function testCategoriesAddedAsTags($objectStorage)
    {

        $page = new Page();
        $tags = 'tag1';
        $content = 'content';
        $this->fixture->expects($this->once())->method('findPageRecord')->with(1)->willReturn($page);
        $this->fixture->expects($this->once())->method('getCategoriesByPage')->with($page)->willReturn($objectStorage);
        $this->fixture->modifyPagesIndexEntry(1, $content, $tags);
        $this->assertEquals('tag1,onetitle,secondtitle', $tags);
    }

    /**
     * @return array
     */
    public function categoriesDataProvider()
    {
        $category1 = $this->getMock('Pws\KesearchCategories\Domain\Model\Category', array(), array(), '', false);
        $category1->expects($this->once())->method('getFilterOptionTag')->willReturn('onetitle');
        $category2 = $this->getMock('Pws\KesearchCategories\Domain\Model\Category', array(), array(), '', false);
        $category2->expects($this->once())->method('getFilterOptionTag')->willReturn('secondtitle');

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($category1);
        $objectStorage->attach($category2);

        return array(
            array(
                $objectStorage
            )
        );
    }

    /**
     * Set up fixture mock
     */
    protected function setUp()
    {
        $this->fixture = $this->getMock(
            'Pws\KesearchCategories\Hooks\IndexPagesHook',
            array('findPageRecord', 'getCategoriesByPage', 'injectKeSearchExtensionConfig'),
            array(),
            '',
            false
        );
    }


}
