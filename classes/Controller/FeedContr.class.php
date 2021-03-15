<?php
Namespace Controller;
use Model\FeedModel;
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class FeedContr extends Controller
{
    public function __construct()
    {
        //Initiserar validations klassen för att kunna validera användare input.
        
        //Vi tittar eftersom post request add.
        if (isset($_GET['id']))
        {
            $validation = new \Validation();
            //Tar bort massor av olika karaktärer som kan skada vid sql injektion. 
            $this->user = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
            $this->title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);
            $validation->value($this->user)->filter('int')->isRequired();
            if (!$validation->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
                exit();
            }
            else
            {
                $this->contrDisplayRepo($this->user, $this->title);
            }
        }
        if (isset($_POST['feedback-submit']))
        {
            $validation2 = new \Validation();
            //Tvättar strängar som kommer in.
            $this->user = filter_input(INPUT_POST, 'feedback-option', FILTER_SANITIZE_STRING);
            $this->feedback = filter_input(INPUT_POST, 'feedback-text', FILTER_SANITIZE_STRING);
            //Kontrollerar strängerna.
            $validation2->value($this->feedback)->regex('feedback-text')->isRequired();
            $validation2->value($this->user)->filter('int')->isRequired();
            //Om den inte går ingeom kontrollen
            if (!$validation2->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
                exit();
            }
            else
            {   //Om det går igenom
                 $this->contrAddFeedback($this->user, $this->feedback);
            }
        }
        if (isset($_POST['search-submit-user']))
        {
            $validation3 = new \Validation();
            //Tvättar så att det bara är ett nummer.
            $this->user = filter_input(INPUT_POST, 'search-user', FILTER_SANITIZE_NUMBER_INT);
            //Kontrollerar att information som användaren har skickat är korrekt.
            $validation3->value($this->user)->filter('int')->isRequired();
           //Om det inte är korrekt skicka tillbaka dom till index.
            if (!$validation3->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
            }
           //Annars kalla control metoden med den kontrollerade inputen.
           else
           { 
           $this->contrSearchFeedbackUser($this->user);
           }
        }
                
        if (isset($_POST['search-submit-title']))
        {
            $validation3 = new \Validation();
            //Tvättar strängen
            $this->title = filter_input(INPUT_POST, 'search-title', FILTER_SANITIZE_STRING);
            //Kontrollerar att information som användaren har skickat är korrekt.
            $validation3->value($this->title)->regex('github-title')->isRequired();
           //Om det inte är korrekt skicka tillbaka dom till index.
            if (!$validation3->load())
            {
                header ("Location: ../../../../Index.php?error=invalidinput");
            }
           //Annars kalla control metoden med den kontrollerade inputen.
           else
           { 
           $this->contrSearchFeedbackTitle($this->title);
           }
        }
    }

    private function contrDisplayRepo($id, $title)
    {
        //Skickar vidare information till Feedback View  med information.
        //För att kunna visa informationen.
        $view = new \View\FeedView();
        $view->giveFeedback($id, $title);
    }
    //Dessa metoder skickar bara vidare till modelen.
    private function contrAddFeedback($user, $feedback)
    {
        $model = new \Model\FeedModel();
        $model->addFeedback($user, $feedback);
        header("Location: ../../../../Index.php?success=feedback");
        exit();
    }
    private function contrSearchFeedbackUser($id)
    {
        $view = new \View\FeedView();
        $view->viewSearchFeedbackUser($id);
    }
       private function contrSearchFeedbackTitle($title)
    {
        $view = new \View\FeedView();
        $view->viewSearchFeedbackTitle($title);
    }


    
}
$start = new FeedContr();