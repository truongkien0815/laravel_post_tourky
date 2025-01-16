<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $config = [
            'transport' => 'smtp',
            'host' => setting_option('smtp-host'),
            'port' => setting_option('smtp-port'),
            'username' => setting_option('smtp-username'),
            'password' => setting_option('smtp-password'),
            'encryption' => setting_option('smtp-encryption'),
        ];
        
        $mail = Config::get('mail');
        $mail['mailers']['smtp'] = $config;
        
        Config::set('mail', $mail);
    }
}
