<?php

namespace ML\TicketingBundle\ComputePrice;

use ML\TicketingBundle\Entity\Bill;
use ML\TicketingBundle\Entity\Ticket;

class MLComputePrice
{
    /**
     * Contains an object with prices & age for each ticket
     */
    private $dataTickets;

    public function __construct(MLRecoverData $dataTickets)
    {
        $this->dataTickets = $dataTickets;
    }

    public function givePrice(Ticket $ticket, Bill $bill)
    {
        $birthday = $ticket->getBirthday();
        $visitDay = $bill->getVisitDay();
        // Find age of visitor and define it into a number
        $interval = $birthday->diff($visitDay);
        $year = $interval->format('%y');
        $reduction = $ticket->getReduction();
        $data = $this->dataTickets->recoverData();

        if ($year < $data->teenager->age) {
            return $data->baby->price;
        } elseif ($year < $data->normal->age) {
            return $data->teenager->price;
        } elseif ($year < $data->senior->age && $reduction == false) {
            return $data->normal->price;
        } else if ($reduction == false) {
            return $data->senior->price;
        } else {
            return $data->reduced->price;
        }
    }
}