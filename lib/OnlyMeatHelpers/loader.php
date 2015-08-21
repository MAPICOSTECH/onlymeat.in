<?php

//autoloader function
function OnlyMeatHelpers_Classes_Autoloader($className) {

    //continue with only Theme classes
    if (strstr($className, 'OnlyMeatHelpers') === false)
        return;
    
    //remove Theme_
    $className = str_replace('OnlyMeatHelpers\\', '', $className);
    $className = (str_replace('\\', '/', $className));
    
    $filePath =  $className;

    include_once($filePath . '.php'); 
}

//register autoloader
spl_autoload_register('OnlyMeatHelpers_Classes_Autoloader');

