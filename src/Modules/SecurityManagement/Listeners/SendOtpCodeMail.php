<?php

namespace Kirago\BusinessCore\Modules\SecurityManagement\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Kirago\BusinessCore\Modules\SecurityManagement\Events\OtpCodeGenerated;
use Kirago\BusinessCore\Modules\SecurityManagement\Mails\OtpCodeMail;

class SendOtpCodeMail
{


    /**
     * Handle the event.
     */
    public function handle(OtpCodeGenerated $event): void
    {
        try {
            $otp = $event->otp;

            $title = $event->title;

            $identifier = $otp->identifier; // relation morphTo : User, etc.

            if ($email = $identifier->email) {
                Mail::to($email)->send(new OtpCodeMail($otp, $title));
            }
        }catch (\Exception $exception){
            write_log("Listeners/SendOtpCodeMail",$exception);
        }
    }
}
