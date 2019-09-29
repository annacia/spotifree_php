<?php

function loadClassAC($class) {
    $a = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Action' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($a)){
        require_once($a);
    }
}
function loadClassController($class) {
    $a = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($a)){
        require_once($a);
    }
}
function loadClassDAL($class) {
    $a = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'DAL' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($a)){
        require_once($a);
    }
}
function loadClassModel($class) {
    $a = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($a)){
        require_once($a);
    }
}
function loadClassUtil($class) {
    $a = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Util' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($a)){
        require_once($a);
    }
}
 
spl_autoload_register('loadClassAC');
spl_autoload_register('loadClassController');
spl_autoload_register('loadClassDAL');
spl_autoload_register('loadClassModel');
spl_autoload_register('loadClassUtil');
