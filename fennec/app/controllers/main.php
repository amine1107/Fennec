<?php
    class main extends controller implements controllerInterface{
        
        function index(){
            load::view("main::index");
        }
        
        function handlebar(){
            $data["title"] = "Hello Handlebars";
            $data["options"] = array(
                "Option 1", "Option 2", "Option 3", "Option 4"
            );
            load::view("main/handlebar", $data);
        }
        
    }
?>