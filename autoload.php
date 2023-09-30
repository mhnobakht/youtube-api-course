<?php

function classAutoloader($className) {

    

    $className = trim($className, '\\');
    $classNameArray = explode('\\', $className);
    $baseDir = __DIR__.DIRECTORY_SEPARATOR.$classNameArray[0].DIRECTORY_SEPARATOR;
    $className = $classNameArray[1];

    $filePath = $baseDir.$className.'.php';

    if(file_exists($filePath)) {
        include_once $filePath;
    }

}

spl_autoload_register("classAutoloader");