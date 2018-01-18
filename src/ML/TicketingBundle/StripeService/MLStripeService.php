<?php

namespace ML\TicketingBundle\StripeService;

use Symfony\Component\Config\Definition\Exception\Exception;

class MLStripeService
{
    public function validCharge($token, $amount)
    {
        // Stripe don't support free payment. So just exit service
        if ($amount === 0) {
            return true;
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
        } catch(\Stripe\Error\Card $e) {
            return false;
        } catch (\Stripe\Error\RateLimit $e) {
            return false;
        } catch (\Stripe\Error\InvalidRequest $e) {
            return false;
        } catch (\Stripe\Error\Authentication $e) {
            return false;
        } catch (\Stripe\Error\ApiConnection $e) {
            return false;
        } catch (\Stripe\Error\Base $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}