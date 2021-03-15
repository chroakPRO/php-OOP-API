<?php
//Klass autoloader, för att enkelt ladda alla klasser
spl_autoload_register('myAutoLoader');
function myAutoLoader ($className) {
    //Använder inbygga, env variables för att bestämma vart vi är, när vi anävnder require 'autoloader.inc.php'
    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    //Om vi är mappen includes eller classes, så tar vi två steg tillbaka för att hitta klasserna. 
    if (strpos($url, 'includes') !== false) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/classes/";
    }
      if (strpos($url, 'classes') !== false) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/classes/";
    }
    //Om vi är i includes, så antar den att vi är i root dir, och går direkt in classes.
    else {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/classes/";
    }
    //Vilken typ ext våra klass filer har efter deras namn "Person.class.php" så den kommer att ta alla filer med .class.php
    $ext = '.class.php';
//Vi gör det lite enkarel, eftersom spl_autoload_register, kräver 3 saker.
//1: Vart ligger din klass filer.
//2: variablen från metoden ($classname)
//3: Och vilken ext filerna har. 
    $fullpath = $path . $className . $ext;
    //Sen kräver vi fullpath en gång för att "starta" metoden autolaod.
    require_once $fullpath;
}