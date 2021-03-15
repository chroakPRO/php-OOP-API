<?php
Namespace View;
use Model\Model;
//Child klass för loan.
class View extends Model
{   
    //Här har vi en metod som visar olika meddelanden som skickas via GET.
    public function infoDisplay()
    {
         if (isset($_GET['error']))
         {
            if ($_GET["error"] == "usernotfound")
            {
                echo "<div class='h4 text-danger'>The user u wanted dosent exist, try adding it at the homescreen!</div>";
            }
             if ($_GET["error"] == "usertaken")
            {
                echo "<div class='h4 text-danger'>That user is already added.</div>";
            }
             if ($_GET["error"] == "invalidinput")
            { 
                 echo "<div class='h4 text-danger'>Your input contained invalid characters.</div>";
            }
            if ($_GET["error"] == "norepo")
            {
                 echo "<div class='h4 text-danger'>There are no repos under this name</div>";
            }
            if ($_GET["error"] == "noapicalls")
            {
                 echo "<div class='h4 text-danger'>There are no API Calls left, please wait until the clock hits XX:00</div>";
            }
        }
         
         if (isset($_GET['success']))
         {
             if ($_GET["success"] == "adduser")
            {
                echo "<div class='h4 text-success'>User Added!</div>";
            }
              if ($_GET["success"] == "reposubmit")
            {
                echo "<div class='h4 text-success'>Repos have been added! Check them out at Display Repos.</div>";
            }
              if ($_GET["success"] == "feedback")
            {
                echo "<div class='h4 text-success'>Feedback Added!</div>";
            }
        
         }
    }
}