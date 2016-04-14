<?php

namespace App\Mailers;

use App\Order;
use App\User;

class OrderMailer extends Mailer
{
    /**
     * Send an order receipt to a customer.
     *
     * @param Order $order
     *
     * @return void
     */
    public function sendOrderConfirmationEmailFor(Order $order)
    {
        $subject = 'Your Order Receipt';
        $view = 'emails.orders.confirmation';

        $this->sendTo($order->customer, $subject, $view, ['order' => $order]);
    }

    /**
     * Send an order notification to each of the admins.
     *
     * @param Order $order
     *
     * @return void
     */
    public function sendAdminOrderNotificationFor(Order $order)
    {
        $subject = 'New Customer Order #'.$order->id;
        $view = 'emails.orders.admin_notification';

        $admins = User::shopAdmins()->get();

        foreach ($admins as $admin) {
            $this->sendTo($admin, $subject, $view, ['order' => $order]);
        }
    }
}
