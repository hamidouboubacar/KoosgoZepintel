<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\OffreService;

class OffreServiceMail extends Mailable
{
    use Queueable, SerializesModels;
    private $offreService;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OffreService $offreService)
    {
        $this->offreService = $offreService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('service@netorce.com')->view('offre_services.mail', ['offreService' => $this->offreService]);
    }
}
