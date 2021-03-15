<?php
namespace Controller;
use Model\Model;
//require '../../includes/autoloader.inc.php';
//Inkulderar loan.class så den går att hitta inuti detta dokument.
//Detta är control i MVC modeln.
//Så alla methoder som används inom metoder här kommer ifrån.
//Loan.class.php

include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class Controller extends Model
{
    //Index funktion som tar hand om user input.
    public function index()
    {
    }

    public function fetchRepos($username)
    {
        //Associativ array, som säger vilken request metod vi använder samt vilket språk vi använder för att kontaka med.
        $cache_json='cache.json';
        $opts = [
            'http' => [
                'metod' => 'GET',
                'header' => [
                    'User-Agent: PHP',
                    
                            ]
                     ]
                ];
        //Vi avnänder arrayn som vi har skapat sedan använder vi stream för att kontakta på det stättet.
        $context = stream_context_create($opts);
        //Om det inte cache.json finns, kontakat då Github API.
        if (!is_file($cache_json))
        {
           //Kontakar API med det valda användarnamnet.
        
            $content = file_get_contents("https://api.github.com/users/".$username."/repos", false, $context);
            if (!$content)
            {
                header ("Location: ../../../../Index.php?error=noapicalls");
                exit();
            }
            
            file_put_contents($cache_json, $content);
        }
        else 
        {
            //Finns filen hämta json data från filen istället.
            $content = file_get_contents($cache_json);
        }
        //Omvandlar data strukturen till PHP.
        $github_array = json_decode($content, true);
        return $github_array;
    }
}
//Jag kallar index funktionen, så koden startar,
$start = new Controller();
$start->index();