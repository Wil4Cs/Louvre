<?php

namespace ML\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UnavailableDate extends Constraint
{
    public $message = "Impossible de commander un billet pour ce jour ou cette date, ni après 14h pour le jour même!";

    public function validatedBy()
    {
        return 'ml_ticketing_unavailable_date';
    }
}