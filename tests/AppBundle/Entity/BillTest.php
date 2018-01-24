<?php

namespace Tests\AppBundle\Entity;

use ML\TicketingBundle\Entity\Bill;
use ML\TicketingBundle\Entity\Ticket;
use PHPUnit\Framework\TestCase;

class BillTest extends TestCase
{
    /** TEST */
    public function testCreateSerialNumber()
    {
        $bill = $this->createBillSerialNumber();
        $this->assertRegExp('/^MDL_+[a-zA-Z0-9]{13}$/', $bill->getSerialNumber());
    }

    /** TEST */
    public function testUniqueSerialNumber()
    {
        $bill1 = $this->createBillSerialNumber();
        $bill2 = $this->createBillSerialNumber();
        $bill3 = $this->createBillSerialNumber();
        $this->assertNotEquals($bill1, $bill2, $bill3);
    }

    protected function createBillSerialNumber()
    {
        $bill = new Bill();
        $bill->createSerialNumber();
        return $bill;
    }

    /** TEST */
    public function testAddTicket()
    {
        $bill = new Bill();
        $tickets = array(
            $ticket1 = $this->createTicket(),
            $ticket2 = $this->createTicket(),
            $ticket3 = $this->createTicket()
        );
        foreach ($tickets as $tick) {
            $bill->addTicket($tick);
        }
        $number = $bill->getTickets();
        $this->assertEquals(3, $number->count());
    }

    protected function createTicket()
    {
        $ticket = new Ticket();
        return $ticket;
    }

    /** TEST */
    public function testGetTotalPrice()
    {
        $bill = new Bill();
        $tickets = array(
            $ticket1 = $this->createTicketPrice(12),
            $ticket2 = $this->createTicketPrice(10),
            $ticket3 = $this->createTicketPrice(16)
        );
        foreach ($tickets as $tick) {
            $bill->addTicket($tick);
        }
        $total = $bill->getTotalPrice();
        $this->assertEquals(38, $total);
    }

    protected function createTicketPrice($price)
    {
        $ticket = new Ticket();
        $ticket->setPrice($price);
        return $ticket;
    }

}