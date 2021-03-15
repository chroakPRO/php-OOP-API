<?php
Namespace Model;

use Model\Model;

include_once $_SERVER['DOCUMENT_ROOT'] . "/includes/autoloader.inc.php";
class UserModel extends Model
{
    //Vi ansluter till databasen.
    protected function _construct()
    {
        $this->db = new \DB();
        return $this;
    }
    //Metod för att lägga in användare.
    //Kallas av kontroller.
    protected function insertUser($user)
    {
       //Väljer vileken SQL query vi ska använda 
        $query = $this->sqlqueries[$this->sqli];
        //Prepared statment
            $sth = $this->db->prepare($query);
            //Binder input.
            $sth->bindParam(1, $user, \PDO::PARAM_STR);
            //Om input går igenom retunera resultet.
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
    //Denna kallas senare av controller
    protected function checkIfUserExists($id)
    {
        $query = "SELECT * FROM users WHERE username=?";
            //Prepared statment
            $sth = $this->db->prepare($query);
            //Binder input.
            $sth->bindParam(1, $id, \PDO::PARAM_STR);
            //Error handling
                if ($sth->execute())
                {
                    $row = $sth->fetch(\PDO::FETCH_ASSOC);
                    //Om det inte finns någon information att visa, skicka dom tillbaka true eller false, används för att man enkelt kan använda checkifUserExist i ett if statement,
                    if ( ! $row)
                    {
                        return false;
                    }
                    else 
                    {
                        return true;       
                    }
                }
                else
                {
                    //Annars skriv ut fel kod.
                    echo "<h4>Error</h4>";
                    echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
                }
    }
    //Metod för att välja användare
    //Den kallas av view
    protected function selectAllUsers()
    {
        //Väljer vilken SQL som ska användas.
        //$query = $this->sqlqueries[$this->sqli];
        $query = "SELECT id, username FROM users ORDER BY username ASC";
        //Frågar databasen.
            $sth = $this->db->query($query);
            //Säger att vi vill ha en associativ vektor.
            $sth->setFetchMode(\PDO::FETCH_ASSOC);
            //Hämta all och retunera svaret. Om det är true vill säga-
                if ($results = $sth->fetchAll())
                {
                        return $results;
                }
                else
                {
                    //Annars om det inte fungerar göra detta.
                    echo "<h4>Error</h4>";
                    echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
                }
    }
    public function getUserInfo($id)
    {
        $query = "SELECT username FROM users WHERE id=?";
            //Prepared statment
            $sth = $this->db->prepare($query);
            $sth->bindParam(1, $id); 
            //Error handling
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
                        header ("Location: ../../../../Index.php?error=usernotfound");
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



