<?php
Namespace Controller;
use Model\UserModel;


include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class UserContr extends Controller
{
   //Körs när classen blir initiserad
    public function __construct()
    {
        //Initiserar validations klassen för att kunna validera användare input.
        $validation = new \Validation();
        //Vi tittar eftersom post request add.
        if (isset($_POST['add']))
        {
            //Start bort massor av olika karaktärer som kan skada vid sql injektion. 
            $this->user = filter_input(INPUT_POST, 'add_user', FILTER_SANITIZE_STRING);
            $validation->value($this->user)->regex('github-user')->isRequired();
            //Om vaidation inte går ingeom, skicka vidare dom till 
            if (!$validation->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
                exit();
            }
            else{
            //Skickar via till kotnroller.
            $this->addUser($this->user);
            }
        }
    }
    //Kallar Model för att lägga till användaren
    private function addUser($user)
    {   
        //Skapar ett objekt.
        $model = new \Model\UserModel();
        //Säger att vi vil använda adduser query, med inserUser metoden.
        if ($model->checkIfUserExists($user))
        {
            header("Location: ../../index.php?error=usertaken");
            exit();
        }
        else 
        {
        //Vi väljer SQL query och kontaktar modelen.
        $model->sqlQuery('addUser')->insertUser($user);
        //Tar bort objektet.
        $model = null;
        //Skickar tillbaka dom till index.
        header("Location: ../../Index.php?success=adduser");
            exit();
        }
    }
    //Tittar om användaren finns
}
//Jag initiserar klassen så att den ska köras.
$start = new UserContr();