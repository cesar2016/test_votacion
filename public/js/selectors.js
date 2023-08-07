$( document ).ready(function() { 

    // Cargamos dinamicamente la vista dentro de la capa madre Content
    $('#showFormulario').load( 'Views/formulario.php') 

    // # Array para guardar Erorres del form
    var arr_errors = []
   
    $(document).on('submit','#form_voto',function(e){

        e.preventDefault()
        
        // # funcion que inicia la VALIDACIONES
        var valid_form = validation( 
            $('#name_lastname'),
            $('#alias'),       
            $('#rut'),   
            $('#email'),       
            $('#region'),       
            $('#comuna'),       
            $('#candidato'),             
        )

        if (valid_form.length > 1){            
            return arr_errors = []
        }else{

            // # Limpiamos todos mensajes de avisos de Error en el form
            $('#name_error').empty()
            $('#alias_error').empty()
            $('#rut_error').empty()
            $('#email_error').empty()
            $('#region_error').empty()
            $('#comuna_error').empty()
            $('#candidato_error').empty()
            $('#medio').empty()

            arr_errors = []
        }

        // # Serializacion de los datos del Form
        dates_form = $(this).serialize() 
        //console.log(dates_form) 
        

        // # Query para envio del Form
        $.ajax({
            type: "POST",
            url: 'http://localhost/desis/listates/insertvoto',      
            data:  dates_form,       
            dataType: "JSON",
            }).done(function(data) { 


                //console.log(data)
                // # Implementacion de la Libreria SwitAlert2 para los avisos 
                if(data.msg1 == 1){

                    Swal.fire({
                        icon: 'error',
                        title: 'Ups...!',
                        text: data.msg2                         
                      })

                    
                }else{

                    Swal.fire(
                        'Good!!!',
                        data.msg2,
                        'success'
                    )
                    
                }
                

            }).fail(function(jqXHR) {

                console.log('Error: ',jqXHR.statusText);
        });
         
    })    

    ///// FUNCION VALIDADORA DE INPUTS ///////////////////
    function validation(name_lastname, alias, rut, email, region, comuna, candidato){                    

        // # NAME VALID
        if( name_lastname.val().length < 5){

            $(name_lastname.val() ).addClass('is-invalid');
            $('#name_error').html('Debe ingresar un Nombre de al menos 5 caracteres')
            arr_errors.push(1)
            
        }

        var patron = /^[a-zA-Zñ ]+$/;

        if( name_lastname.val().length > 4){
            if (patron.test(name_lastname.val())) {
                $(name_lastname.val() ).removeClass('is-invalid');                
            } else {
                $(name_lastname.val() ).addClass('is-invalid');
                $('#name_error').html('Debe ingresar solo Letras')  
                arr_errors.push(1)

            }    
        }

        // # ALIAS VALID
        if( alias.val().length < 5){

            $(alias.val() ).addClass('is-invalid');
            $('#alias_error').html('Debe ingresar un Alias de al menos 5 caracteres')
            arr_errors.push(2)
            
        }


        // VALIDATE RUT Eje: 12.345.678-9
        // Valida que el número de documento tenga 11 dígitos. 
        if (rut.val().length !== 12) {
            $(rut.val() ).addClass('is-invalid');
            $('#rut_error').html('El RUT debe contener 12 digitos')
            arr_errors.push(3)
        }

        // Valida que el primer dígito sea un número entre 1 y 9.
        if (rut.val()[0] < 1 || rut.val()[0] > 9 && rut.val()[1] < 1 || rut.val()[1] > 9 ) {
            $(rut.val() ).addClass('is-invalid');
            $('#rut_error').html('Los dos primeros digitos deben ser numericos')
            arr_errors.push(3)
        }

        // Validamos lo punhtos
        if (rut.val()[2] !== '.' || rut.val()[6] !== '.'  ) {
            $(rut.val() ).addClass('is-invalid');
            $('#rut_error').html('El tercer y septimo carancter deben ser un punto')
            arr_errors.push(3)
        }

        // Validamos el gion 
        if (rut.val()[10] !== '-' ) {
            $(rut.val() ).addClass('is-invalid');
            $('#rut_error').html('El penultimo caracter debe ser un gion medio')
            arr_errors.push(3)
        }

        // Validamos el gion 
        var numeroEntero = rut.val().replace(/\./g, "").replace(/-/g, "")

        for (let i = 0; i < numeroEntero.length; i++) {            
             
                if (isNaN(numeroEntero[i])) {
                  
                $(rut.val() ).addClass('is-invalid');
                $('#rut_error').html('hay caracteres extraños en el valor insertado')
                arr_errors.push(3)
            }
            
        }

        // # Validar Email
        if(email.val().indexOf('@', 0) == -1 || $(email).val().indexOf('.', 0) == -1) {             
            $(email.val() ).addClass('is-invalid');
            $('#email_error').html('El formato de email no valido')
            arr_errors.push(4)
        }

        if(region.val() < 1 ) {
            $(region.val() ).addClass('is-invalid');
            $('#region_error').html('Debe eligir una Region')
            arr_errors.push(5)
                 
        }

        // # Validar Comuna
        if(comuna.val() < 1 ) {
            $(comuna.val() ).addClass('is-invalid');
            $('#comuna_error').html('Debe eligir una Comuna')
            arr_errors.push(6)
                 
        }

        // # Validar Candidato
        if(candidato.val() < 1 ) {
            $(candidato.val() ).addClass('is-invalid');
            $('#candidato_error').html('Debe eligir una Candidato')
            arr_errors.push(7)
                 
        } 
         
        return arr_errors;

    }
    //// END/ FUNCION VALIDADORA DE INPUTS ///////////////////
    
     
    // # Buscamos COMUNAS relacionadas al ID que nos arroja el selec de REGIONES
    $(document).on('change','#region',function(e){
        
        var id_region = $(this).val();
         
        $.ajax({
            type: "POST",
            url: 'http://localhost/desis/listates/findcomunas',
            data:   {id_region: id_region},
            dataType: "JSON",
            }).done(function(data) { 


                // Con los datos obtenidos de la busqueda, completamos el select de COMUNAS
                //console.log(data)                
                $("#comuna").html("<option value=''>Elija una comuna</option>");
                $.each(data, function(i, comuna) {
                    $("#comuna").append("<option value='" + comuna.id + "'>" + comuna.name_comuna + "</option>");
                });

            }).fail(function(jqXHR) {

                console.log('Error: ',jqXHR.statusText);
        });
    });

    // # Buscamos CANDIDATOS relacionadas al ID que nos arroja el selec de comunas
    $(document).on('change','#comuna',function(e){
        
        var id_comuna = $(this).val();
         
        $.ajax({
            type: "POST",
            url: 'http://localhost/desis/listates/findcandidatos',
            data:   {id_comuna: id_comuna},
            dataType: "JSON",
            }).done(function(data) { 


                // Con los datos obtenidos de la busqueda, completamos el select de COMUNAS
                //console.log(data)                
                $("#candidato").html("<option value=''>Elija un Candidato</option>");
                $.each(data, function(i, candidato) {
                    $("#candidato").append("<option value='" + candidato.id + "'>" + candidato.name_candidato + "</option>");
                });

            }).fail(function(jqXHR) {

                console.log('Error: ',jqXHR.statusText);
        });
    });

 
     
   // # Manejo de Inputs Selects, Validation 
   $(document).on('change','#region',function(e){
         
        const val_change_region = $(this).val();            
        handle_enab_comuna(val_change_region)    
        handle_enab_candidate(null)     
         
    });

    $(document).on('change','#comuna',function(e){
         
        const val_change__comuna = $(this).val();           
        handle_enab_candidate(val_change__comuna)
         
    });

    function handle_enab_comuna(val_change_region){

        if( val_change_region > 0){             
            $("#comuna").prop('disabled', false)
        }else{
            $("#comuna").prop('disabled', true)
        }
    }

    function handle_enab_candidate(val_change_region){
         

        if( val_change_region > 0){             
            $("#candidato").prop('disabled', false)
        }else{
            $("#candidato").prop('disabled', true)
        }        

         
    }

    // # Con esta Query Insertamos candidatos en la DB
    $(document).on('click','#btn-insert-candidates',function(e){        
         
        $.ajax({
            type: "GET",
            url: 'http://localhost/desis/listates/insercandidates',             
            dataType: "JSON",
            }).done(function(data) { 


                console.log(data)

            }).fail(function(jqXHR) {

                console.log('Error: ',jqXHR.statusText);
        });
    }); 
    
      

});  // # End/ Ready

 
