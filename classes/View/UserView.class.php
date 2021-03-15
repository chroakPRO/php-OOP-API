<?php
//Sätter Namespace
Namespace View;
//Så vi kan använda UserModel
use Model\UserModel;
//Inkluderar min egen autoloader.
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class UserView extends View
{
    public function selectAllUsersOption()
    {
        //Initisierar usermodel klassen
        $model = new \Model\UserModel();
        //Varje varje användare i users skriv ut, en option tag.
        foreach ($model->selectAllUsers() as $result)
        {
            echo '<option value ="' . $result["id"] . '">' . $result
            ["username"] . '</option>';
        }
    }
}