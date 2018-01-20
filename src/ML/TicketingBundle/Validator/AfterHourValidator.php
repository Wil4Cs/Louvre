<?php

namespace ML\TicketingBundle\Validator;

use ML\TicketingBundle\RecoverData\MLRecoverData;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AfterHourValidator extends ConstraintValidator
{
    /**
     * Contains an object with the closing time
     */
    private $recoverData;

    /**
     * Contains an object with the request
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack, MLRecoverData $recoverData)
    {
        $this->requestStack = $requestStack;
        $this->recoverData = $recoverData;
    }

    public function validate($value, Constraint $constraint)
    {
        // Convert date of today in french format & get the hour too
        $todayDay = date('d/m/Y');
        $todayHour = date('H:i:s');
        // Recover required data
        $data = $this->recoverData->recoverData();
        $closingTime = $data->closingTime;
        // Recover parameters posted with the form
        $request = $this->requestStack->getCurrentRequest();
        $form = $request->request->get('ml_ticketingbundle_bill');
        $visitDay = $form['visitDay'];

        // In case of order for today, check time & type of ticket (true means a daily ticket)
        if ($todayDay === $visitDay && $todayHour > $closingTime && $value === true) {

            $this->context->addViolation($constraint->message);
        }
    }
}