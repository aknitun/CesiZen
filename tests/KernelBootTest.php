<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class KernelBootTest extends KernelTestCase
{
    public function testKernelBoots(): void
    {
        self::bootKernel();

        $this->assertTrue(self::getContainer()->has('router'));
    }
}