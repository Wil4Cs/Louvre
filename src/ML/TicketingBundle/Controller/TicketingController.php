<?php

namespace ML\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketingController extends Controller
{
    public function indexAction()
    {
        return $this->render('MLTicketingBundle:Ticketing:index.html.twig');
    }

    public function scheduleAction()
    {
        return $this->render('MLTicketingBundle:Ticketing:schedule.html.twig');
    }

    public function rateAction()
    {
        return $this->render('MLTicketingBundle:Ticketing:rate.html.twig');
    }

    public function bookingAction()
    {
        return $this->render('MLTicketingBundle:Ticketing:booking.html.twig');
    }
}