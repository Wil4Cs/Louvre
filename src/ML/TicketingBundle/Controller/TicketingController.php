<?php

namespace ML\TicketingBundle\Controller;

use ML\TicketingBundle\Entity\Bill;
use ML\TicketingBundle\Form\BillType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function bookingAction(Request $request)
    {
        $bill = new Bill();
        $form = $this->createForm(BillType::class, $bill);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $tickets = $bill->getTickets();
            foreach ($tickets as $ticket) {
                $bill->addTicket($ticket);
            }

            $em->persist($bill);
            $em->flush();

            /*
            \Stripe\Stripe::setApiKey("sk_test_laQV9lGOvO3Up08xhDkxpr6e");

            // Get the credit card details submitted by the form
            $token = $_POST['stripeToken'];

            // Create a charge: this will charge the user's card
            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => 2000, // Amount in cents
                    "currency" => "eur",
                    "source" => $token,
                    "description" => "Paiement Stripe - Le Musée du Louvre"
                ));
                $this->addFlash("success","Bravo ça marche !");

            } catch(\Stripe\Error\Card $e) {

                $this->addFlash("error","Snif ça marche pas :(");
                // The card has been declined
            }
            */
            return $this->redirectToRoute('ml_ticketing_booking');
        }

        return $this->render('MLTicketingBundle:Ticketing:booking.html.twig', array(
            'form' => $form->createView()
        ));
    }
}