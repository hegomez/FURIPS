function getDepartamentos(){
    $.ajax({
        url: 'process/prc_furips.php',
        type: 'POST',
        data: {action:'getDepartamentos'},
        success: function(data){
            //fill the selects C_16,C_25,C_52,C_61
            var data=JSON.parse(data);
            data=data.data;
            var html='<option value="">Seleccione Departamento</option>';
            for(var i=0;i<data.length;i++){
                html+='<option value="'+data[i].uid+'">'+data[i].nombre+'</option>';
            }
            $('#C_16,#C_25,#C_52,#C_61').html(html);
        }
    });
}

//verifi if change the value of C_16,C_25,C_52,C_61
$(document).on('change','#C_16, #C_25, #C_52, #C_61',function(){
    var departamento=parseInt($(this).val());
    var deptoId=parseInt($(this).attr('id').replace('C_',''));
    deptoId++;
    $.ajax({
        url: 'process/prc_furips.php',
        type: 'POST',
        data: {action:'getMunicipios',departamento:departamento},
        success: function(data){
            var data=JSON.parse(data);
            data=data.data;
            var html='<option value="">Seleccione Municipio</option>';
            for(var i=0;i<data.length;i++){
                html+='<option value="'+data[i].uid+'">'+data[i].nombre+'</option>';
            }
            $('#C_'+deptoId).html(html);
        }
    });
});

$(document).on('input','#C_67, #C_72',function(){
    var id=$(this).attr('id');
    var searchKeyword =$(this).val().toUpperCase();
    if (searchKeyword.length >= 3) {
        $.ajax({
            url: 'process/prc_furips.php',
            method: 'POST',
            data: {action: 'search_ips', keyword: searchKeyword},
            dataType: 'json',
            success: function(response) {
                // Muestra los resultados en el div de autocomplete
                var resultsDiv = $('#autocomplete_'+id);
                resultsDiv.empty(); // Limpiar resultados anteriores
                if (response.length > 0) {
                  $.each(response, function(index, element) {
                    var resultItem = $('<div class="autocomplete-item">' + element.nombre + '</div>');
                    resultItem.data('val', element.hab);
                    resultsDiv.append(resultItem);
                  });
                } else {
                  resultsDiv.html('<div class="autocomplete-item">No se encontraron resultados</div>');
                }
            }
        });
    }
});

$(document).on('blur','#C_67, #C_72',function(){
    if($(this).attr('data-val')!=undefined){
        $(this).val($(''));
        $('#autocomplete_'+id).html('');
    }
});

$(document).on('click','.autocomplete-item',function(){
    var id=$(this).parent().attr('id').replace('autocomplete_','');
    var val=$(this).attr('data-val');
    $('#'+id).val($(this).text());
    $('#'+id).attr('data-val',val);
    $('#autocomplete_'+id).html('');
});
function GenerateFURIPS(){
    var error='';
    var errCUPS=[];
    var errTraslado='';
    var data={};
    //Se recorren los controles y se verifica que los requeridos no esten vacios
    $('.form-control').each(function(){
        var id=$(this).attr('id');
        var uid=$(this).attr('id');
        id=id.replace('C_','');
         if($(this).attr('required') && $(this).val()==''){
            error+='El campo <strong>'+campos[id]+'</strong> es requerido<br>';
        }
        //verify if isset attr data-val
        if($(this).attr('data-val')!=undefined){
            data[uid]=$(this).attr('data-val');
        } else {
            data[uid]=$(this).val();
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
    //Marca (C_29) es obligatorio si el estado de aseguramiento (C_28) no es 3 y 5
    if($("#C_28").val()!=3 && $("#C_28").val()!=5){
        error+=specialVerify('29');
    }
    //Placa (C_30) y Tipo Vehiculo (C_31) son obligatorio si el estado de aseguramiento (C_28) es 1,2,4,6,7
    if($("#C_28").val()==1 || $("#C_28").val()==2 || $("#C_28").val()==4 || $("#C_28").val()==6 || $("#C_28").val()==7){
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

    //Procesar errores
    if(error!=''){
        Swal.fire({
            title: 'Error!',
            html: error,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    } else if(errCUPS.length>0){
        var err='';
        for(var i=0;i<errCUPS.length;i++){
            err+=errCUPS[i]+'<br>';
        }
        Swal.fire({
            title: 'Error!',
            html: err,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    } else if(errTraslado!=''){
        Swal.fire({
            title: 'Error!',
            html: errTraslado,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    } else {
        //mostrar modal de confirmacion
        Swal.fire({
            title: 'Confirmar',
            text: "¿Desea guardar la informacion?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fas fa-save"></i> Guardar',
            cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
        }).then((result) => {
            if (result.value) {
                //show loading text with a spinner then make ajax call
                Swal.fire({
                    title: 'Guardando',
                    html: 'Por favor espere un momento <i class="fas fa-spinner fa-spin"></i>',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                
                console.log(data);
                $.ajax({
                    url: 'process/prc_furips.php',
                    type: 'POST',
                    data: {data:data,action:'saveFURIPS'},
                    success: function(data){
                        if(data.status=='success'){
                            //mostrar un swal con un iframe en su src reports/furips.php?ID=ID
                            Swal.fire({
                                title: 'FURIPS',
                                html: '<iframe src="reports/furips.php?ID='+data.ID+'" width="100%" height="500px"></iframe>',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                html: data.msg,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function(){
                        Swal.fire({
                            title: 'Error!',
                            html: 'Error al guardar la informacion',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }
        });
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

//al cambiar C_20 (Evento) mostrar el campo C_21 (Descripcion otro Tipo de Evento)
$(document).on('change','#C_20',function(){
    if($(this).val()=='17'){
        $('#C_21').parent().parent().show();
    } else {
        $('#C_21').parent().parent().hide();
    }
});

//pasar datos de victima a propietario
$(document).on('click','#vic2prop',function(){
    var docProp=['CC','CE','CD','DE','SC','PE','PT','NI'];
    //verify if the value of C_10 is in docProp
    if(docProp.indexOf($('#C_10').val())!=-1){
        $('#C_44').val($('#C_10').val());
        $('#C_45').val($('#C_11').val());
        $('#C_46').val($('#C_6').val());
        $('#C_47').val($('#C_7').val());
        $('#C_48').val($('#C_8').val());
        $('#C_49').val($('#C_9').val());
        $('#C_50').val($('#C_15').val());
        $('#C_51').val($('#C_18').val());
        //cambia el valor del select de C_52 por el valor de C_16 activando el evento change
        $('#C_52').val($('#C_16').val()).change();
        setTimeout(function(){
            $('#C_53').val($('#C_17').val());
        },500);
    } else {
        Swal.fire({
            title: 'Error!',
            html: 'El tipo de documento de identificacion de la victima no es valido para el propietario del vehiculo',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
});
//pasar datos de victima a conductor
$(document).on('click','#vic2cond',function(){
    var docProp=['CC','CE','PA','RC','TI','CD','SC','DE','PE','PT'];
    //verify if the value of C_10 is in docProp
    if(docProp.indexOf($('#C_10').val())!=-1){
        $('#C_58').val($('#C_10').val());
        $('#C_59').val($('#C_11').val());
        $('#C_54').val($('#C_6').val());
        $('#C_55').val($('#C_7').val());
        $('#C_56').val($('#C_8').val());
        $('#C_57').val($('#C_9').val());
        $('#C_60').val($('#C_15').val());
        $('#C_63').val($('#C_18').val());
        //cambia el valor del select de C_52 por el valor de C_16 activando el evento change
        $('#C_61').val($('#C_16').val()).change();
        setTimeout(function(){
            $('#C_62').val($('#C_17').val());
        },500);
    } else {
        Swal.fire({
            title: 'Error!',
            html: 'El tipo de documento de identificacion de la victima no es valido para el conductor del vehiculo',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
});
//pasar datos de propietario a conductor
$(document).on('click','#prop2cond',function(){
    var docProp=['CC','CE','PA','RC','TI','CD','SC','DE','PE','PT'];
    //verify if the value of C_10 is in docProp
    if(docProp.indexOf($('#C_44').val())!=-1){
        $('#C_58').val($('#C_44').val());
        $('#C_59').val($('#C_45').val());
        $('#C_54').val($('#C_46').val());
        $('#C_55').val($('#C_47').val());
        $('#C_56').val($('#C_48').val());
        $('#C_57').val($('#C_49').val());
        $('#C_60').val($('#C_50').val());
        $('#C_63').val($('#C_51').val());
        //cambia el valor del select de C_52 por el valor de C_16 activando el evento change
        $('#C_61').val($('#C_52').val()).change();
        setTimeout(function(){
            $('#C_62').val($('#C_53').val());
        },500);
    } else {
        Swal.fire({
            title: 'Error!',
            html: 'El tipo de documento de identificacion del propietario no es valido para el conductor del vehiculo',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
});

