<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Werkn Application Configuration
    |--------------------------------------------------------------------------
    */
    // Conekta Keys
    'CONEKTA_PRIVATE_KEY' => env('CONEKTA_PRIVATE_KEY', 'key_3GXrHqbjeGouFgCrbVctyg'),
    'CONEKTA_PUBLIC_KEY' => env('CONEKTA_PUBLIC_KEY', 'key_KLbNxw3BS7yzd2NmwqNhWvQ'),
    'CONEKTA_SANDBOX_MODE' => env('CONEKTA_SANDBOX_MODE', 'true'),

    // OpenPay Keys
    'OPENPAY_MERCHANT_ID' => env('OPENPAY_MERCHANT_ID', '11'),
    'OPENPAY_PUBLIC_KEY' => env('OPENPAY_PUBLIC_KEY', '11'),
    'OPENPAY_SANDBOX_MODE' => env('OPENPAY_SANDBOX_MODE', 'true'),

    // Stripe Keys
    'STRIPE_PRIVATE_KEY' => env('STRIPE_PRIVATE_KEY', 'sk_test_51J2JE1BahV2wbB1NBhl3DBb8JMZvGGUTuS6Urnm5ZshhC7wj5Dk8QMmtsFIILaeKh2MGrDfvdIWF8McFRIuHwYuS00YuqRqSqu'),
    'STRIPE_PUBLIC_KEY' => env('STRIPE_PUBLIC_KEY', 'pk_test_51J2JE1BahV2wbB1NXiWU2jVcgXFQlYgM9rTnou1uwpeJTbvcPn4isDtnJqhHFdXMynHzTAQXUFwjA9rXay6r2gGJ00LWMNiSdP'),

    // Paypal Keys
    'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID', '11'),
    'PAYPAL_SECRET' => env('PAYPAL_SECRET', '11'),
    'PAYPAL_SETTINGS' => [
        /** 
         * Modalidad de pago
         *
         * Opciones disponibles son 'sandbox' o 'live'
         */
        'mode' => env('PAYPAL_MODE', 'sandbox'),

        // Especificar el tiempo máximo de conexión por petición (3000 = 3 segundos)
        'http.ConnectionTimeOut' => 3000,
       
        // Especificar si queremos o no guardar registros
        'log.LogEnabled' => true,
        
        // Ubicación de los registros 
        'log.FileName' => storage_path() . '/logs/paypal.log',
        
        /** 
         * Nivel de Registro
         *
         * Opciones disponibles: 'DEBUG', 'INFO', 'WARN' o 'ERROR'
         * 
         * Los registros son más explicitos en el nivel DEBUG y se reducen
         * conforme avanzas hasta el tipo ERROR. WARN o ERROR es el estado
         * recomendado para ambientes de producción.
         * 
         */
        'log.LogLevel' => 'DEBUG'
    ],

    // Facebook Keys
    'FACEBOOK_ACCESS_TOKEN' => env('FACEBOOK_ACCESS_TOKEN', 'TEST'),
    'FACEBOOK_PIXEL_ID' => env('FACEBOOK_PIXEL_ID', 'TEST'),

    // Mail Driver Links
    'MAIL_MAILER' => env('MAIL_MAILER', 'smtp'),
    'MAIL_HOST' => env('MAIL_HOST', 'smtp.postmarkapp.com'),
    'MAIL_PORT' => env('MAIL_PORT', '587'),
    'MAIL_USERNAME' => env('MAIL_USERNAME', 'TEST'),
    'MAIL_PASSWORD' => env('MAIL_PASSWORD', 'TEST'),
    'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION', 'tls'),

    // UPS Keys
    'UPS_ACCESS_KEY' => env('UPS_ACCESS_KEY', 'TEST'),
    'UPS_USER_ID' => env('UPS_USER_ID', 'TEST'),
    'UPS_PASSWORD' => env('UPS_PASSWORD', 'TEST'),
    'UPS_SHIPPER_NUMBER' => env('UPS_SHIPPER_NUMBER', 'TEST'),

    // Amazon Keys
    /* COMING SOON */

    // Ebay Keys
    /* COMING SOON */

    // Mercadolibre Keys
    /* COMING SOON */

];
