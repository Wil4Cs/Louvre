<?php

namespace ML\TicketingBundle\ComputePrice;

use ML\TicketingBundle\Entity\Bill;
use ML\TicketingBundle\RecoverData\MLRecoverData;

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
        // Get the day of visit
        $visitDay = $bill->getVisitDay();
        // Recover required data to test
        $dataParameters = $this->dataTickets->recoverData();
        $data = $dataParameters->ticket;

        foreach ($bill->getTickets() as $ticket) {
            $birthday = $ticket->getBirthday();
            $reduction = $ticket->getReduction();

            // Find age of visitor according to the day of visit and define it into a number
            $interval = $birthday->diff($visitDay);
            $year = $interval->format('%y');

            // Sets the price according to age and the reduction
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