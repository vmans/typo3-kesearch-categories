<?php

namespace Pws\KesearchCategories\Tests\Hooks;

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

use Pws\KesearchCategories\Hooks\FilterOptionHook;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class FilterOptionHookTest
 * @package Pws\KesearchCategories\Tests\Hooks
 */
class FilterOptionHookTest extends UnitTestCase
{

    /**
     * @var FilterOptionHook|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $fixture;


    /**
     * @test
     */
    public function testIfFilterIsEmpty()
    {
        $filters = array();
        $this->fixture->modifyFilters($filters, $this->getKesearchLib());
        $this->assertEmpty($filters);
    }

    /**
     * @test
     */
    public function testFilterKeepsUntouchedIfNoCategoryIsFound()
    {
        $filters = $expected = array(
            1 => array(
                'uid' => 2
            )
        );

        $this->fixture->expects($this->once())->method('getCategoriesByFilter')->with(2)->willReturn(false);
        $this->fixture->modifyFilters($filters, $this->getKesearchLib());
        $this->assertEquals($expected, $filters);

    }

    /**
     * @test
     */
    public function testCategoryAddedToFilter()
    {
        $categoryMock = $this->getMock(
            'Pws\KesearchCategories\Domain\Model\Category',
            array('getUid', 'getTitle'),
            array(),
            '',
            false
        );

        $categoryMock->expects($this->any())->method('getUid')->willReturn(5);
        $categoryMock->expects($this->any())->method('getTitle')->willReturn('title');


        $filters = array(
            1 => array(
                'uid' => 2
            )
        );

        $expected = array(
            1 => array(
                'uid' => 2,
                'options' => array(
                    5 => array(
                        'uid' => 5,
                        'title' => 'title',
                        'tag' => '5title'
                    )
                )
            )
        );

        $this->fixture->expects($this->once())->method('getCategoriesByFilter')->with(2)->willReturn(array($categoryMock));
        $this->fixture->modifyFilters($filters, $this->getKesearchLib());
        $this->assertEquals($expected, $filters);
    }

    /**
     * @return \tx_kesearch_filters
     */
    protected function getKesearchLib()
    {
        return new \tx_kesearch_filters();
    }

    protected function setUp()
    {
        $this->fixture = $this->getMock(
            'Pws\KesearchCategories\Hooks\FilterOptionHook',
            array('getCategoriesByFilter'),
            array(),
            '',
            false);
    }

}
