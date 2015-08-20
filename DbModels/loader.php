<?php

//autoloader function
function DbModels_Classes_Autoloader($className) {

    //continue with only Theme classes
    if (strstr($className, 'DbModels') === false)
        return;

    //remove Theme_
    $className = str_replace('DbModels\\', '', $className);
    $className = (str_replace('\\', '/', $className));

    $filePath = $className;

    include_once($filePath . '.php');
}

//register autoloader
spl_autoload_register('DbModels_Classes_Autoloader');

