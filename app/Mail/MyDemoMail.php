<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\PDF;

class MyDemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment, $tenant;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Payment $payment, Tenant $tenant)
    {
        $this->payment = $payment;
        $this->tenant = $tenant;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
        {


                $pdf = app('dompdf.wrapper');
                $pdf->loadView('payment.mailtest', ['payment' => $this->payment, 'tenant' => $this->tenant]);

                    // ->attach(public_path('pdf/sample.pdf'), [

                    //      'as' => 'sample.pdf',

                    //      'mime' => 'application/pdf',

                    // ]);
            return $this->view('payment.mailtest', ['payment' => $this->payment, 'tenant' => $this->tenant])
                ->attachData($pdf->output(), 'receipt.pdf', [
                        'mime' => 'application/pdf',
                    ]);

    }

}
