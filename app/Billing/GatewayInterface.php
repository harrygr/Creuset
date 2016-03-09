<?php

namespace App\Billing;

interface GatewayInterface
{
    /**
     * Charge a card.
     *
     * @param array $data The attributes for the charge
     *
     * @return \Stripe\Charge
     */
    public function charge(array $data, array $meta = []);
}
