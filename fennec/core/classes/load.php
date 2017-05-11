<?php
    use Handlebars\Handlebars;
    class load{
        
        static function view($viewFile, $viewVars = array(), $handlebarView = null, $browserHandled = null){
            if(is_null($handlebarView)){
                $handlebarView = $GLOBALS["config"]["handlebars_enabled"];
            }
            if($handlebarView){
                if(is_null($browserHandled)){
                    $browserHandled = $GLOBALS["config"]["handlebars_browser_handled"];
                }
                if($browserHandled){
                    load::browserHandlebar($viewFile, $viewVars);
                }else{
                    load::handlebarView($viewFile, $viewVars);
                }
            }else{
                load::nativeView($viewFile, $viewVars);
            }
        }
        
        
        static function nativeView($viewFile, $viewVars = array()){
            extract($viewVars);
            $viewFileCheck = explode(".", $viewFile);
            if(!isset($viewFileCheck[1])){
                $viewFile .= ".php";
            }
            $viewFile = str_replace("::", "/", $viewFile);
            $filename = $GLOBALS["config"]["path"]["app"]."views/{$viewFile}";
            if(file_exists($filename)){
                require_once $filename;
            }else{
                die("Trying to Load Non Existing View");
            }
        }
        
        static function handlebarView($viewFile, $viewVars = array()){
            $viewFileCheck = explode(".", $viewFile);
            if(!isset($viewFileCheck[1])){
                $viewFile .= ".php";
            }
            $viewFile = str_replace("::", "/", $viewFile);
            $filename = $GLOBALS["config"]["path"]["app"]."views/{$viewFile}";
            if(file_exists($filename)){
                $engine = new Handlebars();
                echo $engine->render(file_get_contents($filename), $viewVars);
            }else{
                die("Trying to Load Non Existing Handlebar");
            }
        }
        
        static function browserHandlebar($viewFile, $viewVars = array()){
            $viewFileCheck = explode(".", $viewFile);
            if(!isset($viewFileCheck[1])){
                $viewFile .= ".php";
            }
            $viewFile = str_replace("::", "/", $viewFile);
            $filename = $GLOBALS["config"]["path"]["app"]."views/{$viewFile}";
            if(file_exists($filename)){
                echo "<!DOCTYPE html><html><head><title>Loading</title></head><body><h1>Loading...</h1><script src='https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js'></script><script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>"
                . "<script id='pageTemplate' type='text/x-handlebars-template'>".file_get_contents($filename)."</script><script>$(document).ready(function(){"
                        . "var source = $('#pageTemplate').html(); var template = Handlebars.compile(source); var context = ".  json_encode($viewVars)."; $('html').html(template(context)); });</script></body></html>";
            }else{
                die("Trying to Load Non Existing Handlebar");
            }
        }
        
    }
?>