<?php
/* dblabb2.php
* extend PDO */
class DB extends PDO
{
  //Ansluter till databasen. 
  public function __construct($dbname = "github")
  {
    try 
    {
      parent::__construct("mysql:host=localhost;dbname=$dbname;charset=utf8","root", "");
    }   
    catch (Exception $e) 
    {
      echo "<pre>" . print_r($e, 1) . "</pre>";
    }
  }
}