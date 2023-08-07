<?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/desis/controllers/ListatesController.php';

 // # Objeto de Regiones
 $ObjRegions = new ListatesController;
 $regions = $ObjRegions->allregions();
 
?>

<section> 

    <h1>Formulario Electoral 2023</h1>        
    <div class="container col-8 border border-primary rounded p-3 jumbotron">

        <form id="form_voto">            
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Nombre y Apellido</label>
                <div class="col-sm-10">
                    <input type="name_lastname" class="form-control form-control-lg" id="name_lastname" name="name_lastname"  placeholder="">
                    <small id="name_error" class="text-danger"></small>   
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Alias</label>
                <div class="col-sm-10">
                    <input type="alis" class="form-control form-control-lg" id="alias"  name="alias" placeholder="">
                    <small id="alias_error" class="text-danger"></small>   
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">RUT</label>
                <div class="col-sm-10">
                    <input type="rut" class="form-control form-control-lg" id="rut" name="rut" placeholder="">
                    <small id="rut_error" class="text-danger"></small>   

                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg" required>EmaIL</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="">
                    <small id="email_error" class="text-danger"></small>   

                </div>
            </div>

            
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Regio</label>
                <div class="col-sm-10">
                    <select class="form-control" id="region" name="region">
                        <option value="0"> Elija una Region</option>
                    <?php
                    foreach($regions as $region){ ?>                        
                        <option value="<?php echo $region['id'] ?>"><?php echo $region['name_region'] ?></option>
                    <?php } ?>
                         
                    </select>
                    <small id="region_error" class="text-danger"></small>   

                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Comuna</label>
                <div class="col-sm-10">
                <select class="form-control" id="comuna" name="comuna" disabled="true" >
                    <!-- <option value="0">Elija una Comuna</option> -->
                </select>
                <small id="comuna_error" class="text-danger"></small>   

                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Candidato</label>
                <div class="col-sm-10">
                    <select class="form-control" id="candidato" name="candidato" disabled="true" >
                        <!-- <option value="0">Elija su candidato preferido</option>  -->
                    </select>
                    <small id="candidato_error" class="text-danger"></small>   

                </div>
            </div>

            <!-- CheckBox -->
            <div class="row">
                <div class="col-3">
                Como se entero de nosotros
                </div>
                <div class="col-9">                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="medio" id="medio" value="web" checked>
                        <label class="form-check-label" for="medio">web</label>
                    </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="medio" id="medio" value="tv">
                        <label class="form-check-label" for="medio">TV</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="medio" id="medio" value="redes">
                        <label class="form-check-label" for="medio">Redes Sociales</label>
                    </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="medio" id="medio" value="amigo">
                        <label class="form-check-label" for="medio">amigo</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit" id="btnForm">Enviar</button>            
        </form>
        
    </div>

    <button type="button" class="btn btn-info mb-3 mt-5" id="btn-insert-candidates">
        <i class="fa fa-user-plus"></i> 
        Agregar candidatos Aleatorios
    </button>
     
</section>

 