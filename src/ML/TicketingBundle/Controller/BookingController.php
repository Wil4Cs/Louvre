<?php

namespace ML\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookingController extends Controller
{
    public function indexAction()
    {
        return $this->render('MLTicketingBundle:Booking:index.html.twig');
    }

}