<?php

namespace ML\TicketingBundle\Email;

use ML\TicketingBundle\Entity\Bill;

class BillMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;


    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmOrder(Bill $bill)
    {

        $message = (new \Swift_Message('Confirmation de réservation au musée du Louvre'))
            ->setTo($bill->getEmail())
            ->setFrom('noreply@louvre.com')
            ->setBody(
                $this->twig->render(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/notification.html.twig',
                    array('bill' => $bill)
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}