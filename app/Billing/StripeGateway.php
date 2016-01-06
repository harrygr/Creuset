<?php 

namespace Creuset\Billing;

use Stripe\Charge;
use Stripe\Stripe;

class StripeGateway implements GatewayInterface {

    function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge(array $data)
    {
        try {
            return Charge::create([
                                  'amount' => $data['amount'],
                                  'currency' => 'GBP',
                                  'description' => $data['description'],
                                  'card' => $data['card'],
                                  ]);
        } catch(\Stripe\Error\Card $e) {
            throw new CardException($e->getMessage());
        } catch(\Stripe\Error\Base $e) {
            throw new \Exception($e->getMessage());
        }
    }
}