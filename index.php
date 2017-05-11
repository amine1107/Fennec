<?php
/**
Le Micro Framework a été créer par Aouane Mohamed Amine.
amineaouane1992@gmail.com

*/
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $GLOBALS["config"] = array(
        "appName" => "fennec",
        "version" => "0.0.1",
        "domain" => "localhost/fennec",
        "cache_enabled" => false,
        "handlebars_enabled" => true,
        "handlebars_browser_handled" => true,
        "path" => array(
            "app" => "app/",
            "cache" => "caches/",
            "core" => "core/",
            "session" => "app/sessions", //no trailing forwardslash for session
            "basePath" => "/localhost/fennec",
            "index" => "index.php"
        ),
        "defaults" => array(
            "controller" => "main",
            "method" => "index"
        ),
        "routes" => array(),
        "database" => array(
            "host" => "localhost",
            "username" => "root",
            "password" => "",
            "name" => "appr"
        ),
    );
    date_default_timezone_set("America/chicago");
    $GLOBALS["instances"] = array();
    require_once $GLOBALS["config"]["path"]["core"]."autoload.php";
    new router();
?>