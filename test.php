<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('DS', DIRECTORY_SEPARATOR);
define('HOME', dirname(__FILE__));

require_once HOME . DS . 'utilities' . DS . 'meekrodb.2.3.class.php';
require_once HOME . DS . 'utilities' . DS . 'toolbox.class.php';

Toolbox::setDBMultiEnvironment();



?>