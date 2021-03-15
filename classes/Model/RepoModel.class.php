<?php
Namespace Model;
use Model\Model;
include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php"; 
class RepoModel extends Model
{
    public function _construct()
    {
        //Vi ansluter till databasen
        $this->db = new \DB();
        return $this;
    }
    protected function addRepos($id, $title, $link, $desc, $lang, $size, $updated)
    {
        $query = "INSERT INTO repos(Userlink, Title, Link, Description, Lang, Size, Updated) values (?, ?, ?, ?, ?, ?, ?)";
             //Vi köra en bindParam för varje ?.    
            $sth = $this->db->prepare($query);
            $sth->bindParam(1, $id);
            $sth->bindParam(2, $title);
            $sth->bindParam(3, $link);
            $sth->bindParam(4, $desc);
            $sth->bindParam(5, $lang);
            $sth->bindParam(6, $size);
            $sth->bindParam(7, $updated);
            //Om koden går igenom retunera resultatet.    
                if ($sth->execute())
                {
                    return $sth;
                }
                else
                {
                    //Annars skriv ut fel kod.
                    echo "<h4>Error</h4>";
                    echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
                }
    }
    protected function checkIfRepoExists($link)
    {
        $query = "SELECT * FROM repos where link=?";
        //Prepared statment
        $sth = $this->db->prepare($query);
        //Binder input.
        $sth->bindParam(1, $link, \PDO::PARAM_STR);
        //Error handling
            if ($sth->execute())
            {
                $row = $sth->fetch(\PDO::FETCH_ASSOC);
                //Om repon inte finns skicka tillbaka false.
                if ($row)
                {
                    return true;
                }
                else 
                {
                    return false;       
                }
            }
            else
            {
                //Annars skriv ut fel kod.
                echo "<h4>Error</h4>";
                echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
            }
    }
    protected function selectAllRepos($id)
    {
        //Vi säger att vi alla alla data från repos, och sedan datan från users där user.id är = med repo.userlink
        $query = "SELECT repos.id, repos.Title, repos.Link, repos.Description, repos.Lang, repos.Size, repos.Updated, users.username FROM repos
        LEFT JOIN users ON repos.UserLink = users.id
        WHERE users.id = ?
        ORDER BY repos.id";
            //Prepared statment
             $sth = $this->db->prepare($query);
            //Binder input.
            $sth->bindParam(1, $id, \PDO::PARAM_STR);
            //Säger att vi vill ha en associativ vektor.
            //Hämta all och retunera svaret. Om det är true vill säga-
                if ($sth->execute())
                {
                     //Säger att vi vill ha en associativ vektor.
                    $sth->setFetchMode(\PDO::FETCH_ASSOC);
                    //hämtar infromationen
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
                    //Annars om det inte fungerar göra detta.
                    echo "<h4>Error</h4>";
                    echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
                }
    }
}