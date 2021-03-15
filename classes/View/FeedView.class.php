<?php
//Sätter Namespace
Namespace View;
//Så vi kan använda FeedModel
use Model\FeedModel;

//Inkluderar min egen autoloader.
require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/nav.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class FeedView extends View
{
    public function giveFeedback($id, $title)
    {
        //Vi sätter upp en form för att kunna posta feedback gällande en repo.
        //Vi tar emot två variabler här och det är bara id för repo och titeln som man ger feedback till.
        echo '<main role="main" class="container position-relative" style="max-width: 500px;">
        <body>
        <h4>Give Feedback!</h4>
        <!--Formulär för kategorier -->
            <form class="form-group" action="/classes/Controller/FeedContr.class.php" method="post">
            <select class="form-control" name="feedback-option">
                <option value="'.$id.'">'.$title.'</option>
            </select>
        <div class="form-group mb-4">
            <textarea class="form-control form-control-alternative" name="feedback-text" rows="4" cols="80" placeholder="Type feedback.."></textarea></div>
        <input class="form-control btn-dark mt-1" type="submit" name="feedback-submit" value="Submit">
        </form>';
    }
    public function viewSearchFeedbackUser($id)
    {
        //Vi instanisierar modelen för att kunna köra SQL
        //Presentera information via en tabell.
        $model = new \Model\FeedModel();
        echo '<main role="main" class="container position-relative" style="max-width: 1200px;">';
        echo '<body>';
        echo '<div class="table-responsive">';
        echo '<table class="table">';
        echo '<tr>';
        echo '<th scope="col">Username</th>
            <th scope="col">Title</th>
            <th scope="col">Feedback</th>
            <th scope="col">Link</th>
            <th scope="col">Give Feedback</th>';
            echo "</tr>";
            //För varje rad i databasen skriv ut, information nedan.
            foreach($model->searchFeedbackUser($id) as $result)
            {
                echo '<tr><td>'.$result['username'].
                '</td><td>' . $result['Title'].
                '</td><td>' . $result['Feedback'].
                '</td><td><a href="'. $result['Link'].'">Link</a></td>'.
                '</td><td><a href="/classes/Controller/FeedContr.class.php?id='. $result['id'].'&title='. $result['Title'].
                '">Give Feedback</a></td></tr>';
            }
        echo '</table>';
        echo '</div>';
        echo '</main>';
        echo "</body>";
    }
    public function viewSearchFeedbackTitle($id)
    {
        //Instansierar modelen för att kunna kör SQL.
        //Presntera sedan information.
        $model = new \Model\FeedModel();
?>
 <?php 
/*För varje feedback inlägg skriv ut denna Bootstrap 4 Card Body.
    Det vi hämtar från databasen är användarnamn från users, title och länk från /repos, och sen feedback från feeback.*/
   foreach($model->searchFeedbackTitle($id) as $result)
   {
    echo '<div class="container-fluid mt-100" style="max-width: 1200px;">
     <div class="row">
         <div class="col-md-12">
             <div class="card mb-4">
                 <div class="card-header">
                     <div class="media flex-wrap w-100 align-items-center"> 
                         <div class="media-body ml-3">Repo Owner: '. $model->searchFeedbackTitle($id)[0]['username'].' <a href="javascript:void(0)" data-abc="true"></a>
                             <div class="text-muted small">Repo Title: '.$model->searchFeedbackTitle($id)[0]['Title'].' </div>
                         </div>
                         <div class="text-muted small ml-3">
                             <div>Repo Link Below.</div>
                             <div><a href="'. $model->searchFeedbackTitle($id)[0]['Link'].'">'.$model->searchFeedbackTitle($id)[0]['Title'].'</a></div>
                         </div>
                     </div>
                 </div>
                 <div class="card-body">';
                    echo "<br>";
                    echo "<h6 class='text-dark p-0 text-center'>".$result['Feedback']."</h6>";
                    echo '</div>
                    <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
                    <div class="px-4 pt-3"></div>
                </div>
             </div>
         </div>
     </div>
 </div>';
   }
 }
}