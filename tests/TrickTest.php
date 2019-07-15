<?php


namespace App\Tests;

use App\Controller\admin\AdminTrickController;
use App\Entity\Media;
use App\Entity\Trick;

use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{

    public function testCreateTrick()
    {
        $trick = new Media();
        $trick->setFile('http://test.fr');
        $this->assertEquals('http://test.fr', $trick->getFile());
    }

    public function testCreateTrick2()
    {
        $test = $this->getMockBuilder(AdminTrickController::class)
            ->setMethods('delete')
            ->getMock();
        $test->expects($this->once())->method('get');

    }
}
