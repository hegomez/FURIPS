<?php
    include('../inc/fpdf/fpdf.php');
    include('../inc/conn.php');
    include('../inc/parametros.php');

    function dividir($txt,$contador=60)
    {
        $temp=explode(' ',$txt);
    
        $id=0;
        $Cont=array('','','','','','','');
        foreach ($temp as $key => $value)
        {
            if(strlen($value)<=$contador)
            {
                $Cont[$id].=$value.' ';
                $contador-=(strlen($value)+1);
            }
            else
            {
                $contador=148;
                $id++;
                $Cont[$id].=$value.' ';
                $contador-=(strlen($value)+1);
            }
        }
        return $Cont;
    }

    $sql="SELECT * FROM `furips_1` f1 INNER JOIN `furips_pdf` pdf ON f1.c_3=pdf.factura WHERE f1.c_3=:factura";
    $stmt=$bd_furips->prepare($sql);
    $stmt->execute(array(':factura'=>$_GET['ID']));
    $FURIPS=$stmt->fetch(PDO::FETCH_OBJ);

    //reemplazar los / de las fechas 12,,13,23,34,35,65,70,80,82
    $FURIPS->C_12=str_replace('/','',$FURIPS->C_12);
    $FURIPS->C_13=str_replace('/','',$FURIPS->C_13);
    $FURIPS->C_23=str_replace('/','',$FURIPS->C_23);
    $FURIPS->C_34=str_replace('/','',$FURIPS->C_34);
    $FURIPS->C_35=str_replace('/','',$FURIPS->C_35);
    $FURIPS->C_65=str_replace('/','',$FURIPS->C_65);
    $FURIPS->C_70=str_replace('/','',$FURIPS->C_70);
    $FURIPS->C_80=str_replace('/','',$FURIPS->C_80);
    $FURIPS->C_82=str_replace('/','',$FURIPS->C_82);

    //reemplazar : de las horas 24,66,71,81,83
    $FURIPS->C_24=str_replace(':','',$FURIPS->C_24);
    $FURIPS->C_66=str_replace(':','',$FURIPS->C_66);
    $FURIPS->C_71=str_replace(':','',$FURIPS->C_71);
    $FURIPS->C_81=str_replace(':','',$FURIPS->C_81);
    $FURIPS->C_83=str_replace(':','',$FURIPS->C_83);

    class PDF extends FPDF
    {
        //se define el metodo para colocar cada elemento en la cuadricula
        function Cuadricula($txt,$ln=0,$w=4,$h=4)
        {
            $txt=strval($txt);
            for($i=0;$i<strlen($txt);$i++)
            {
                $this->Cell($w,$h,$txt[$i],1,$ln,'C');
            }
        }
        
        function SP($ln=0,$w=4,$h=4)
        {
            switch ($ln) {
                case 3:
                    $this->Cell(0,$h,'','R',1);
                    $this->Cell(0,1,utf8_decode(''),'RL',1);
                    $this->Cell(($w*0.75),$h,'','L',0);
                break;
                case 2:
                    $this->Cell(0,1,utf8_decode(''),'RL',1);
                break;
                default:
                    $b=($ln==0) ? 'L' : 'R';
                    $this->Cell(($w*0.75),$h,'',$b,$ln);
                break;
            }
        }
    }

    $h=4;
    $pdf = new PDF();
    $pdf->setFillColor(217,217,217);
    $pdf->SetAutoPageBreak(10);
    $pdf->AddPage();

    //Parte A del FURIPS
    $pdf->SetFont('arial','',8);
    $pdf->Cell(0,3,'PARTE A   ','0',1,'R');
    $pdf->SetFont('arial','B',8);

    $pdf->Image('../dist/img/furips/escudo.png',11,14,15);

    $pdf->Cell(0,$h,utf8_decode('REPUBLICA DE COLOMBIA'),'RTL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('MINISTERIO DE SALUD Y PROTECCIÓN SOCIAL'),'RL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('FORMULARIO ÚNICO DE RECLAMACIÓN DE LAS INSTITUCIONES PRESTADORAS DE SERVICIOS DE SALUD POR'),'RL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('SERVICIOS PRESTADOS A VICTIMAS DE EVENTOS CATASTRÓFICOS Y ACCIDENTES DE TRANSITO'),'RL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('PRESTADORES DE SERVICIOS DE SALUD - FURIPS'),'RL',1,'C');
    $pdf->Cell(0,$h/2,'','RL',1);
    $pdf->SP();
    $pdf->SetFont('arial','',8);
    $pdf->Cell(4*8,$h,utf8_decode('Fecha Radicación'),'0',0);
    $pdf->Cuadricula('        ');
    $pdf->Cell(4*2,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*2,$h,utf8_decode('RG'),'0',0);
    $RG=($FURIPS->C_2==0) ? '' : 'X';
    $pdf->Cell(4,$h,utf8_decode($RG),'1',0);
    $pdf->Cell(4,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*2,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('No. Radicado'),'0',0);
    $pdf->Cell(4*14,$h,utf8_decode(''),'1',0,'C',true);
    $pdf->SP(3);

    $pdf->SetFont('arial','',6);
    $pdf->Cell(4*10,2,utf8_decode('No. Radicación Anterior'),'0',0);
    $pdf->SetFont('arial','',8);
    $pdf->Cell(4*13,$h,$FURIPS->C_1,'1',0);
    $pdf->Cell(4*9,2,utf8_decode(''),'0',0);
    $pdf->Cell(4*14,$h,utf8_decode($FURIPS->C_3),'1',0);
    $pdf->SP(1);

    $pdf->SetFont('arial','',6);
    $pdf->text($pdf->GetX()+4,$pdf->GetY(),'(Respuesta a glosa, marcar X en RG)');
    $pdf->text($pdf->GetX()+100,$pdf->GetY(),'Nro Factura/ Cuenta de cobro');
    
    $pdf->SetFont('arial','',8);
    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('I. DATOS DE LA INSTITUCIÓN PRESTADORA DE SERVICIO DE SALUD'),'1',1,'C',true);
    $pdf->SP(2);

    $pdf->SP();
    $pdf->Cell(4*7,$h,utf8_decode('Razón Social'),'0',0);
    $pdf->Cell(4*39,$h,utf8_decode($FURIPS->nombre_ips),'1',0);

    $pdf->SP(1);
    $pdf->SP(2);
    $pdf->SP();

    $pdf->Cell(4*7,$h,utf8_decode('Código Habilitación'),'0',0);
    $pdf->Cuadricula($FURIPS->C_5);
    $pdf->Cell(4*15,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*3,$h,utf8_decode('NIT'),'0',0);
    $pdf->Cuadricula($FURIPS->nit_ips);
    
    $pdf->SP(1);
    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('II. DATOS DE LA VICTIMA DEL EVENTO CATASTRÓFICO O ACCIDENTE DE TRANSITO'),'1',1,'C',true);
    $pdf->SP(2);

    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_6),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_7),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Apellido'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Apellido '),'0',0,'C');
    $pdf->SP(1);

    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_8),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_9),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Nombre'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Nombre '),'0',0,'C');

    $pdf->SP(1);
    $pdf->SP(2);
    $pdf->SP(0);
    
    $TD=array('CC','CE','CN','PA','TI','RC','AS','MS','CD','SC','PE','PT','DE');

    $pdf->Cell(4*8,$h,utf8_decode('Tipo de Documento'),'0',0);
    $pdf->SetFont('arial','',6);
    foreach($TD as $XX) { if(isset($XX)) { unset($XX); } }
    ${$FURIPS->C_10}='1';
    foreach($TD as $XX)
    {
        $pdf->Cell(4,$h,$XX,'1',0,'C');
        if(isset($$XX) && $$XX==1)
        {
            $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
            $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
        }
    }
    $pdf->SetFont('arial','',8);

    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*6,$h,utf8_decode('No. Documento'),'0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_11,15,' ',STR_PAD_LEFT));

    $pdf->SP(1,0);
    $pdf->SP(2);
    $pdf->SP(0);

    $pdf->Cell(4*8,$h,utf8_decode('Fecha de Nacimiento'),'0',0);
    $pdf->Cuadricula($FURIPS->C_12);
    $pdf->Cell(4*2,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Sexo','0',0);
    $pdf->Cell(4*2,$h,'','0',0);
    $SX=array('F','M','O');
    if(isset($M))
    unset($M);
    if(isset($F))
    unset($F);
    ${$FURIPS->C_14}='1';
    foreach($SX as $XX)
    {
        $pdf->Cell(4,$h,$XX,'1',0,'C');
        if(isset($$XX))
        {
            $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
            $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
        }
        $pdf->Cell(4,$h,'','0',0,'C');
    }

    $pdf->SP(3);

    $pdf->Cell(4*8,$h,utf8_decode('Dirección de Residencia'),'0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_15,38,' '));

    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Departamento'),'0',0);
    $pdf->Cuadricula(str_pad($DEPTOS[$FURIPS->C_16],21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $pdf->Cuadricula($FURIPS->C_16);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*3,$h,'Telefono','0',0);
    $pdf->Cuadricula($FURIPS->C_18);

    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Municipio'),'0',0);
    $pdf->Cuadricula(str_pad($MUNS[$FURIPS->C_16.$FURIPS->C_17],21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $pdf->Cuadricula($FURIPS->C_17);

    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Condición del Accidentado'),'0',0);
    $C=array('C1'=>'','C2'=>'','C3'=>'','C4'=>'');
    $C['C'.$FURIPS->C_19]='X';
    $pdf->Cell(4*1,$h,utf8_decode($C['C1']),'1',0);
    $pdf->Cell(4*8,$h,utf8_decode('Conductor'),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($C['C2']),'1',0);
    $pdf->Cell(4*8,$h,utf8_decode('Peatón'),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($C['C3']),'1',0);
    $pdf->Cell(4*8,$h,utf8_decode('Ocupante'),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($C['C4']),'1',0);
    $pdf->Cell(4*8,$h,utf8_decode('Ciclista'),'0',0);

    $pdf->SP(1);
    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('III. DATOS DEL SITIO DONDE OCURRIÓ EL EVENTO CATASTRÓFICO O EL ACCIDENTE DE TRANSITO'),'1',1,'C',true);
    $pdf->SP(2);

    /* aqui no hay variables */
    $pdf->SP(0);
    $pdf->Cell(4*7,$h,utf8_decode('Naturaleza del Evento'),'0',0);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Accidente de Tránsito'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
    $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode('Naturales:'),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Sismo'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Maremoto '),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Erupciones Volcánicas'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Huracán'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Inundaciones'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Avalancha '),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Deslizamiento de Tierra '),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Incendio Natural'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Rayo'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Vendaval'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Tornado'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode('Terroristas:'),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Explosión'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Masacre'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Mina Antipersonal'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Combate'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Incendio'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*8,$h,utf8_decode('Ataques a Municipios'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->SP(3);
    $pdf->Cell(4*2,$h,utf8_decode('Otro'),'0',0);
    $pdf->Cell(4*1,$h,'','1',0);
    $pdf->Cell(4*2,$h,'','0',0);
    $pdf->Cell(4*3,$h,'Cual?','0',0);
    for($i=1;$i<=38;$i++)
    $pdf->Cell(4,$h,'','1',0);

    $pdf->SP(3);

    $pdf->Cell(4*9,$h,utf8_decode('Dirección de la Ocurrencia'),'0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_22,37,' '));  
    $pdf->SP(3);
    $pdf->Cell(4*9,$h,utf8_decode('Fecha Evento/Accidente'),'0',0);
    $pdf->Cuadricula($FURIPS->C_23);  
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*3,$h,utf8_decode('Hora'),'0',0);
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cuadricula($FURIPS->C_24);
    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Departamento'),'0',0);
    $pdf->Cuadricula(str_pad($DEPTOS[$FURIPS->C_25],21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $pdf->Cuadricula($FURIPS->C_25);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->SP(3);
    $pdf->Cell(4*6,$h,utf8_decode('Municipio'),'0',0);
    $pdf->Cuadricula(str_pad($MUNS[$FURIPS->C_25.$FURIPS->C_26],21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $pdf->Cuadricula($FURIPS->C_26);
    $pdf->Cell(4*2,$h,'','0',0);
    $pdf->Cell(4*3,$h,'Zona','0',0);

    $ZN=array('U','R');    
    ${$FURIPS->C_27}='1';
    foreach($ZN as $XX)
    {
        $pdf->Cell(4,$h,$XX,'1',0,'C');
        if(isset($$XX))
        {
            $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
            $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
        }
        $pdf->Cell(4,$h,'','0',0,'C');
    }
    $pdf->SP(3);
    $pdf->Cell(4*0,$h,utf8_decode('Descripción Breve del Evento Catastrófico o Accidente de Transito'),'0',0);
    $pdf->SP(3);
    $pdf->SetFont('arial','B',8);
    $pdf->Cell(4*21,$h,utf8_decode('Enuncie las principales caracteristicas del evento / accidente:'),'0',0);
    $pdf->SetFont('arial','',8);
    $Detalle=dividir($FURIPS->desc_evento);
    $pdf->Cell(4*25,$h,utf8_decode($Detalle[0]),'B',0);
    $pdf->SP(1);
    
    for($i=1;$i<=4;$i++)
    {   
        if(isset($Detalle[$i]) && !empty($Detalle[$i]))
        {
            $pdf->SP(0);
            $pdf->Cell(4*46,$h,utf8_decode($Detalle[$i]),'B',0);
            $pdf->SP(1);
        }
        else
        {
            $pdf->SP(0);
            $pdf->Cell(4*46,$h,'','B',0);
            $pdf->SP(1);
        }
    }

    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('IV. DATOS DEL VEHICULO DE ACCIDENTE DE TRANSITO'),'1',1,'C',true);
    $pdf->SP(2);
    $pdf->SP(0);

    $XX=array('','','','','','','');
    $XX[$FURIPS->C_28]='X';
    //$pdf->Cell(4*6,$h,utf8_decode(''),'0',0);
    $pdf->SetFont('arial','',7);
    $w=2+$pdf->GetStringWidth('Asegurado');
    $pdf->Cell($w,$h,utf8_decode('Asegurado'),'0',0);
    $pdf->Cell(4*1,$h,$XX[1],'1',0);

    $w=2+$pdf->GetStringWidth('No Asegurado');
    $pdf->Cell($w,$h,utf8_decode('No Asegurado'),'0',0);
    $pdf->Cell(4*1,$h,$XX[2],'1',0);

    $w=$pdf->GetStringWidth('Vehículo Fantasma');
    $pdf->Cell($w,$h,utf8_decode('Vehículo Fantasma'),'0',0);
    $pdf->Cell(4*1,$h,$XX[3],'1',0);

    $w=1+$pdf->GetStringWidth('Póliza Falsa');
    $pdf->Cell($w,$h,utf8_decode('Póliza Falsa'),'0',0);
    $pdf->Cell(4*1,$h,$XX[4],'1',0);

    $w=$pdf->GetStringWidth('Vehículo en Fuga');
    $pdf->Cell($w,$h,utf8_decode('Vehículo en Fuga'),'0',0);
    $pdf->Cell(4*1,$h,$XX[5],'1',0);

    $w=2+$pdf->GetStringWidth('Asegurado D.2497');
    $pdf->Cell($w,$h,utf8_decode('Asegurado D.2497'),'0',0);
    $pdf->Cell(4*1,$h,$XX[5],'1',0);

    $w=2+$pdf->GetStringWidth('Propietario Indeterminado');
    $pdf->Cell($w,$h,utf8_decode('Propietario Indeterminado'),'0',0);
    $pdf->Cell(4*1,$h,$XX[5],'1',0);
    
    $pdf->SetFont('arial','',8);    
    
    $pdf->SP(3);
    
    $pdf->Cell(4*3,$h,utf8_decode('Marca'),'0',0);
    $t=(empty($FURIPS->C_29)) ? '' : $FURIPS->C_29;
    $pdf->Cell(4*20,$h,utf8_decode($t),'1',0);
    $pdf->Cell(4*4,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*3,$h,utf8_decode('Placa'),'0',0);
    $t=(empty($FURIPS->C_30)) ? '      ' : $FURIPS->C_30;
    $pdf->Cuadricula($t);

    $pdf->SP(3);
    $T=array('','','','','','','');
    $T[$FURIPS->C_31]='X';
    
    $pdf->Cell(4*6,$h,utf8_decode('Tipo de Servicio: '),'0',0);
    $pdf->Cell(68,$h,utf8_decode($FURIPS->tipo_servicio),'1',0);
    $pdf->Cell(4,$h,'','0',0);
    $pdf->Cell(4*6,$h,utf8_decode('Tipo de Vehiculo: '),'0',0);
    $t=isset($campos[31]['values'][$FURIPS->C_31]) ? $campos[31]['values'][$FURIPS->C_31] : '';
    $pdf->Cell(60,$h,utf8_decode($t),'1',0); 
    
    $pdf->SP(3);
    $pdf->Cell(4*9,$h,utf8_decode('Nombre de la Aseguradora'),'0',0);
    $t=isset($campos[32]['values'][$FURIPS->C_32]) ? $campos[32]['values'][$FURIPS->C_32] : '';
    $t=str_pad($t,36,' ');
    $pdf->Cuadricula($t);
    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode('No. de la Poliza'),'0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_33,20));
    $pdf->Cell(4*2,$h,'','0',0);

    $pdf->SP(3);
    $pdf->Cell(4*7,$h,utf8_decode('Vigencia     Desde'),'0',0);
    $t=str_pad($FURIPS->C_34,8,' ');
    $pdf->Cuadricula($t);
    $pdf->Cell(4*3,$h,utf8_decode('  Hasta'),'0',0);
    $t=str_pad($FURIPS->C_35,8,' ');
    $pdf->Cuadricula($t);

    $pdf->Cell(4*3,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*9,$h,utf8_decode('Cobro Excedente Póliza'),'0',0);
    $i=array('S'=>'','N'=>'');
    $i[$FURIPS->C_37]='X';
    $pdf->Cell(4*1.5,$h,'SI','0',0);
    $pdf->Cell(4*1,$h,$i['S'],'1',0);
    $pdf->Cell(4*2,$h,'','0',0);
    $pdf->Cell(4*1.5,$h,'NO','0',0);
    $pdf->Cell(4*1,$h,$i['N'],'1',0);
    $pdf->SP(1,0);
    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('V. DATOS DEL PROPIETARIO DEL VEHICULO'),'1',1,'C',true);
    $pdf->SP(2);

    $pdf->SP(0);
    $t=(empty($FURIPS->C_46)) ? '' : $FURIPS->C_46;
    $pdf->Cell(4*21,$h,utf8_decode($t),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $t=(empty($FURIPS->C_47)) ? '' : $FURIPS->C_47;
    $pdf->Cell(4*21,$h,utf8_decode($t),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Apellido'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Apellido '),'0',0,'C');
    $pdf->SP(1);

    $pdf->SP(0);
    $t=(empty($FURIPS->C_48)) ? '' : $FURIPS->C_48;
    $pdf->Cell(4*21,$h,utf8_decode($t),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $t=(empty($FURIPS->C_49)) ? '' : $FURIPS->C_49;
    $pdf->Cell(4*21,$h,utf8_decode($t),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Nombre'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Nombre '),'0',0,'C');

    $pdf->SP(3);

    $TD=array('CC','CE','CD','DE','SC','PE','PT','NI');    
    foreach ($TD as $v) { if(isset($$v)) { unset($$v); } }
    $pdf->Cell(4*10,$h,utf8_decode('Tipo de Documento'),'0',0);
    $pdf->SetFont('arial','',6);
    if(!empty($FURIPS->C_44)){${$FURIPS->C_44}='1';}
    foreach($TD as $XX)
    {
        $pdf->Cell(4,$h,$XX,'1',0,'C');
        if(isset($$XX))
        {
            $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
            $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
        }
    }
    $pdf->SetFont('arial','',8);

    $pdf->Cell(4*6,$h,'','0',0);
    $pdf->Cell(4*7,$h,utf8_decode('No. Documento'),'0',0);
    $t=(empty($FURIPS->C_45)) ? '' : $FURIPS->C_45;
    $pdf->Cuadricula(str_pad($t,15,' ',STR_PAD_LEFT));

    $pdf->SP(1,0);
    $pdf->SP(2);
    $pdf->SP(0);

    $pdf->Cell(4*8,$h,utf8_decode('Dirección de Residencia'),'0',0);
    $t=(empty($FURIPS->C_50)) ? '' : $FURIPS->C_50;
    $pdf->Cuadricula(str_pad($t,38,' '));

    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Departamento'),'0',0);
    $t=(empty($DEPTOS[$FURIPS->C_52])) ? '' : $DEPTOS[$FURIPS->C_52];
    $pdf->Cuadricula(str_pad($t,21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    
    $t=(empty($FURIPS->C_52)) ? '  ' : $FURIPS->C_52;
    $pdf->Cuadricula($t);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*3,$h,'Telefono','0',0);
    $tel=(empty($FURIPS->C_51)) ? '' : $FURIPS->C_51;
    $pdf->Cuadricula(str_pad($tel,10,' '));

    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Municipio'),'0',0);
    $t=(empty($MUNS[$FURIPS->C_53])) ? '' : $MUNS[$FURIPS->C_53];
    $pdf->Cuadricula(str_pad($t,21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $t=(empty($FURIPS->C_53)) ? '   ' : $FURIPS->C_53;
    $pdf->Cuadricula($t);

    $pdf->SP(1,0);
    $pdf->Cell(0,1,utf8_decode(''),'BRL',1);

    $pdf->Cell((4*44)+2,$h,utf8_decode('Total Folios'),'0',0,'R');
    $pdf->Cuadricula(str_pad($FURIPS->folios,3,'0',STR_PAD_LEFT));

    $pdf->AddPage();
    $pdf->SetFont('arial','',8);
    $pdf->Cell(0,3,'PARTE B   ','0',1,'R');
    $pdf->SetFont('arial','B',8);

    $pdf->Image('../dist/img/furips/escudo.png',11,14,15);

    $pdf->Cell(0,$h,utf8_decode('REPUBLICA DE COLOMBIA'),'RTL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('MINISTERIO DE SALUD Y PROTECCIÓN SOCIAL'),'RL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('FORMULARIO ÚNICO DE RECLAMACIÓN DE LAS INSTITUCIONES PRESTADORAS DE SERVICIOS DE SALUD POR'),'RL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('SERVICIOS PRESTADOS A VICTIMAS DE EVENTOS CATASTRÓFICOS Y ACCIDENTES DE TRANSITO'),'RL',1,'C');
    $pdf->Cell(0,$h,utf8_decode('PRESTADORES DE SERVICIOS DE SALUD - FURIPS'),'RL',1,'C');
    $pdf->SetFont('arial','',8);
    $pdf->Cell(0,2,utf8_decode(''),'RL',1);

    $pdf->Cell(0,$h,utf8_decode('VI. DATOS DEL CONDUCTOR DEL VEHÍCULO INVOLUCRADO EN EL ACCIDENTE DE RANSITO'),'1',1,'C',true);
    $pdf->SP(2);

    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_54),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_55),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Apellido'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Apellido '),'0',0,'C');
    $pdf->SP(1);

    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_56),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_57),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Nombre'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Nombre '),'0',0,'C');

    $pdf->SP(3);
    //CC CE PA RC TI CD SC DE PE PT
    $TD=array('CC','CE','PA','RC','TI','CD','SC','DE','PE','PT');
    foreach($TD as $X){ if(isset($XX)) { unset($XX); } }
    $pdf->Cell(4*8,$h,utf8_decode('Tipo de Documento'),'0',0);
    $pdf->SetFont('arial','',6);

    ${$FURIPS->C_58}='1';
    foreach($TD as $XX)
    {
        $pdf->Cell(4,$h,$XX,'1',0,'C');
        if(isset($$XX))
        {
            if(!empty($FURIPS->C_58))
            {
                $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
                $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
            }
        }
    }

    $pdf->SetFont('arial','',8);

    $pdf->Cell(4*6,$h,'','0',0);
    $pdf->Cell(4*7,$h,utf8_decode('No. Documento'),'0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_59,15,' ',STR_PAD_LEFT));

    $pdf->SP(1,0);
    $pdf->SP(2);
    $pdf->SP(0);

    $pdf->Cell(4*8,$h,utf8_decode('Dirección de Residencia'),'0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_60,38,' '));

    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Departamento'),'0',0);
    $t=isset($DEPTOS[$FURIPS->C_61]) ? $DEPTOS[$FURIPS->C_61] : '';
    $pdf->Cuadricula(str_pad($t,21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $t=empty($FURIPS->C_61) ? '  ' : $FURIPS->C_61;
    $pdf->Cuadricula($t);
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*3,$h,'Telefono','0',0);
    $t=str_pad($FURIPS->C_63,10,' ',STR_PAD_LEFT);
    $pdf->Cuadricula($t);

    $pdf->SP(3);

    $pdf->Cell(4*6,$h,utf8_decode('Municipio'),'0',0);
    $t=isset($MUNS[$FURIPS->C_62]) ? $MUNS[$FURIPS->C_62] : '';
    $pdf->Cuadricula(str_pad($t,21,' '));
    $pdf->Cell(4*1,$h,'','0',0);
    $pdf->Cell(4*2,$h,'Cod.','0',0);
    $t=empty($FURIPS->C_62) ? '   ' : $FURIPS->C_62;
    $pdf->Cuadricula($t);

    $pdf->SP(1,0);
    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('VII. DATOS DE REMISION'),'1',1,'C',true);

    $pdf->SP(2);

    $pdf->SP(0);
    $R=array('','','');
    $R[$FURIPS->C_64]='X';
    $pdf->Cell(4*10,$h,utf8_decode('Tipo Referencia:'),'0',0);
    $pdf->Cell(4*4,$h,utf8_decode('Remisión'),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($R[1]),'1',0);
    $pdf->Cell(4*3,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*6,$h,utf8_decode('Orden de Servicio'),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($R[2]),'1',0);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Fecha remisión:'),'0',0);
    $t=(empty($FURIPS->C_65)) ? '        ' : $FURIPS->C_65;
    $pdf->Cuadricula($t);
    $pdf->Cell(4*2,$h,utf8_decode('a las'),'0',0);
    $t=(empty($FURIPS->C_66)) ? '    ' : $FURIPS->C_66;
    $pdf->Cuadricula($t);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Prestador que remite:'),'0',0);
    $IPS_REMITENTE='';
    if(!empty($FURIPS->C_67)){
        $sql="SELECT nombre FROM datos_ips WHERE hab='".$FURIPS->C_67."'";
        $stmt=$bd_furips->prepare($sql);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            $IPS_REMITENTE=$data['nombre'];
        }
    }

    $pdf->Cell(4*36,$h,$IPS_REMITENTE,'1',0);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Código de inscripción:'),'0',0);
    $codIps=str_pad($FURIPS->C_67,12,' ',STR_PAD_LEFT);
    $pdf->Cuadricula($codIps);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Profesional que remite:'),'0',0);
    $pdf->Cell(4*20,$h,utf8_decode($FURIPS->C_68),'1',0);
    $pdf->Cell(4*3,$h,utf8_decode('Cargo:'),'0',0);
    $pdf->Cell(4*13,$h,utf8_decode($FURIPS->C_69),'1',0);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Fecha aceptación:'),'0',0);
    $t=(empty($FURIPS->C_70)) ? '        ' : $FURIPS->C_70;
    $pdf->Cuadricula($t);
    $pdf->Cell(4*2,$h,utf8_decode('a las'),'0',0);
    $t=(empty($FURIPS->C_71)) ? '    ' : $FURIPS->C_71;
    $pdf->Cuadricula($t);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Prestador que recibe:'),'0',0);
    $IPS_REMITENTE='';
    if(!empty($FURIPS->C_72)){
        $sql="SELECT nombre FROM datos_ips WHERE hab='".$FURIPS->C_72."'";
        $stmt=$bd_furips->prepare($sql);
        $stmt->execute();
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            $IPS_REMITENTE=$data['nombre'];
        }
    }
    $pdf->Cell(4*36,$h,$IPS_REMITENTE,'1',0);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Código de inscripción:'),'0',0);
    $codIps=str_pad($FURIPS->C_72,12,' ',STR_PAD_LEFT);
    $pdf->Cuadricula($codIps);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Profesional que recibe:'),'0',0);
    $pdf->Cell(4*20,$h,utf8_decode($FURIPS->C_73),'1',0);
    $pdf->Cell(4*3,$h,utf8_decode('Cargo:'),'0',0);
    $pdf->Cell(4*13,$h,utf8_decode($FURIPS->C_74),'1',0);
    $pdf->SP(1,0);

    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('VIII. AMPARO DE TRANSPORTE Y MOVILIZACION DE LA VICTIMA'),'1',1,'C',true);
    $pdf->SP(2);

    $pdf->SP(0);
    $pdf->Cell(0,$h,utf8_decode('Diligenciar únicamente para el transporte desde el sitio del evento hasta la primera IPS (Transporte Primario)'),'0',0);
    $pdf->SP(3);

    $pdf->Cell(4*10,$h,utf8_decode('Datos de Vehículo:'),'0',0);
    $pdf->Cell(4*2,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*3,$h,utf8_decode('Placa No.'),'0',0);
    $pdf->Cell(4*2,$h,utf8_decode(''),'0',0);
    $pdf->Cuadricula((str_pad($FURIPS->C_75,6)));
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Transportó la victima desde:'),'0',0);
    $pdf->Cell(4*17,$h,utf8_decode($FURIPS->C_76),'1',0);
    $pdf->Cell(4*3,$h,utf8_decode('Hasta:'),'0',0);
    $pdf->Cell(4*16,$h,utf8_decode($FURIPS->C_77),'1',0);
    $pdf->SP(3);
    $pdf->Cell(4*10,$h,utf8_decode('Tipo de Transporte:'),'0',0);
    $pdf->Cell(4*7,$h,utf8_decode('Ambulancia Básica:'),'0',0);
    $x=array('','','');
    $x[$FURIPS->C_78]='X';
    $pdf->Cell(4*1,$h,utf8_decode($x[1]),'1',0);
    $pdf->Cell(4*8,$h,utf8_decode('Ambulancia Medicada:'),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($x[2]),'1',0);
    $pdf->Cell(4*1,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*11,$h,utf8_decode('Lugar donde recoge la Victima'),'0',0);

    $pdf->Cell(4*2,$h,utf8_decode('Zona'),'0',0);
    $U=($FURIPS->C_79=='U') ? 'X' : 'U';
    $R=($FURIPS->C_79=='R') ? 'X' : 'R';
    $pdf->Cell(4*1,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($U),'1',0);
    $pdf->Cell(4*1,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*1,$h,utf8_decode($R),'1',0);
    $pdf->SP(1,0);

    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('IX. CERTIFICADO DE LA ATENCIÓN MEDICA DE LA VICTIMA COMO PRUEBA DEL ACCIDENTE O EVENTO'),'1',1,'C',true);
    $pdf->SP(2);

    $pdf->SP(0);
    $pdf->Cell(4*8,$h,utf8_decode('Fecha Ingreso'),'0',0);
    $t=(empty($FURIPS->C_80)) ? '        ' : $FURIPS->C_80;
    $pdf->Cuadricula($t);    
    $pdf->Cell(4*3,$h,utf8_decode('a las'),'0',0,'C');
    $t=(empty($FURIPS->C_81)) ? '        ' : $FURIPS->C_81;
    $pdf->Cuadricula($t);
    $pdf->Cell(4*8,$h,utf8_decode('Fecha Egreso'),'0',0,'C');
    $t=(empty($FURIPS->C_82)) ? '        ' : $FURIPS->C_82;
    $pdf->Cuadricula($t);
    $pdf->Cell(4*3,$h,utf8_decode('a las'),'0',0,'C');
    $t=(empty($FURIPS->C_83)) ? '        ' : $FURIPS->C_83;
    $pdf->Cuadricula($t);

    $pdf->SP(3);

    $pdf->Cell(4*15,$h,utf8_decode('Código Diagnóstico principal de Ingreso'),'1',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_84,4,' '));
    $pdf->Cell(4*5,$h,'','0',0);
    $pdf->Cell(4*15,$h,utf8_decode('Código Diagnóstico principal de Egreso'),'1',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_85,4,' '));
    $pdf->SP(3);
    $pdf->Cell(4*15,$h,utf8_decode('Otro código Diagnóstico principal de Ingreso'),'1',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_86,4,' '));
    $pdf->Cell(4*5,$h,'','0',0);
    $pdf->Cell(4*15,$h,utf8_decode('Otro código Diagnóstico principal de Egreso'),'1',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_87,4,' '));
    $pdf->SP(3);
    $pdf->Cell(4*15,$h,utf8_decode('Otro código Diagnóstico principal de Ingreso'),'1',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_88,4,' '));
    $pdf->Cell(4*5,$h,'','0',0);
    $pdf->Cell(4*15,$h,utf8_decode('Otro código Diagnóstico principal de Egreso'),'1',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_89,4,' '));

    $pdf->SP(1,0);
    $pdf->SP(2); $pdf->SP(2); $pdf->SP(2); $pdf->SP(2);
    $pdf->SP(0);

    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_90),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_91),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Apellido del Médico o Profesional tratante'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Apellido del Médico o Profesional tratante '),'0',0,'C');
    $pdf->SP(1);

    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_92),'1',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode($FURIPS->C_93),'1',0,'C');
    $pdf->SP(1);
    $pdf->SP(0);
    $pdf->Cell(4*21,$h,utf8_decode('1er. Nombre del Médico o Profesional tratante'),'0',0,'C');
    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*21,$h,utf8_decode('2do. Nombre del Médeco o Profesional tratante '),'0',0,'C');

    $pdf->SP(3);

    $pdf->Cell(4*11,$h,utf8_decode('Tipo de Documento'),'0',0);
    $pdf->SetFont('arial','',6);
    $TD=array('CC','CE','PA','PE','PT');
    ${$FURIPS->C_94}='1';
    foreach($TD as $XX)
    {
        $pdf->Cell(4,$h,$XX,'1',0,'C');
        if(isset($$XX))
        {
            $pdf->Line($pdf->GetX()-4,$pdf->GetY(),$pdf->GetX(),$pdf->GetY()+4);
            $pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX()-4,$pdf->GetY()+4);
        }
    }
    $pdf->SetFont('arial','',8);

    $pdf->Cell(4*4,$h,'','0',0);
    $pdf->Cell(4*7,$h,utf8_decode('Número Documento'),'0',0);
    $pdf->Cell(4*3,$h,'','0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_95,15,' ',STR_PAD_LEFT));

    $pdf->SP(3);

    $pdf->Cell(4*20,$h,'','0',0);
    $pdf->Cell(4*7,$h,utf8_decode('Número de Registro Médico'),'0',0);
    $pdf->Cell(4*3,$h,'','0',0);
    $pdf->Cuadricula(str_pad($FURIPS->C_96,15,' ',STR_PAD_LEFT));

    $pdf->SP(1,0);
    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('X. AMPAROS QUE RECLAMA'),'1',1,'C',true);
    $pdf->SP(2);
    $pdf->SP(0);

    $pdf->Cell(4*16,$h,'','0',0);
    $pdf->Cell(4*10,$h,utf8_decode('Valor total facturado'),'1',0);
    $pdf->Cell(4*10,$h,utf8_decode('Valor reclamado al FOSYGA'),'1',0);
    $pdf->SP(3);

    $pdf->Cell(4*16,$h,utf8_decode('Gastos Medicos Qururgicos'),'1',0);
    $pdf->Cell(4*10,$h,'$'.number_format($FURIPS->C_97,0,',','.'),'1',0,'C');
    $pdf->Cell(4*10,$h,'$'.number_format($FURIPS->C_98,0,',','.'),'1',0,'C');
    $pdf->SP(3);

    $pdf->Cell(4*16,$h,utf8_decode('Gastos de transporte y movilización de la víctima'),'1',0);
    $pdf->Cell(4*10,$h,'$'.number_format($FURIPS->C_99,0,',','.'),'1',0,'C');
    $pdf->Cell(4*10,$h,'$'.number_format($FURIPS->C_100,0,',','.'),'1',0,'C');
    $pdf->SP(3);

    $t='El total facturado y reclamado descrito en este numeral se debe detallar y hacer descripcion de las actividades, procedimientos, medicamentos, insumos, suministros, materiales, dentro del anexo técnico numero 2';

    $Detalle=dividir($t,150);
    for($i=0;$i<=4;$i++)
    {   
        if(isset($Detalle[$i]) && !empty($Detalle[$i]))
        {   
            if($i>0)
            $pdf->SP(0);
            $pdf->Cell(4*46,$h,utf8_decode($Detalle[$i]),'',0);
            $pdf->SP(1);
        }
    }

    $pdf->SP(2);
    $pdf->Cell(0,$h,utf8_decode('XI. DECLARACIONES DE LA INSTITUCION PRESTADORA DE SERVICIOS DE SALUD.'),'1',1,'C',true);
    $pdf->SP(2);

    $t='Como representante legal o Gerente de la Institución Prestadora de Servicios de Salud, declaró bajo la gavedad de juramento que toda la información contenidad en este formulario es cierta y podrá se verificada por la Compañía de Seguros, por la Dirección de Administracion de Fondos de la Protección Social o quien haga sus veces, por el Administrador Fiduciario del Fondo de Solidaridad y Garantía Fosyga, por la Superintendencia Nacional de Salud o la Contraloria General de la República de no ser así, acepto todas las consecuencias legales que produzca esta situación. Adicionalmente, manifiesto que la reclamación no ha sido presentada con anterioridad ni se ha recibido pago alguno por las sumas reclamadas.';
    $pdf->MultiCell(0,$h,utf8_decode($t),'LR','J');

    $pdf->Image('../dist/img/furips/firma.jpg',120,$pdf->GetY()+8,50);
    $pdf->Cell(0,15,utf8_decode(''),'RL',1);
    $pdf->SP(0);
    $pdf->Cell(4*20,$h,utf8_decode('NOMBRE'),'T',0,'C');
    $pdf->Cell(4*6,$h,utf8_decode(''),'0',0);
    $pdf->Cell(4*20,$h,utf8_decode('FIRMA DEL REPRESENTANTE LEGAL O GERENTE'),'T',0,'C');
    $pdf->SP(1,0);
    $pdf->Cell(0,2,utf8_decode(''),'BRL',0,'C');

    
    $pdf->Output();

?>