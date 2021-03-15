<?php
//Sättername space, hämtar lite autoloader nav, header etc.
Namespace View;
//Använder detta eftersom RepoView extends till en klass utanför.
//Sin egen namespace.
use Model\RepoModel;
require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/Navigation/nav.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";

class RepoView extends View
{
    public function displayUsersRepos($id)
    {
        //INitiserar Repomodeln, föratt kunna hämta alla Repos.
        //Skriv sedan ut alla Repos via en tabell.
        $model = new \Model\RepoModel();
        echo '<main role="main" class="container position-relative" style="max-width: 1200px;">';
        echo '<body>';
        echo '<div class="table-responsive">';
        echo '<table class="table">';
        echo '<tr>';
        echo '<th scope="col">Username</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Lang</th>
            <th scope="col">Size</th>
            <th scope="col">Last Updated</th>
            <th scope="col">Link</th>
            <th scope="col">Give Feedback</th>';
            
            echo "</tr>";
            foreach($model->selectAllRepos($id) as $result)
            {
            echo '<tr><td>'.$result['username'].
            '</td><td>' . $result['Title'].
            '</td><td>' . $result['Description'].
            '</td><td>' . $result['Lang'].
            '</td><td>' . $result['Size'].
            '</td><td>' . $result['Updated'].
            '</td><td><a href="'. $result['Link'].'">Link</a></td>'.
            '</td><td><a href="/classes/Controller/FeedContr.class.php?id='. $result['id'].'&title='. $result['Title'].
            '">Give Feedback</a></td></tr>';
            }
        echo '</table>';
        echo '</div>';
        echo '</main>';
        echo "</body>";
    }
}