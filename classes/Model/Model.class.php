<?php

Namespace Model;
use DB;
//child class to DB.
class Model extends DB
{
   //Ansluter till databasen 
    public function __construct()
    {
        $this->db = new \DB();
        return $this;
    }

    //Här skriver man in sql kommand man vill köra, man kallar den via kontroll eller view innan man kallar metoden som kör koden.
    public $sqlqueries = array(

        'addUser' => "INSERT INTO users (username) VALUES (?)",
        'getAllUser' => "SELECT * FROM users ORDER BY username ASC",

    ); 
    //Metod som används för att säga vilken sqlquery i vektorn som man vill använda.
    public function sqlQuery($query)
    {
        $this->sqli = $query;
        return $this;
    }

    //Alla methoder som har get framför sig kommer att används av loanview classen, det är bara metoder som läser data.
    //Det är modeln av MVC, den kör SQL.
    //Här hämtas alla aktiva lån.
  
}