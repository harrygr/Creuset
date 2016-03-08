<?php

namespace App\Billing;

use Stripe\Charge;
use Stripe\Stripe;

class StripeGateway implements GatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function charge(array $data, array $meta = [])
    {
        try {
            return Charge::create([
                                  'amount'      => $data['amount'],
                                  'currency'    => config('shop.currency', 'GBP'),
                                  'description' => $data['description'],
                                  'card'        => $data['card'],
                                  'metadata'    => $meta,
                                  ]);
        } catch (\Stripe\Error\Card $e) {
            throw new CardException($e->getMessage());
        } catch (\Stripe\Error\Base $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
