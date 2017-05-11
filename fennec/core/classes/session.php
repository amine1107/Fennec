<?php
    class session{
        
        function __construct() {
            ini_set("session.save_handler", "files");
            ini_set("session.save_path", $GLOBALS["config"]["path"]["basePath"]."/".$GLOBALS["config"]["path"]["session"]);
            if(!isset($_SESSION)){
                session_start();
            }
            foreach($_COOKIE as $key => $value){
                if(!isset($_SESSION[$key])){
                    json_decode($value);
                    if(json_last_error() == JSON_ERROR_NONE){
                        $_SESSION[$key] = json_decode($value);
                    }else{
                        $_SESSION[$key] = $value;
                    }
                }
            }
        }
        
        static function check($key){
            if(is_array($key)){
                $set = true;
                foreach($key as $k){
                    if(!session::check($k)){
                        $set = false;
                    }
                }
                return $set;
            }else{
                $key = session::generateSessionKey($key);
                return isset($_SESSION[$key]);
            }
        }
        
        static function get($key){
            if(isset($_SESSION[session::generateSessionKey($key)])){
                return $_SESSION[session::generateSessionKey($key)];
            }else{
                return false;
            }
        }
        
        static function set($key, $value, $ttl = 0){
            $_SESSION[session::generateSessionKey($key)] = $value;
            if($ttl !== 0){
                if(is_object($value) || is_array($value)){
                    $value = json_encode($value);
                }
                setcookie(session::generateSessionKey($key), $value, (time() + $ttl), "/", $_SERVER["HTTP_HOST"]);
            }
        }
        
        static function kill($key){
            if(isset($_SESSION[session::generateSessionKey($key)])){
                unset($_SESSION[session::generateSessionKey($key)]);
            }
            if(isset($_COOKIE[session::generateSessionKey($key)])){
                setcookie(session::generateSessionKey($key), "", (time() - 5000), "/", $_SERVER["HTTP_HOST"]);
            }
        }
        
        static function endSession(){
            foreach($_SESSION as $key => $value){
                unset($_SESSION[$key]);
            }
            foreach($_COOKIE as $key => $value){
                setcookie($key, "", (time() - 5000), "/", $_SERVER["HTTP_HOST"]);
            }
            session_destroy();
        }
        
        
        static function generateSessionKey($key){
            $append = $GLOBALS["config"]["appName"];
            $version = $GLOBALS["config"]["version"];
            return md5($key.$append.$version);
        }
        
    }
?>