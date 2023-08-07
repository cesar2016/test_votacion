<?php 
  
// Clase para conexion a la DB
class DataBase
{
 
    private $hostDB = 'localhost';
    private $userDB = 'root';
    private $passDB = '';
    private $nameDB = 'desis_form';  
     
     
    public function __construct()
    { 

        $servername = $this->hostDB;
        $username = $this->userDB;
        $password = $this->passDB;
        $database = $this->nameDB; 
        
        // COneexion creada
        $this->conexion = new mysqli($servername, $username, $password, $database);
         
         

    }
         
         
};