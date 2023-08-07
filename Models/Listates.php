<?php

require_once 'NamesCandidates.php';
require_once 'DataBase.php'; 


class Listate {
    private $db;
    private $usuarios;         
    public $listanames;
 
    public function __construct(){
        
        // Instanciamosla clase dela conexion ala DB
        $c = new DataBase;
        $this->db = $c->conexion;
        $this->usuarios=array();
        
          
        // Instanciamos la clase que nos provee del listado de candidatos
        $names = new NamesCandidates;
        $this->listanames = $names;

    }


    // ##### Traemos todas las REGIONES
    public function getAllRegions(){ 

        $consulta=$this->db->query("SELECT * FROM regiones r WHERE 1 ORDER BY r.id ASC ");

        while($filas=$consulta->fetch_assoc()){
            $this->usuarios[]=$filas;
        }
        return $this->usuarios;
    }


    // ##### Querys de COMUNAS

    //# Obtenemos todas las COMUNAS
    public function getAllComunas(){ 

        $consulta=$this->db->query("SELECT * FROM comunas co WHERE 1 ORDER BY co.id ASC ");

        while($filas=$consulta->fetch_assoc()){
            $this->usuarios[]=$filas;
        }
        return $this->usuarios;
    }

    // # Busqueda de COMUNAS por REGION
    public function findComunas($id_region){ 

        $consulta=$this->db->query("SELECT * FROM comunas co WHERE id_region = $id_region ORDER BY co.id ASC ");

        while($filas=$consulta->fetch_assoc()){
            $this->usuarios[]=$filas;
        }
        return $this->usuarios;
    }

    // # Busqueda de CANDIDATOS por COMUNA
    public function findCandidatos($id_comuna){ 

        $consulta=$this->db->query("SELECT * FROM candidatos ca WHERE id_comuna = $id_comuna ORDER BY ca.id ASC ");

        while($filas=$consulta->fetch_assoc()){
            $this->usuarios[]=$filas;
        }
        return $this->usuarios;
    }


    // #***** INSERT VOTO ***///      
    public function insertVoto( $post ){  
         

        $find_rut=$this->db->query("SELECT * FROM `votos` WHERE rut = '$post[rut]' ");
        
         $my_rut = $find_rut->fetch_assoc();

         if($my_rut == false){

            $query = $this->db->query("INSERT INTO votos( name_lastname, alias, rut, email, candidato, medio) VALUES ( 
                        '$post[name_lastname]', '$post[alias]', '$post[rut]', '$post[email]','$post[candidato]', '$post[medio]'                       
                                     
                        )");
 

            if (!$query) { //No lo encontro = No Voto
                echo $this->db->error();
            }else{
                return ['msg2' => 'FELICITACIONES! Acaba de VOTAR con Exito! :)'];           
            }         

         }else{// Lo encontro = Ya voto

            return ['msg1'=> 1, 'msg2' => 'ATENCION!: Este RUT: '.$post['rut'].' ya voto'];
              
         };
        
         
         
    }
 
    // #***** INSERT Aleatorio de candidatos ***///
    public function insertCandidates(){ 

        $arr = [];
        for ($i=1; $i < 538; $i++) { 
            $arr[] = $i;
            
            $rand = rand(1, 179);

            $name = $this->listanames->getItems(); 
            $query = $this->db->query("INSERT INTO candidatos( id_comuna, name_candidato ) VALUES ( '$rand', '$name[$i]') ");
            
        }

        return $query;
         
    }


    

}
