<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orders;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->orders = $data;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    return $this->view('mails.invoice');
    }
}
