<?php

namespace ML\TicketingBundle\RecoverData;

class MLRecoverData
{
    public function recoverData()
    {
        // Recover data contains in parameters.json and decode it
        $data = json_decode(file_get_contents(__DIR__ . '/../../../../web/data/parameters.json'));
        return $data;
    }
}