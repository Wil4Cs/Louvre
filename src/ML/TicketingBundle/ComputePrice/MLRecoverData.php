<?php

namespace ML\TicketingBundle\ComputePrice;

class MLRecoverData
{
    public function recoverData()
    {
        $data = json_decode(file_get_contents(__DIR__.'/../../../../web/data/parameters.json'));
        $dataTickets = $data->ticket;
        return $dataTickets;
    }
}