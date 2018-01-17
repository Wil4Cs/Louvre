<?php

namespace ML\TicketingBundle\ComputePrice;

use ML\TicketingBundle\Entity\Bill;

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

    public function givePrice(Bill $bill)
    {
        foreach ($bill->getTickets() as $ticket) {
            $birthday = $ticket->getBirthday();
            $visitDay = $bill->getVisitDay();
            $reduction = $ticket->getReduction();
            $data = $this->dataTickets->recoverData();

            // Find age of visitor and define it into a number
            $interval = $birthday->diff($visitDay);
            $year = $interval->format('%y');

            if ($year < $data->teenager->age) {
                $ticket->setPrice($data->baby->price);
            } elseif ($year < $data->normal->age) {
                $ticket->setPrice($data->teenager->price);
            } elseif ($year < $data->senior->age && $reduction == false) {
                $ticket->setPrice($data->normal->price);
            } else if ($reduction == false) {
                $ticket->setPrice($data->senior->price);
            } else {
                $ticket->setPrice($data->reduced->price);
            }
        }
    }
}