<?php

spl_autoload_register(function ($className)
{
    $className = str_replace('\\', '/', $className);
        
    $baseDir = APP_ROOT;
    
    $subDirs = ['/model/classes', '', '/model/services'];
    
    foreach($subDirs as $subDir)
    {
        $filePath = $baseDir . $subDir . '/' . $className . '.php';
        
        if(file_exists($filePath))
        {
            include $filePath;
        }
    }
});