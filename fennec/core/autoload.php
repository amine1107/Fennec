<?php
    spl_autoload_register(function($class){
        $cacheFile = $GLOBALS["config"]["path"]["cache"]."classloc.cache";
        if($GLOBALS["config"]["cache_enabled"] && file_exists($cacheFile)){
            $locations = unserialize(file_get_contents($cacheFile));
        }else{
            $locations = array();
        }
        if(isset($locations[$class])){
            $instantiable = $locations[$class]["instantiable"];
            $classFile = $locations[$class]["classFile"];
        }else{
            $corePath = $GLOBALS["config"]["path"]["core"];
            $appPath = $GLOBALS["config"]["path"]["app"];
            if(file_exists("{$corePath}abstracts/{$class}.php")){
                $instantiable = false;
                $isAutoloader = false;
                $classFile = "{$corePath}abstracts/{$class}.php";
            }else if(file_exists("{$corePath}classes/{$class}.php")){
                $instantiable = true;
                $isAutoloader = false;
                $classFile = "{$corePath}classes/{$class}.php";
            }else if(file_exists("{$corePath}interfaces/{$class}.php")){
                $instantiable = false;
                $isAutoloader = false;
                $classFile = "{$corePath}interfaces/{$class}.php";
            }else if(file_exists("{$appPath}controllers/{$class}.php")){
                $instantiable = true;
                $isAutoloader = false;
                $classFile = "{$appPath}controllers/{$class}.php";
            }else if(file_exists("{$appPath}libs/{$class}.php")){
                $instantiable = true;
                $isAutoloader = false;
                $classFile = "{$appPath}libs/{$class}.php";
            }else if(file_exists("{$appPath}models/{$class}.php")){
                $instantiable = true;
                $isAutoloader = false;
                $classFile = "{$appPath}models/{$class}.php";
            }else if(file_exists("{$appPath}interfaces/{$class}.php")){
                $instantiable = false;
                $isAutoloader = false;
                $classFile = "{$appPath}interfaces/{$class}.php";
            }else if(file_exists("{$appPath}abstracts/{$class}.php")){
                $instantiable = false;
                $isAutoloader = false;
                $classFile = "{$appPath}abstracts/{$class}.php";
            }else{
                $class = str_replace("\\", "/", $class);
                $parts = explode("/", $class);
                foreach($parts as $part){
                    $className = $part;
                }
                if(file_exists("{$corePath}3rd_party/$className.php")){
                    $classFile = "{$corePath}3rd_party/$className.php";
                    $isAutoloader = false;
                    $instantiable = false;
                }else if(file_exists("{$corePath}3rd_party/$className/Autoload.php")){
                    $classFile = "{$corePath}3rd_party/$className/Autoload.php";
                    $isAutoloader = true;
                    $instantiable = false;
                }else if(file_exists("{$corePath}3rd_party/$className/$className.php")){
                    $classFile = "{$corePath}3rd_party/$className/$className.php";
                    $isAutoloader = false;
                    $instantiable = false;
                }else{
                    $classFile = "{$corePath}3rd_party/$class.php";
                    $isAutoloader = true;
                    $instantiable = false;
                }
            }
            if($GLOBALS["config"]["cache_enabled"]){
                $locations[$class] = array(
                    "instantiable" => $instantiable,
                    "isAutoloader" => $isAutoloader,
                    "classFile" => $classFile
                );
                file_put_contents($cacheFile, serialize($locations));
            }
            
        }
        if(isset($classFile)){
            if($isAutoloader){
                if(file_exists($classFile)){
                    require_once $classFile;
                }else{
                    require_once "{$corePath}3rd_party/$className/$class.php";
                }
            }else{
                require_once $classFile;
            }
            if($instantiable){
                foreach($GLOBALS["instances"] as $instance){
                    $instance->$class = new $class();
                }
            }
        }
    });
?>