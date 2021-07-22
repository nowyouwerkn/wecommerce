<?php

namespace Nowyouwerkn\WeCommerce;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

use Nowyouwerkn\WeCommerce\Models\MailConfig;

class MailService extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   
        $mail = MailConfig::first();

        config(['mail.driver'=> $mail->mail_driver]);
        config(['mail.host'=>$mail->mail_host]);
        config(['mail.port'=>$mail->mail_port]);   
        config(['mail.username'=>$mail->mail_username]);
        config(['mail.password'=>$mail->mail_password]);
        config(['mail.encryption'=>$mail->mail_encryption]);
    }
}
