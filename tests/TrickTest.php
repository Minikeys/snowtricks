<?php

namespace App\Tests;

use App\Entity\Trick;

use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{

    public function testNameTrick()
    {
        $trick = new Trick();
        $trick->setName('test');
        $this->assertEquals('test', $trick->getName());
    }

    public function testPictureTrick()
    {
        $trick = new Trick();
        $trick->setPicture('test.jpg');
        $this->assertEquals('test.jpg', $trick->getPicture());
    }

}
