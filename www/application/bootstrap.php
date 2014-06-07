<?php

defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'ru_RU.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-RU');

/**
 * Set cookie salt
 */
Cookie::$salt = 'rИVИ5Є"6♀И!╧21◘54є618╪1636☺►☺6♣1Л165☺☺t☺☺65☺65♦6529◘4е☺3213☻1╧♦65♦♦♦♥1♥1♥1adas^&*(+|l/';
Cookie::$expiration = Date::MONTH;
// чтоб не стырили куки www.owasp.org/index.php/HttpOnly
Cookie::$httponly = true;


/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => 'http://'.$_SERVER['HTTP_HOST'].'/',
	'errors'  => true,
	'profile' => false,
	'caching' => false, // включать (3600) только на ПРОДАКШЕНЕ
    'index_file' => false,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
//Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    'super-cache'      => MODPATH.'super-cache',
    'cache'      => MODPATH.'cache',      // Caching with multiple backends
    'auth'       => MODPATH.'auth',       // Basic authentication
    'database'   => MODPATH.'database',   // Database access
    // 'image'      => MODPATH.'image',      // Image manipulation
    'orm'        => MODPATH.'orm',        // Object Relationship Mapping
    'email' => MODPATH.'email',
    'htmlpurifier' => MODPATH.'htmlpurifier',
    'captcha' => MODPATH.'captcha',
    'docxtemplate' => MODPATH.'docxtemplate',
    'transactional' => MODPATH.'transactional',
    'twitterapi' => MODPATH.'twitterapi',
    'phpexcel' => MODPATH.'phpexcel',
    'phpword' => MODPATH.'phpword',
    'aramba' => MODPATH.'aramba',
    'crontab-manager' => MODPATH.'crontab-manager',

	));

/*try
{
    $dir_writable = substr(sprintf('%o', fileperms(APPPATH.'cache/')), -4) == "0774" ? "true" : "false";

    if (!$dir_writable)
    {
        File::chmod_recursive(APPPATH.'cache/', 775);
        File::chmod_recursive(APPPATH.'download/', 775);
        File::chmod_recursive(APPPATH.'templates/', 775);
    }

}
catch (Exception $e)
{
    die('Поставьте права 775 на папки 1) '.APPPATH.'cache/'.' 2) '.APPPATH.'download/'.' 3) '.APPPATH.'templates/');
}*/



/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */


Route::set('download', 'download(/<path>)',
    array(
         'path' => '.+'
    ))
    ->defaults(array(
        'controller' => 'Media',
        'action'     => 'download',
   ));

Route::set('viewdoc', 'viewdoc(/<path>)',
    array(
         'path' => '.+'
    ))
    ->defaults(array(
        'controller' => 'Viewdoc',
        'action'     => 'temp_view',
   ));

Route::set('admin.other', 'admin/other(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Admin/Other',
        'controller' => 'Base',
        'action'     => 'Index'
    ));

Route::set('admin.createdocs', 'admin/createdocs(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Admin/Createdocs',
        'controller' => 'Index',
        'action'     => 'Index',
   ));

Route::set('admin.files', 'admin/files(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Admin/Files',
        'controller' => 'Index',
        'action'     => 'Index',
   ));

Route::set('apiv1', 'api(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Api',
        'controller' => 'V1',
    ));


Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'controller' => 'Index',
        'action'     => 'Index',
        'directory' => 'Admin'
    ));



Route::set('profile', 'profile(/<action>(/<id>))')
    ->defaults(array(
            'directory' => 'Profile',
            'controller' => 'Index',
            'action'     => 'Index'
    ));

Route::set('users', 'users(/<action>(/<id>))')
    ->defaults(array(
        'controller' => 'Users',
    ));

Route::set('main', '(<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'controller' => 'Index',
        'action'     => 'Index',
        'directory' => 'Main'
    ));



Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(null);

