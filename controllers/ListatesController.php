<?php 
 require_once $_SERVER['DOCUMENT_ROOT'].'/desis/Models/Listates.php';
 



class ListatesController
{
     
    // Obj de las REGIONES
    public function allregions()
    {
       $Obj = new Listate;
       $regions = $Obj->getAllRegions();
       return $regions;
         
    }


    // # Obj de las COMUNAS
    public function allcomunas()
    {       
       $Obj = new Listate;
       $comunas = $Obj->getAllComunas();
       echo json_encode($comunas);
         
    }
    // # Busqueda de comunas por region
    public function findcomunas()
    {
        $id_region = $_POST['id_region'];
        $Obj = new Listate;
        $comunas = $Obj->findComunas($id_region);
        echo json_encode($comunas);
         
    }

    // # Busqueda de comunas por region
    public function findcandidatos()
    {
        $id_comuna = $_POST['id_comuna'];
        $Obj = new Listate;
        $comunas = $Obj->findCandidatos($id_comuna);
        echo json_encode($comunas);
         
    }

     
    // # INSERTAR VOTACION
    public function insertvoto()
    {        
        $Obj = new Listate;
        $insertVoto = $Obj->insertVoto($_POST); 
        echo json_encode($insertVoto) ;
         
    }



    // ***** INSERT DE CANDIDATOS ***** ///
    public function insercandidates()
    {
        $Obj = new Listate;
        $insertCandidates = $Obj->insertCandidates();
         
        echo json_encode($insertCandidates) ;
         
    }


     
    

     

    

    
}