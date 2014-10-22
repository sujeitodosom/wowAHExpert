<?php

define('DS', DIRECTORY_SEPARATOR);
define('HOME', dirname(__FILE__));

require_once HOME . DS . 'utilities' . DS . 'toolbox.class.php';

Toolbox::setDBMultiEnvironment();

require_once HOME . DS . 'utilities' . DS . 'bootstrap.php';


function __autoload($class){
    if(file_exists(HOME . DS . 'utilities' . DS . strtolower($class) . '.php')){
        require_once HOME . DS . 'utilities' . DS . strtolower($class) . '.php';
    } elseif (file_exists(HOME . DS . 'models' . DS . strtolower($class) . '.php')) {
        require_once HOME . DS . 'models' . DS . strtolower($class) . '.php';
    } elseif (file_exists(HOME . DS . 'controllers' . DS . strtolower($class) . '.php')) {
        require_once HOME . DS . 'controllers' . DS . strtolower($class) . '.php';
    }
}

?>