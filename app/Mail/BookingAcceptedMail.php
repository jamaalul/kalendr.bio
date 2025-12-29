<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;

class BookingAcceptedMail extends Mailable
{
    public function __construct(
        public Booking $booking
    ) {}

    public function build()
    {
        return $this
            ->subject('Your booking is confirmed')
            ->view('emails.booking-accepted');
    }
}
