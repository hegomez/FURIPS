<?php
    $campos=array(
        1=>array('detalle'=>'Número de radicado anterior','long'=>10),
        2=>array('detalle'=>'RGO Respuesta a Glosa u objeción','long'=>1,'values'=>array('0'=>'Glosa u objeción total','1'=>'Pago parcial','6'=>'Glosa Transversal')),
        3=>array('detalle'=>'Número de factura.','long'=>20),
        4=>array('detalle'=>'Número consecutivo de la reclamación','long'=>12),
        5=>array('detalle'=>'Código de habilitación del prestador de servicios de salud.','long'=>12),
        6=>array('detalle'=>'Primer apellido de la víctima','long'=>20),
        7=>array('detalle'=>'Segundo apellido de la víctima','long'=>30),
        8=>array('detalle'=>'Primer nombre de la víctima','long'=>20),
        9=>array('detalle'=>'Segundo nombre de la víctima','long'=>30),
        10=>array('detalle'=>'Tipo de documento de identidad de la víctima','long'=>2,'values'=>array('CC'=>'CC','CE'=>'CE','CN'=>'CN','PA'=>'PA','TI'=>'TI','RC'=>'RC','AS'=>'AS','MS'=>'MS','CD'=>'CD','SC'=>'SC','PE'=>'PE','PT'=>'PT','DE'=>'DE')),
        11=>array('detalle'=>'Número de documento de identidad de la víctima','long'=>16),
        12=>array('detalle'=>'Fecha de nacimiento de la víctima','long'=>10,'type'=>'date'),
        13=>array('detalle'=>'Fecha de fallecimiento','long'=>10,'type'=>'date'),
        14=>array('detalle'=>'Sexo de la víctima','long'=>1,'values'=>array('F'=>'F','M'=>'M','O'=>'O')),
        15=>array('detalle'=>'Dirección de residencia de la víctima','long'=>40),
        16=>array('detalle'=>'Código del departamento de residencia de la víctima','long'=>2,'values'=>array(),'placeholder'=>'Departamento'),
        17=>array('detalle'=>'Código del municipio de residencia de la víctima','long'=>3,'values'=>array(),'placeholder'=>'Municipio'),
        18=>array('detalle'=>'Teléfono de la víctima','long'=>10),
        19=>array('detalle'=>'Condición de la víctima','long'=>1,'values'=>array('1'=>'Conductor','2'=>'Peatón','3'=>'Ocupante','4'=>'Ciclista')),
        20=>array('detalle'=>'Naturaleza del evento','long'=>2,'values'=>array('01'=>'Accidente de tránsito','02'=>'Sismo','03'=>'Maremoto','04'=>'Erupción volcánica','05'=>'Deslizamiento de tierra','06'=>'Inundación','07'=>'Avalancha','08'=>'Incendio natural','09'=>'Explosión terrorista','10'=>'Incendio terrorista','11'=>'Combate','12'=>'Ataques a Municipios','13'=>'Masacre','14'=>'Desplazados','15'=>'Mina antipersonal','16'=>'Huracán','17'=>'Otro','25'=>'Rayo','26'=>'Vendaval','27.'=>'Tornado')),
        21=>array('detalle'=>'Descripción del otro evento','long'=>25),
        22=>array('detalle'=>'Dirección de ocurrencia del evento','long'=>40),
        23=>array('detalle'=>'Fecha de ocurrencia del evento','long'=>10,'type'=>'date'),
        24=>array('detalle'=>'Hora de ocurrencia del evento','long'=>5,'type'=>'time'),
        25=>array('detalle'=>'Código del departamento de ocurrencia del evento','long'=>2,'values'=>array(),'placeholder'=>'Departamento'),
        26=>array('detalle'=>'Código del municipio de ocurrencia del evento','long'=>3,'values'=>array(),'placeholder'=>'Municipio'),
        27=>array('detalle'=>'Zona de ocurrencia del evento','long'=>1,'values'=>array('U'=>'U','R'=>'R')),
        28=>array('detalle'=>'Estado de aseguramiento','long'=>1,'values'=>array('1'=>'Asegurado','2'=>'No asegurado','3'=>'Vehículo fantasma','4'=>'Póliza falsa','5'=>'Vehículo en Fuga','6'=>'Asegurado D.','7'=>'No asegurado - Propietario Indeterminado')),
        29=>array('detalle'=>'Marca','long'=>15),
        30=>array('detalle'=>'Placa','long'=>10),
        31=>array('detalle'=>'Tipo de Vehículo','long'=>2,'values'=>array('1'=>'Automóvil','2'=>'Bus','3'=>'Buseta','4'=>'Camión','5'=>'Camioneta','6'=>'Campero','7'=>'Microbus','8'=>'Tractocamión','10'=>'Motocicleta','14'=>'Motocarro','17'=>'Mototriciclo','19'=>'Cuatrimoto','20'=>'Moto Extrajera','21'=>'Vehículo Extranjero','22'=>'Volqueta')),
        32=>array('detalle'=>'Código de la aseguradora','long'=>6,'values'=>array("13-15"=>"Allianz Colombia","36937"=>"Aseguradora Solidaria de Colombia","13-61"=>"Axa Colpatria","13-17"=>"Seguros Mundial","14-29"=>"La Equidad","14-23"=>"La Previsora","13-33"=>"Liberty Seguros","13-26"=>"MAPFRE","14-07"=>"Seguros Bolivar","14-19"=>"Seguros del Estado","14-28"=>"SURA"),'placeholder'=>'Aseguradora'),
        33=>array('detalle'=>'Número de póliza SOAT','long'=>20),
        34=>array('detalle'=>'Fecha de inicio de vigencia de la póliza','long'=>10,'type'=>'date'),
        35=>array('detalle'=>'Fecha final de vigencia de la póliza','long'=>10,'type'=>'date'),
        36=>array('detalle'=>'Número de radicado SIRAS (id_atencion)','long'=>20),
        37=>array('detalle'=>'Cobro por agotamiento tope Aseguradora','long'=>1,'values'=>array('0'=>'NO','1'=>'SI')),
        38=>array('detalle'=>'Código CUPS de servicio principal de hospitalización','long'=>6,'placeholder'=>'Servicio principal de Hospitalización'),
        39=>array('detalle'=>'Complejidad del procedimiento quirúrgico','long'=>1,'values'=>array('1'=>'Alta','2'=>'Media','3'=>'Baja')),
        40=>array('detalle'=>'Código CUPS del procedimiento quirúrgico principal','long'=>6,'placeholder'=>'Procedimiento Quirúrgico Principal'),
        41=>array('detalle'=>'Código CUPS del procedimiento quirúrgico secundario','long'=>6,'placeholder'=>'Procedimiento Quirúrgico Secundario'),
        42=>array('detalle'=>'Se presto servicio UCI','long'=>1,'values'=>array('0'=>'NO','1'=>'SI')),
        43=>array('detalle'=>'Días de UCI reclamados','long'=>2),
        44=>array('detalle'=>'Tipo de documento de identidad del propietario','long'=>2,'values'=>array('CC'=>'CC','CE'=>'CE','CD'=>'CD','DE'=>'DE','SC'=>'SC','PE'=>'PE','PT'=>'PT','NI.'=>'NI.')),
        45=>array('detalle'=>'Número de documento de identidad del propietario','long'=>16),
        46=>array('detalle'=>'Primer apellido del propietario o razón social en caso de empresa.','long'=>40),
        47=>array('detalle'=>'Segundo apellido del propietario','long'=>30),
        48=>array('detalle'=>'Primer nombre del propietario','long'=>20),
        49=>array('detalle'=>'Segundo nombre del propietario','long'=>30),
        50=>array('detalle'=>'Dirección de residencia del propietario','long'=>40),
        51=>array('detalle'=>'Teléfono de residencia del propietario','long'=>10),
        52=>array('detalle'=>'Código del departamento de residencia del propietario','long'=>2,'values'=>array(),'placeholder'=>'Departamento'),
        53=>array('detalle'=>'Código del municipio de residencia del propietario','long'=>3,'values'=>array(),'placeholder'=>'Municipio'),
        54=>array('detalle'=>'Primer apellido del conductor','long'=>20),
        55=>array('detalle'=>'Segundo apellido del conductor','long'=>30),
        56=>array('detalle'=>'Primer nombre del conductor','long'=>20),
        57=>array('detalle'=>'Segundo nombre del conductor','long'=>30),
        58=>array('detalle'=>'Tipo de documento de identidad del conductor','long'=>2,'values'=>array('CC'=>'CC',' CE'=>' CE','PA'=>'PA','RC'=>'RC','TI'=>'TI','CD'=>'CD',' SC'=>' SC','DE'=>'DE','CD'=>'CD','PE'=>'PE','PT'=>'PT')),
        59=>array('detalle'=>'Número de documento de identidad del conductor','long'=>16),
        60=>array('detalle'=>'Dirección de residencia del conductor','long'=>40),
        61=>array('detalle'=>'Código del departamento de residencia del conductor','long'=>2,'values'=>array(),'placeholder'=>'Departamento'),
        62=>array('detalle'=>'Código del municipio de residencia del conductor','long'=>3,'values'=>array(),'placeholder'=>'Municipio'),
        63=>array('detalle'=>'Teléfono de residencia del conductor','long'=>10),
        64=>array('detalle'=>'Tipo de referencia','long'=>1,'values'=>array(''=>'','1'=>'Remision','2'=>'Orden de Servicio')),
        65=>array('detalle'=>'Fecha de remisión','long'=>10,'type'=>'date'),
        66=>array('detalle'=>'Hora de salida','long'=>5,'type'=>'time'),
        67=>array('detalle'=>'Código de habilitación del prestador de servicios de salud remitente.','long'=>12),
        68=>array('detalle'=>'Profesional que remite','long'=>60),
        69=>array('detalle'=>'Cargo de la persona que remite','long'=>30),
        70=>array('detalle'=>'Fecha de ingreso','long'=>10,'type'=>'date'),
        71=>array('detalle'=>'Hora de ingreso','long'=>5,'type'=>'time'),
        72=>array('detalle'=>'Código de habilitación del prestador de servicios de salud que recibe.','long'=>12),
        73=>array('detalle'=>'Profesional que recibe','long'=>60),
        74=>array('detalle'=>'Placa ambulancia que realiza el traslado interinstitucional','long'=>6),
        75=>array('detalle'=>'Placa ambulancia traslado primario','long'=>6),
        76=>array('detalle'=>'Transporte de la víctima desde el sitio del evento','long'=>40),
        77=>array('detalle'=>'Transporte de la víctima hasta el fin del recorrido','long'=>40),
        78=>array('detalle'=>'Tipo de servicio del transporte','long'=>1,'values'=>array(''=>'','1'=>'Transporte básico','2'=>'ransporte medicalizado')),
        79=>array('detalle'=>'Zona donde recoge víctima','long'=>1,'values'=>array(''=>'','U'=>'Urbana','R'=>'Rural')),
        80=>array('detalle'=>'Fecha de ingreso','long'=>10,'type'=>'date'),
        81=>array('detalle'=>'Hora de ingreso','long'=>5,'type'=>'time'),
        82=>array('detalle'=>'Fecha de egreso','long'=>10,'type'=>'date'),
        83=>array('detalle'=>'Hora de egreso','long'=>5,'type'=>'time'),
        84=>array('detalle'=>'Código de diagnóstico principal de ingreso','long'=>4),
        85=>array('detalle'=>'Código de diagnóstico de ingreso asociado 1','long'=>4),
        86=>array('detalle'=>'Código de diagnóstico de ingreso asociado 2','long'=>4),
        87=>array('detalle'=>'Código diagnóstico principal de egreso','long'=>4),
        88=>array('detalle'=>'Código de diagnóstico de egreso asociado 1','long'=>4),
        89=>array('detalle'=>'Código de diagnóstico de egreso asociado 2','long'=>4),
        90=>array('detalle'=>'Primer apellido del médico o profesional de la salud','long'=>20),
        91=>array('detalle'=>'Segundo apellido del médico o profesional de la salud','long'=>30),
        92=>array('detalle'=>'Primer nombre del médico o profesional de la salud','long'=>20),
        93=>array('detalle'=>'Segundo nombre del médico o profesional de la salud','long'=>30),
        94=>array('detalle'=>'Tipo de documento de identidad del médico o profesional de la salud','long'=>2,'values'=>array('CC'=>'CC','CE'=>'CE','PE'=>'PE','PA'=>'PA','PT'=>'PT')),
        95=>array('detalle'=>'Número de documento de identidad del médico o profesional de la salud','long'=>16),
        96=>array('detalle'=>'Número de registro del médico','long'=>16),
        97=>array('detalle'=>'Total facturado por amparo de gastos médicos quirúrgicos','long'=>15),
        98=>array('detalle'=>'Total reclamado por amparo de gastos médicos quirúrgicos','long'=>15),
        99=>array('detalle'=>'Total facturado por amparo de gastos de transporte y movilización de la víctima','long'=>15),
        100=>array('detalle'=>'Total reclamado por amparo de gastos de transporte y movilización de la víctima','long'=>15),
        101=>array('detalle'=>'Manifestación de servicios habilitados','long'=>3,'values'=>array('0'=>'NO','1'=>'SI')),
    );
