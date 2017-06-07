<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationConfirmationEmail
{

    /**
     * [$mailer description]
     * @var [type]
     */
    public $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  =Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->mailer->send('emails.confirm', $event->user, function ($message) use($event) {
            $message->subject('Confirm email')
                    ->to($event->user['email']);
        });
    }
}
