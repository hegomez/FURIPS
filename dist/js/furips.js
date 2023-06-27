function GenerateFURIPS(){
    var error='';
    var errCUPS=[];
    var errTraslado='';
    //Se recorren los controles y se verifica que los requeridos no esten vacios
    $('.form-control').each(function(){
        var id=$(this).attr('id');
        id=id.replace('C_','');
         if($(this).attr('required') && $(this).val()==''){
            error+='El campo <strong>'+campos[id]+'</strong> es requerido<br>';
        }
    });
    //Verificaciones Opcionales
    //Verificar datos de Respuesta de Glosa
    if($("#RG").prop('checked')==true){
        error+=specialVerify('1,2');
    }
    //datos obligatorios si la victima Fallece
    if($("#C_12").val()==''){
        error+=specialVerify('15,18');
    }

    //Datos obligatorios si el evento es un accidente de transito u otro
    if($("#C_20").val()=='01'){
        error+=specialVerify('19');
    } else if($("#C_20").val()=='17'){
        error+=specialVerify('21');
    }

    //Datos obligatorios de vehiculos
    //Marca (C_29) es obligatorio si el estado de aseguramiento (C_28) es 3 o 5
    if($("#C_28").val()==3 || $("#C_28").val()==5){
        error+=specialVerify('29');
    }
    //Placa (C_30) y Tipo Vehiculo (C_31) son obligatorio si el estado de aseguramiento (C_28) es 1,2,4,5,6,7
    if($("#C_28").val()==1 || $("#C_28").val()==2 || $("#C_28").val()==4 || $("#C_28").val()==5 || $("#C_28").val()==6 || $("#C_28").val()==7){
        error+=specialVerify('30,31');
    }
    //Aseguradora (C_32), Poliza (C_33) y la vigencia de la poliza (C_34 y C_35) son obligatorios si el estado de aseguramiento (C_28) es 1,4 o 6
    if($("#C_28").val()==1 || $("#C_28").val()==4 || $("#C_28").val()==6){
        error+=specialVerify('32,33,34,35');
    }

    //Si el evento (C_20) es un accidente de transito (01) el ID del SIRAS (C_36) es obligatorio
    if($("#C_20").val()=='01'){
        error+=specialVerify('36');
    }

    //Banderas de CUPS
    var CUPS_hosp=false; //Verifica que si se reclama estancia el CUPS del procedimiento (C_38) es obligatorio
    var CUPS_qx=false; //Verifica que si se reclama Procedimientos Quirurgicos el CUPS del procedimiento (C_40) es obligatorio
    var UCI=false; //Verifica que si se reclama estancia en UCI
    if(CUPS_hosp==true){
        errCUPS.push('El Procedimiento de servicio de Hospitalizacion es Obligatorio debido a que existe estancia hospitalaria reclamada');
    }
    if(CUPS_qx==true){
        errCUPS.push('El Procedimiento de servicio Quirurgico y su Complejidad son Obligatorios debido a que existe procedimiento quirurgico reclamado');
    }
    if(UCI==true){
        errCUPS.push('Se debe marcar SI en la prestacion de UCI tambien se deben estipular los dias de estancia en UCI reclamados debido a que existe estancia en UCI reclamada');
    }

    //Datos obligatorios de Propietario del Vehiculo
    //Los datos del Propietario (44,45,46,48,50,51,52,53) si el estado de aseguramiento (C_28) es 1,2,4,6
    if($("#C_28").val()==1 || $("#C_28").val()==2 || $("#C_28").val()==4 || $("#C_28").val()==6){
        error+=specialVerify('44,45,46,48,50,51,52,53');
    }

    //Datos obligatorios de Conductor del Vehiculo
    //Los datos del Conductor (54,56,58,59,60,61,62,63) si el estado de aseguramiento (C_28) es 1,2,4,6 o 7
    if($("#C_28").val()==1 || $("#C_28").val()==2 || $("#C_28").val()==4 || $("#C_28").val()==6 || $("#C_28").val()==7){
        error+=specialVerify('54,56,58,59,60,61,62,63');
    }

    var trasladoInter=false;
    if(trasladoInter==true){
        errTraslado='Para esta reclamacion son obligatorios los datos de traslado Interinstitucional<br>';
    }

    var trasladoLocal=false;
    if(trasladoLocal==true){
        errTraslado+='Para esta reclamacion son obligatorios los datos de traslado de movilizacion de la victima<br>';
    }

}

function specialVerify(fiels){
    var fiels=fiels.split(',');
    var error='';
    for(var i=0;i<fiels.length;i++){
        if($('#C_'+fiels[i]).val()==''){
            error+='El campo <strong>'+campos[fiels[i]]+'</strong> es requerido<br>';
        }
    }
    return error;
}