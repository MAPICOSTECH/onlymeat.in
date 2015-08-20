<?php

//autoloader function
function Helpers_Classes_Autoloader($className) {

    //continue with only Theme classes
    if (strstr($className, 'Helpers') === false)
        return;
    
    //remove Theme_
    $className = str_replace('Helpers\\', '', $className);
    $className = (str_replace('\\', '/', $className));
    
    $filePath =  $className;

    include_once($filePath . '.php'); 
}

//register autoloader
spl_autoload_register('Helpers_Classes_Autoloader');

