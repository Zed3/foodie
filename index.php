<?php
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

if (!is_readable('app/Core/Config.php')) {
    die('No Config.php found, configure and rename Config.example.php to Config.php in app/Core.');
}

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
    define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but production will hide them.
 */

if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            break;
        case 'production':
            error_reporting(0);
            break;
        default:
            exit('The application environment is not set correctly.');
    }

}

//initiate config
new Core\Config();

//create alias for Router
use Core\Router;
use Helpers\Hooks;

//define routes
Router::any('rest/(:num)', 'Controllers\Rests@rest');
Router::any('rests/(:num)', 'Controllers\Rests@rest');

Router::any('mail/test', 'Controllers\Mail@test');

Router::any('rests/update/(:num)', 'Controllers\Rests@update_restaurant');
Router::any('rests/update', 'Controllers\Rests@update_restaurant');

Router::any('rest/(:num)/delivery_report', 'Controllers\Rests@delivery_report');
Router::any('delivery/(:num)', 'Controllers\Rests@delivery_report');

Router::any('dishes/parse/(:num)', 'Controllers\Rests@parse');
Router::any('dishes/parse_all', 'Controllers\Rests@parse_all');

Router::any('search', 'Controllers\Rests@search_post');
Router::any('ping', 'Controllers\Rests@ping');

Router::any('login', 'Controllers\Auth@login');
Router::any('logout', 'Controllers\Auth@logout');

Router::any('user/dishes', 'Controllers\User@dishes');
Router::any('user/rand_dish', 'Controllers\User@rand_dish');

Router::any('favorite/(:num)/(:num)', 'Controllers\User@manage_favorite');
Router::any('favorite/(:num)', 'Controllers\User@manage_favorite');

Router::any('search/(:any)', 'Controllers\Rests@search');
Router::any('rests', 'Controllers\Rests@index');
Router::any('json/search', 'Controllers\Json@search');
Router::any('json/all_dishes', 'Controllers\Json@all_dishes');
Router::any('', 'Controllers\Welcome@index');

//module routes
$hooks = Hooks::get();
$hooks->run('routes');

//if no route found
Router::error('Core\Error@index');

//turn on old style routing
Router::$fallback = false;

//execute matched routes
Router::dispatch();