<?php
    class controller{
        
        function __construct() {
            $GLOBALS["instances"][] = &$this;
        }
        
    }
?>