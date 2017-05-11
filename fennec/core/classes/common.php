<?php
    class common{
        
        static function isLoggedIn(){
            $check = array("id", "username", "fname", "lname");
            return (session::check($check)) ? true : false;
        }
        
    }
?>