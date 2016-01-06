<?php


namespace Creuset\Billing;

interface GatewayInterface
{
    public function charge(array $data);
}
