<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_order;
    public $customer_info;
    public $order_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer_order, $customer_info, $order_details)
    {
        
        $this->customer_order = $customer_order;
        $this->customer_info = $customer_info;
        $this->order_details = $order_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.confirmation');
    }
}
