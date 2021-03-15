<?php
Namespace Model;
use Model\Model;
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class FeedModel extends Model
{
    protected function _construct()
    {
        //Vi ansluter till databasen
        $this->db = new \DB();
        return $this;
    }

    public function getRepoInfo($id)
    {
        $query = "SELECT Title FROM repos WHERE id=?";
        //Prepared statment
        $sth = $this->db->prepare($query);
        //Binder parametrar.
        $sth->bindParam(1, $id); 
        //Fel hantering.
        if ($sth->execute())
        {
            $sth->setFetchMode(\PDO::FETCH_ASSOC);
            $results = $sth->fetchAll();
            //Om det inte finns någon information att visa, skicka dom tillbaka till index.php

            if ($results)
            {
                return $results;
            }
            else 
            {
                header ("Location: ../../../../Index.php?error=reponotfound");
                exit();      
            }
        }
        else
        {
            //Annars skriv ut fel kod.
            echo "<h4>Error</h4>";
            echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
        }
    }

    public function addFeedback($id, $feedback)
    {
        //Jag sloppade att använda en array för query, det var för många delar som behövde ändras för att det skulle fungera.
        $query = "INSERT INTO feedback(Repo, Feedback) VALUES (?, ?)";
        //Prepared statements
        $sth = $this->db->prepare($query);
        //Binder input till query.
        $sth->bindParam(1, $id);
        $sth->bindParam(2, $feedback);
        //Om SQL frågan går igenom, retunera svaret.
        if ($sth->execute())
        {
            return $sth;
        }
        else //Annars visa vad som gick fel. b
        {
            //Annars skriv ut fel kod.
            echo "<h4>Error</h4>";
            echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
        }
    }
    public function searchFeedbackUser($id)
    {
        //Hämta information, och länka feedback och repo samt Repos och users.
        $query = "SELECT repos.id, repos.Title, users.username, feedback.Feedback, repos.Link 
        FROM Feedback 
        LEFT JOIN repos on Feedback.Repo = repos.id 
        LEFT JOIN users on repos.Userlink = users.id 
        WHERE users.id = ?";
        //Prepared statement.
        $sth = $this->db->prepare($query);
        //Binder input till query.
        $sth->bindParam(1, $id);
        //Om SQL frågan går igenom, retunera svaret.
        if ($sth->execute())
        {
            //Hämta alla rader, och ge mig information via en associativ vektor.
            $sth->setFetchMode(\PDO::FETCH_ASSOC);
            $results = $sth->fetchAll();
            //Om det inte finns någon information att visa, skicka dom tillbaka till index.php
            if ($results)
            {
                return $results;
            }
            else 
            {
                header ("Location: ../../../../Index.php?error=usernotfound");
                exit();      
            }
        }
        else
        {
            //Annars skriv ut fel kod
            echo "<h4>Error</h4>";
            echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
        }
    }
    public function searchFeedbackTitle($title)
    {
        //Välj alla och ta in repos, där feedback repo är lika med repos id.
        //Samt för in users där repos userlink är like med users.id.
        //Hämta bara repo Title som liknar det användaren skrev in.
        $query = "SELECT repos.id, repos.Title, users.username, feedback.Feedback, repos.Link 
        FROM Feedback 
        LEFT JOIN repos on Feedback.Repo = repos.id 
        LEFT JOIN users on repos.Userlink = users.id 
        WHERE repos.Title like CONCAT ('%', ?, '%')";
        //prepared statment,
        $sth = $this->db->prepare($query);
        //Binder input till query.
        $sth->bindParam(1, $title);
        //Om SQL frågan går igenom, retunera svaret.
        if ($sth->execute())
        {
            //Hämta alla rader, och ge mig information via en associativ vektor.
            $sth->setFetchMode(\PDO::FETCH_ASSOC);
            $results = $sth->fetchAll();
            //Om det inte finns någon information att visa, skicka dom tillbaka till index.php
            if ($results)
            {
                return $results;
            }
            else 
            {
                header ("Location: ../../../../Index.php?error=titlenotfound");
                exit();      
            }
        }
        else
        {
            //Annars skriv ut fel kod.
            echo "<h4>Error</h4>";
            echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
        }
    }
}
