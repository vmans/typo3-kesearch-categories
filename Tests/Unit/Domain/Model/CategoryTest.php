<?php
namespace Pws\KesearchCategories\Tests\Domain\Model;

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

use Pws\KesearchCategories\Domain\Model\Category;
use Pws\KesearchCategories\Domain\Model\FilterOptionsInterface;
use TYPO3\CMS\Core\Tests\UnitTestCase;

class CategoryTest extends UnitTestCase
{

    /**
     * @var Category
     */
    protected $fixture;


    /**
     * @test
     */
    public function testIfCategoryImplementsInterface()
    {
        $this->assertInstanceOf('Pws\KesearchCategories\Domain\Model\FilterOptionsInterface', $this->fixture);
    }

    /**
     * @test
     */
    public function testGetFilterOptionTag()
    {
        $fixture = $this->getMock(
            'Pws\KesearchCategories\Domain\Model\Category',
            array('getUid', 'getTitle'),
            array(),
            '',
            false
        );
        $fixture->expects($this->once())->method('getUid')->willReturn(1);
        $fixture->expects($this->once())->method('getTitle')->willReturn('title');

        $this->assertEquals('1title', $fixture->getFilterOptionTag());
    }

    /**
     * @test
     */
    public function testGetFilterOptionTagRemovesSpecialChars()
    {
        $fixture = $this->getMock(
            'Pws\KesearchCategories\Domain\Model\Category',
            array('getUid', 'getTitle'),
            array(),
            '',
            false
        );
        $fixture->expects($this->once())->method('getUid')->willReturn(1);
        $fixture->expects($this->once())->method('getTitle')->willReturn('check-spécial-chars-äöüä without spaces');

        $this->assertEquals('1checkspcialcharswithoutspaces', $fixture->getFilterOptionTag());
    }

    /**
     * Set up fixture
     */
    protected function setUp()
    {
        $this->fixture = new Category();
    }

}
