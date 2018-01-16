<?php

namespace ML\TicketingBundle\StripeService;

use Symfony\Component\Config\Definition\Exception\Exception;

class MLStripeService
{
    public function validCharge($token, $amount)
    {
        if ($amount === 0) {
            return;
        }

        \Stripe\Stripe::setApiKey("sk_test_laQV9lGOvO3Up08xhDkxpr6e");

        // Create a charge: this will charge the user's card
        try {
            \Stripe\Charge::create(array(
                "amount" => ($amount * 100), // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - Le Musée du Louvre"
            ));
        } catch (\Stripe\Error\Card $e) {
            throw new Exception("Une erreur lors du paiement est survenue!".$e->getMessage());
        }
    }
}