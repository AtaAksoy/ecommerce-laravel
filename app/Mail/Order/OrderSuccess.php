<?php

namespace App\Mail\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSuccess extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $customer,$order;
    public function __construct(\App\Models\Customer $customer, $order)
    {
        $this->customer = $customer;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contents = json_decode($this->order->content);
        return $this
        ->from(config('app.created_by_system_mail'))
        ->subject('Siparişiniz Alındı!'.config('app.title'))
        ->view('mails.order.ordersuccess', compact('contents'));
    }
}
