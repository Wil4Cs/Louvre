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

            // Find quantity of tickets for a day
            $quantityByDay = $em->getRepository('MLTicketingBundle:Bill')->countTicketsByDay($bill->getVisitDay());

            // Check if maximum accommodation capacity is reached
            if ($quantityByDay > $this->getParameter('maxCapacity')) {
                $request->getSession()->getFlashBag()->add('full', 'Complet pour le '.$bill->getVisitDay()->format('d-m-Y'));

            } else {
                // Find and set the correct price for each ticket
                $this->get('ml_ticketing.compute_price')->givePrice($bill);

                // Check if something wrong happened during payment process
                if ($this->get('ml_ticketing.stripe_service')->validCharge($bill) === false) {
                    $request->getSession()->getFlashBag()->add('noValidCharge', 'Une erreur lors du paiement est survenue!');

                } else {
                    $em->persist($bill);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', 'Votre commande a bien été prise en compte.');
                }
            }
            return $this->redirectToRoute('ml_ticketing_booking');
        }

        return $this->render('MLTicketingBundle:Ticketing:booking.html.twig', array(
            'form' => $form->createView()
        ));
    }
}