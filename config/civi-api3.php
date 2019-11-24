<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CiviCRM server path 
    |--------------------------------------------------------------------------
    |
    | Basically, the domain/server address of your CiviCRM installation.
    | 
    */

    'civi_host' => env('CIVI_HOST', 'http://example.com'),

    /*
    |--------------------------------------------------------------------------
    | CiviCRM integration.
    |--------------------------------------------------------------------------
    |
    | CiviCRM Integration. Can be wordpress, drupal or joomla.
    | Defaults to Wordpress... 
    |
    */

    'civi_integration' => env('CIVI_INTEGRATION', 'wordpress'),

    /*
    |--------------------------------------------------------------------------
    | Integration paths
    |--------------------------------------------------------------------------
    |
    | Lets you set the actual path to the api depending on the integration.
    | Those are defaults at this time, your mileage might vary, you can adjust 
    | them here.
    |
    */

    'civi_wordpress_path' => env('CIVI_WORDPRESS_PATH', '/wp-content/plugins/civicrm/civicrm/extern/rest.php'),
    'civi_drupal_path' => env('CIVI_DRUPAL_PATH', '/sites/all/modules/civicrm/extern/rest.php'),
    'civi_joomla_path' => env('CIVI_DRUPAL_PATH', '/administrator/components/com_civicrm/civicrm/extern/rest.php'),
    'civi_custom_path' => env( 'CIVI_CUSTOM_PATH', '/libraries/civicrm/extern/rest.php'),

    /*
    |--------------------------------------------------------------------------
    | Site Key
    |--------------------------------------------------------------------------
    |
    | This is the site key. It is defined in your civicrm.settings.php

        More info at http://wiki.civicrm.org/confluence/display/CRMDOC/Command-line+Script+Configuration
            if (!defined('CIVICRM_SITE_KEY')) {
                define( 'CIVICRM_SITE_KEY', '17f8752f266955cd55ed512b6ef66c71');
            }
    |
    */

    'civi_site_key' => env('CIVI_SITE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | User key... 
    |--------------------------------------------------------------------------
    |
    | This one is a little more complicated, this is the user key used for making
    | the api call. 
    */

    'civi_user_key' => env('CIVI_USER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | HTTP Request Header stuff.. 
    |--------------------------------------------------------------------------
    |
    | Many times you will find firewalls that block request where either or both 
    | user agent and referer are not set in the request header. We are polite and 
    | set our headers properly to say who we are. You should not use this in any way
    | at the other end to identify the source of the call as they are too easy to spoof.
    | 
    | Default values are usually fine... unless you need to spoof the referer.
    */

    'http_user_agent' => env('CIVI_USER_AGENT', 'laravel-civiapi3'),
    'http_referer' => env('CIVI_HTTP_REFERER', env('APP_URL'))
];
