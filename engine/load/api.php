<?php
/**
|==========================================================|
|========= @copyright Pyatinskii Mihail, 2013-2014 ========|
|================= @website: www.ffcms.ru =================|
|========= @license: GNU GPL V3, file: license.txt ========|
|==========================================================|
 */

// system are not installed or file is missed
if(!file_exists(root . "/config.php")) {
    if(loader !== 'install')
        exit();
} else {
    require_once(root . '/config.php');
}

\engine\property::getInstance()->init(); // processing of URI for multi-language and friendly url's
date_default_timezone_set(\engine\property::getInstance()->get('time_zone')); // default timezone from configs

\engine\language::getInstance()->init();
\engine\database::getInstance()->init(); // init database PDO connect
\engine\user::getInstance()->init();
\engine\router::getInstance()->init();

\engine\extension::getInstance()->init(); // init extension controller

\engine\template::getInstance()->init();

// check ip/user is fully blocked?
\engine\ban::getInstance()->init();
\engine\api::getInstance()->make(); // echo enteries