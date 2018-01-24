<?php

namespace Tests\AppBundle\Service;

use ML\TicketingBundle\Entity\Ticket;
use ML\TicketingBundle\Entity\Bill;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ComputePriceTest extends KernelTestCase
{
    public function setUp()
    {
        $kernel = self::bootKernel();
        $this->service = $kernel->getContainer()->get('ml_ticketing.compute_price');
    }

    protected function createBill()
    {
        $bill = new Bill();
        $date = new \DateTime('31-01-2018');
        $bill->setVisitDay($date);
        $tickets = array(
            $ticket1 = $this->createTicket("31-08-1990", 0),
            $ticket2 = $this->createTicket("31-08-1990", 1),
            $ticket3 = $this->createTicket("01-01-1958", 0),
            $ticket4 = $this->createTicket("01-01-1958", 1),
            $ticket5 = $this->createTicket("01-01-2010", 0),
            $ticket6 = $this->createTicket("01-01-2015", 0)
        );
        foreach ($tickets as $tick) {
            $bill->addTicket($tick);
        }
        return $bill;
    }

    public function createTicket($date, $reduction)
    {
        $ticket = new Ticket();
        $birthday = new \DateTime($date);
        $ticket->setBirthday($birthday);
        $ticket->setReduction($reduction);
        return $ticket;
    }

    /** TEST */
    public function testGivePrice()
    {
        $bill = $this->createBill();
        $this->service->givePrice($bill);
        $price = $bill->getTotalPrice();
        $this->assertEquals(56, $price);
    }

}