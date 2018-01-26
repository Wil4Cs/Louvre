<?php

namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecoverDataTest extends KernelTestCase
{
    public function setUp()
    {
        $kernel = self::bootKernel();
        $this->service = $kernel->getContainer()->get('ml_ticketing.recover_data');
    }

    /** TEST */
    public function testRecoverData()
    {
        $data = $this->service->recoverData();
        $day = $data->daysOff;
        $dates = $data->datesOff;
        $time = $data->closingTime;
        $this->assertEquals(["mardi", "dimanche"], $day);
        $this->assertEquals(["01/05", "01/11", "25/12"], $dates);
        $this->assertEquals("14:00:00", $time);
    }
}