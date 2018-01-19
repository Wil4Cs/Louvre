<?php

namespace ML\TicketingBundle\Validator;

use ML\TicketingBundle\RecoverData\MLRecoverData;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UnavailableDateValidator extends ConstraintValidator
{
    /**
     * Contains an object with days off and dates off
     */
    private $recoverData;

    public function __construct(MLRecoverData $recoverData)
    {
        $this->recoverData = $recoverData;
    }

    public function validate($value, Constraint $constraint)
    {
        // Convert the date contains in $value to the format day/month like 01/12 for 1st december
        $visitDate = $value->format('d/m');
        // Convert the date contains in $value to the format day/month/year (french format) like 01/12/2018 for 1st december 2018
        // Then recover the day in french string like "lundi" for "monday"
        $dateFormat = $value->format('d-m-Y');
        setlocale(LC_TIME, "fr_FR");
        $visitDay = strtolower(strftime("%A", strtotime($dateFormat)));
        // Recover required data to test
        $data = $this->recoverData->recoverData();
        $daysOff = $data->daysOff;
        $datesOff = $data->datesOff;

        if (in_array($visitDay, $daysOff ) || in_array($visitDate, $datesOff)) {

            $this->context->addViolation($constraint->message);//
        }
    }
}