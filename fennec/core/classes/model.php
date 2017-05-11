<?php
    class model{
        public $model;
        function __construct() {
            $this->model = new database();
            $this->model->connect($GLOBALS["config"]["database"]["host"], $GLOBALS["config"]["database"]["username"],
                    $GLOBALS["config"]["database"]["password"], $GLOBALS["config"]["database"]["name"]);
        }
    }
?>