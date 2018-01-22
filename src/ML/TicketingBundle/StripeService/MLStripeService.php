<?php

namespace ML\TicketingBundle\StripeService;

use ML\TicketingBundle\Entity\Bill;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RequestStack;

class MLStripeService
{
    /**
     * Contains an object with the request
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function validCharge(Bill $bill)
    {
        $amount = $bill->getTotalPrice();
        $request = $this->requestStack->getCurrentRequest();

        // Recover the stripe token from the request
        $token = $request->request->get('stripeToken');

        // Stripe don't support free payment. So just exit service after setting the stripe token
        if ($amount === 0) {
            $bill->setStripeToken($token);
            return true;
        }

        \Stripe\Stripe::setApiKey('sk_test_laQV9lGOvO3Up08xhDkxpr6e');

        // Create a charge: this will charge the user's card
        try {
            \Stripe\Charge::create(array(
                "amount" => ($amount * 100), // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement Stripe - Le Musée du Louvre"
            ));
            // Set stripe token into Bill entity
            $bill->setStripeToken($token);
            return true;

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




