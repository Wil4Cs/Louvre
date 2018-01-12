<?php

namespace ML\TicketingBundle\CalculPrice;

use Symfony\Component\Validator\Constraints\DateTime;

class MLCalculPrice
{
    public function givePrice($ticket, $bill)
    {
        $birthdate = $ticket->getBirthday();
        $visitDay = $bill->getVisitDay();
        $interval = $birthdate->diff($visitDay);
        $year = $interval->format('%y');
        $reduction = $ticket->getReduction();

        if ($year < 4) {
            return 0;
        } elseif ($year < 12) {
            return 8;
        } elseif ($year < 60 && $reduction == false) {
            return 16;
        } else if ($reduction == false) {
            return 12;
        } else {
            return 10;
        }
    }
}