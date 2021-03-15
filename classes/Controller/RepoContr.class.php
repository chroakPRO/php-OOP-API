<?php
Namespace Controller;

use Exception;
use Model\RepoModel;

include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class RepoContr extends Controller
{
    public function __construct()
    {
        //Initiserar validations klassen för att kunna validera användare input.
        $validation = new \Validation();
        //Vi tittar eftersom post request add.
        if (isset($_POST['submit']))
        {

            //Tvättar så att det bara är ett nummer.
            $this->user = filter_input(INPUT_POST, 'add_repo', FILTER_SANITIZE_NUMBER_INT);
            //Kontrollerar att information som användaren har skickat är korrekt.
            $validation->value($this->user)->filter('int')->isRequired();
           //Om det inte är korrekt skicka tillbaka dom till index.
            if (!$validation->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
                exit();
            }
           //Annars kalla control metoden med den kontrollerade inputen.
           else
           { 
           //SKicka vidare till controller metod.
            $this->contrAddRepo($this->user);
           }
        }
        if (isset($_POST['submit-display']))
        {
            //Tvättar och kontrollerar.
            $this->user = filter_input(INPUT_POST, 'display_repo', FILTER_SANITIZE_NUMBER_INT);
            $validation->value($this->user)->filter('int')->isRequired();
           //Om det inte är korrekt skicka tillbaka dom till index.
            if (!$validation->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
                exit();
            }
           //Annars kalla control metoden med den kontrollerade inputen.
           else
           { 
            //Skickar vidare till controller metod.
            $this->contrDisplayRepo($this->user);
           }
        }
    }
    private function contrAddRepo($user)
    {  
        
        //Definierar ett fil namn på en variabel.
        $cache_json='cache.json';
        //Kallar på usermodel, så jag kan hämta användarnamnet bakom idet.
        $mm = new \Model\UserModel();
        //Hämtar användarnmanet med hjälp av id.
        $username = $mm->getUserInfo($user)[0]['username'];
        //Kallar på MainController
        $model = new \Model\RepoModel();
        //Första variablen skickar in id istället för användarnamn, så den länkas med tabellen users.
        $mc = new Controller();
        //Sätter upp strpos strings.
        $mystring = $mc->fetchRepos($username)[0]['message'];
        $needle = "API RATE limit exceeded";
        //Tittar om det finns ett Meddelande från api, som säger nej till mer calls.
        $pos = strpos($mystring, $needle);
        //Om meddelandet inte finns, gå vidare.
        //Går ingeom alla repos som användaren har och gör allt som ska göras och sedan skickar vi vidare information.
        //Om det finns mer än 1 repo gå vidare med koden.
        if (count($mc->fetchRepos($username)) > 0)
        {
           for ($i = 0; $i < count($mc->fetchRepos($username)); $i++)
            {
                //Tvättar och kontrollerar alla API delar, för att förhindra SQL injektion.
                $model = new \Model\RepoModel();
                $link = filter_var($mc->fetchRepos($username)[$i]['html_url'], FILTER_SANITIZE_STRING);
                //Tittar om repon redans finns.
                if ($model->checkIfRepoExists($link))
                {
                    //Vi gör inget, så skippar bara att lägga till den repon.
                    //Det är bra om 
                }
                else
                {
                //Hämtar all information från API, och tvättar den.
                $title = filter_var($mc->fetchRepos($username)[$i]['name'], FILTER_SANITIZE_STRING);
                $description = filter_var($mc->fetchRepos($username)[$i]['description'], FILTER_SANITIZE_STRING);
                $language = filter_var($mc->fetchRepos($username)[$i]['language'], FILTER_SANITIZE_STRING);
                $size = filter_var($mc->fetchRepos($username)[$i]['size'], FILTER_SANITIZE_NUMBER_INT);
                $updated = filter_var($mc->fetchRepos($username)[$i]['updated_at'], FILTER_SANITIZE_STRING);
                //Initiserar modeln för att kunna skicka vidare API information.
                $model = new \Model\RepoModel();
                //Första variablen skickar in id istället för användarnamn, så den länkas med tabellen users.
                $model->addRepos($user, $title, $link, $description, $language, $size, $updated);
                }
            }
            header("Location: ../../../../Index.php?success=reposubmit");
            //Tar bort cache filen 
            unlink($cache_json);
            exit();
        }
            else
            {
                header ("Location: ../../../../Index.php?error=norepo");
                //Tar borten filen.
                unlink($cache_json);
                exit();

            }
    }
    private function contrDisplayRepo($id)
    {
        //Vi använder controller för att ta emot input and tvätta den.
        //Vi Skickar sedan svaret vidare till view för att visa inputen.
        $view = new \View\RepoView();
        $view->displayUsersRepos($id);
    }

}
$start =  new RepoContr();