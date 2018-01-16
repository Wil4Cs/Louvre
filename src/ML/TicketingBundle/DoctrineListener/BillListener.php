<?php

namespace ML\TicketingBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use ML\TicketingBundle\Email\BillMailer;
use ML\TicketingBundle\Entity\Bill;

class BillListener
{
    private $billMailer;

    public function __construct(BillMailer $billMailer)
    {
        $this->billMailer = $billMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Bill) {
            return;
        }

        $this->billMailer->sendConfirmOrder($entity);
    }
}