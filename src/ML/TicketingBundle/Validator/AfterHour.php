<?php

namespace ML\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AfterHour extends Constraint
{
    public $message = "Vous ne pouvez commander un billet journée pour le jour même après 14h00.";

    public function validatedBy()
    {
        return "ml_ticketing_after_hour";
    }
}