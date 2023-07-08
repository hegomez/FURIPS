<?php
    //echo '<pre>'.print_r($_POST,true).'</pre>';
    require_once('../inc/conn.php');
    $response=array();
    if(isset($_POST['action'])){
        if($_POST['action']=='getDepartamentos'){
            $sql="SELECT * FROM departamentos";
            $stmt=$bd_furips->prepare($sql);
            $stmt->execute();
            $data=$stmt->fetchAll();
            $response['data']=$data;
        }
        if($_POST['action']=='getMunicipios'){
            $sql="SELECT uid,nombre from municipio where cod_depto=:id_depto";
            $stmt=$bd_furips->prepare($sql);
            $stmt->bindParam(':id_depto',$_POST['departamento']);
            $stmt->execute();
            $data=$stmt->fetchAll();
            $response['data']=$data;
        }
        if($_POST['action']=='search_ips'){
            $keyword = $_POST['keyword'];
            $query = "SELECT * FROM datos_ips WHERE nombre like '%{$keyword}%' ORDER BY nombre ASC LIMIT 10";
            $stmt = $bd_furips->prepare($query);
            $stmt->execute();
            //$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        if($_POST['action']=='saveFURIPS'){
            $Factura=$_POST['data']['C_3'];
            //Verifico que solo exista un registro por factura en la tabla furips_pdf
            $sql="SELECT count(factura) as cant FROM furips_pdf WHERE factura=:factura";
            $stmt=$bd_furips->prepare($sql);
            $stmt->bindParam(':factura',$Factura);
            $stmt->execute();
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            if($data['cant']>0){
                $sqlPDF="UPDATE furips_pdf SET nombre_ips=:nombre_ips,nit_ips=:nit_ips,desc_evento=:desc_evento,tipo_servicio=:tipo_servicio,folios=:folios WHERE factura=:factura";
            } else {
                $sqlPDF="INSERT INTO furips_pdf (nombre_ips,nit_ips,desc_evento,factura,tipo_servicio,folios) VALUES (:nombre_ips,:nit_ips,:desc_evento,:factura,:tipo_servicio,:folios)";
            }
            $nombre_ips=$_POST['data']['NomIPS'];
            unset($_POST['data']['NomIPS']);
            $nit_ips=$_POST['data']['NitIPS'];
            unset($_POST['data']['NitIPS']);
            $desc_evento=$_POST['data']['descEvent'];
            unset($_POST['data']['descEvent']);
            $tipo_servicio=$_POST['data']['tipo_servicio'];
            unset($_POST['data']['tipo_servicio']);
            $folios=$_POST['data']['folios'];
            unset($_POST['data']['folios']);

            $stmtPDF=$bd_furips->prepare($sqlPDF);
            $stmtPDF->bindParam(':nombre_ips',$nombre_ips);
            $stmtPDF->bindParam(':nit_ips',$nit_ips);
            $stmtPDF->bindParam(':desc_evento',$desc_evento);
            $stmtPDF->bindParam(':factura',$Factura);
            $stmtPDF->bindParam(':tipo_servicio',$tipo_servicio);
            $stmtPDF->bindParam(':folios',$folios);
            $stmtPDF->execute();
            
            //convertir de formato yyyy-mm-dd a dd/mm/yyyy C_12,C_13,C_23,C_34,C_35,C_65,C_70,C_80,C_82 si no estan vacios
            foreach($_POST['data'] as $key=>$value){
                if($value!=''){
                    if($key=='C_12' || $key=='C_13' || $key=='C_23' || $key=='C_34' || $key=='C_35' || $key=='C_65' || $key=='C_70' || $key=='C_80' || $key=='C_82'){
                        $date = new DateTime($value);
                        $_POST['data'][$key]=$date->format('d/m/Y');
                    }
                }
            }

            //Verifico que solo exista un registro por factura en la tabla furips_1
            $sql="SELECT count(C_3) as cant FROM furips_1 WHERE C_3=:factura";
            $sqlFURIPS1='';
            $stmt=$bd_furips->prepare($sql);
            $stmt->bindParam(':factura',$Factura);
            $stmt->execute();
            $data=$stmt->fetch(PDO::FETCH_ASSOC);
            if($data['cant']>0){
                $sqlFURIPS1="UPDATE furips_1 SET ";
                for($i=1;$i<=101;$i++){
                    if($i!=3)
                    $sqlFURIPS1.="C_{$i}=:C_{$i},";
                }
                $sqlFURIPS1=substr($sqlFURIPS1,0,-1);
                $sqlFURIPS1.=" WHERE C_3=:C_3";
            } else {
                $sqlFURIPS1="INSERT INTO furips_1 (";
                for($i=1;$i<=101;$i++){
                    $sqlFURIPS1.="C_{$i},";
                }
                $sqlFURIPS1=substr($sqlFURIPS1,0,-1);
                $sqlFURIPS1.=") VALUES (";
                for($i=1;$i<=101;$i++){
                    $sqlFURIPS1.=":C_{$i},";
                }
                $sqlFURIPS1=substr($sqlFURIPS1,0,-1);
                $sqlFURIPS1.=")";
            }
            $stmtFURIPS1=$bd_furips->prepare($sqlFURIPS1);
            $stmtFURIPS1->bindParam(':C_1',$_POST['data']['C_1']);
            $stmtFURIPS1->bindParam(':C_2',$_POST['data']['C_2']);
            $stmtFURIPS1->bindParam(':C_3',$_POST['data']['C_3']);
            $stmtFURIPS1->bindParam(':C_4',$_POST['data']['C_4']);
            $stmtFURIPS1->bindParam(':C_5',$_POST['data']['C_5']);
            $stmtFURIPS1->bindParam(':C_6',$_POST['data']['C_6']);
            $stmtFURIPS1->bindParam(':C_7',$_POST['data']['C_7']);
            $stmtFURIPS1->bindParam(':C_8',$_POST['data']['C_8']);
            $stmtFURIPS1->bindParam(':C_9',$_POST['data']['C_9']);
            $stmtFURIPS1->bindParam(':C_10',$_POST['data']['C_10']);
            $stmtFURIPS1->bindParam(':C_11',$_POST['data']['C_11']);
            $stmtFURIPS1->bindParam(':C_12',$_POST['data']['C_12']);
            $stmtFURIPS1->bindParam(':C_13',$_POST['data']['C_13']);
            $stmtFURIPS1->bindParam(':C_14',$_POST['data']['C_14']);
            $stmtFURIPS1->bindParam(':C_15',$_POST['data']['C_15']);
            $stmtFURIPS1->bindParam(':C_16',$_POST['data']['C_16']);
            $stmtFURIPS1->bindParam(':C_17',$_POST['data']['C_17']);
            $stmtFURIPS1->bindParam(':C_18',$_POST['data']['C_18']);
            $stmtFURIPS1->bindParam(':C_19',$_POST['data']['C_19']);
            $stmtFURIPS1->bindParam(':C_20',$_POST['data']['C_20']);
            $stmtFURIPS1->bindParam(':C_21',$_POST['data']['C_21']);
            $stmtFURIPS1->bindParam(':C_22',$_POST['data']['C_22']);
            $stmtFURIPS1->bindParam(':C_23',$_POST['data']['C_23']);
            $stmtFURIPS1->bindParam(':C_24',$_POST['data']['C_24']);
            $stmtFURIPS1->bindParam(':C_25',$_POST['data']['C_25']);
            $stmtFURIPS1->bindParam(':C_26',$_POST['data']['C_26']);
            $stmtFURIPS1->bindParam(':C_27',$_POST['data']['C_27']);
            $stmtFURIPS1->bindParam(':C_28',$_POST['data']['C_28']);
            $stmtFURIPS1->bindParam(':C_29',$_POST['data']['C_29']);
            $stmtFURIPS1->bindParam(':C_30',$_POST['data']['C_30']);
            $stmtFURIPS1->bindParam(':C_31',$_POST['data']['C_31']);
            $stmtFURIPS1->bindParam(':C_32',$_POST['data']['C_32']);
            $stmtFURIPS1->bindParam(':C_33',$_POST['data']['C_33']);
            $stmtFURIPS1->bindParam(':C_34',$_POST['data']['C_34']);
            $stmtFURIPS1->bindParam(':C_35',$_POST['data']['C_35']);
            $stmtFURIPS1->bindParam(':C_36',$_POST['data']['C_36']);
            $stmtFURIPS1->bindParam(':C_37',$_POST['data']['C_37']);
            $stmtFURIPS1->bindParam(':C_38',$_POST['data']['C_38']);
            $stmtFURIPS1->bindParam(':C_39',$_POST['data']['C_39']);
            $stmtFURIPS1->bindParam(':C_40',$_POST['data']['C_40']);
            $stmtFURIPS1->bindParam(':C_41',$_POST['data']['C_41']);
            $stmtFURIPS1->bindParam(':C_42',$_POST['data']['C_42']);
            $stmtFURIPS1->bindParam(':C_43',$_POST['data']['C_43']);
            $stmtFURIPS1->bindParam(':C_44',$_POST['data']['C_44']);
            $stmtFURIPS1->bindParam(':C_45',$_POST['data']['C_45']);
            $stmtFURIPS1->bindParam(':C_46',$_POST['data']['C_46']);
            $stmtFURIPS1->bindParam(':C_47',$_POST['data']['C_47']);
            $stmtFURIPS1->bindParam(':C_48',$_POST['data']['C_48']);
            $stmtFURIPS1->bindParam(':C_49',$_POST['data']['C_49']);
            $stmtFURIPS1->bindParam(':C_50',$_POST['data']['C_50']);
            $stmtFURIPS1->bindParam(':C_51',$_POST['data']['C_51']);
            $stmtFURIPS1->bindParam(':C_52',$_POST['data']['C_52']);
            $stmtFURIPS1->bindParam(':C_53',$_POST['data']['C_53']);
            $stmtFURIPS1->bindParam(':C_54',$_POST['data']['C_54']);
            $stmtFURIPS1->bindParam(':C_55',$_POST['data']['C_55']);
            $stmtFURIPS1->bindParam(':C_56',$_POST['data']['C_56']);
            $stmtFURIPS1->bindParam(':C_57',$_POST['data']['C_57']);
            $stmtFURIPS1->bindParam(':C_58',$_POST['data']['C_58']);
            $stmtFURIPS1->bindParam(':C_59',$_POST['data']['C_59']);
            $stmtFURIPS1->bindParam(':C_60',$_POST['data']['C_60']);
            $stmtFURIPS1->bindParam(':C_61',$_POST['data']['C_61']);
            $stmtFURIPS1->bindParam(':C_62',$_POST['data']['C_62']);
            $stmtFURIPS1->bindParam(':C_63',$_POST['data']['C_63']);
            $stmtFURIPS1->bindParam(':C_64',$_POST['data']['C_64']);
            $stmtFURIPS1->bindParam(':C_65',$_POST['data']['C_65']);
            $stmtFURIPS1->bindParam(':C_66',$_POST['data']['C_66']);
            $stmtFURIPS1->bindParam(':C_67',$_POST['data']['C_67']);
            $stmtFURIPS1->bindParam(':C_68',$_POST['data']['C_68']);
            $stmtFURIPS1->bindParam(':C_69',$_POST['data']['C_69']);
            $stmtFURIPS1->bindParam(':C_70',$_POST['data']['C_70']);
            $stmtFURIPS1->bindParam(':C_71',$_POST['data']['C_71']);
            $stmtFURIPS1->bindParam(':C_72',$_POST['data']['C_72']);
            $stmtFURIPS1->bindParam(':C_73',$_POST['data']['C_73']);
            $stmtFURIPS1->bindParam(':C_74',$_POST['data']['C_74']);
            $stmtFURIPS1->bindParam(':C_75',$_POST['data']['C_75']);
            $stmtFURIPS1->bindParam(':C_76',$_POST['data']['C_76']);
            $stmtFURIPS1->bindParam(':C_77',$_POST['data']['C_77']);
            $stmtFURIPS1->bindParam(':C_78',$_POST['data']['C_78']);
            $stmtFURIPS1->bindParam(':C_79',$_POST['data']['C_79']);
            $stmtFURIPS1->bindParam(':C_80',$_POST['data']['C_80']);
            $stmtFURIPS1->bindParam(':C_81',$_POST['data']['C_81']);
            $stmtFURIPS1->bindParam(':C_82',$_POST['data']['C_82']);
            $stmtFURIPS1->bindParam(':C_83',$_POST['data']['C_83']);
            $stmtFURIPS1->bindParam(':C_84',$_POST['data']['C_84']);
            $stmtFURIPS1->bindParam(':C_85',$_POST['data']['C_85']);
            $stmtFURIPS1->bindParam(':C_86',$_POST['data']['C_86']);
            $stmtFURIPS1->bindParam(':C_87',$_POST['data']['C_87']);
            $stmtFURIPS1->bindParam(':C_88',$_POST['data']['C_88']);
            $stmtFURIPS1->bindParam(':C_89',$_POST['data']['C_89']);
            $stmtFURIPS1->bindParam(':C_90',$_POST['data']['C_90']);
            $stmtFURIPS1->bindParam(':C_91',$_POST['data']['C_91']);
            $stmtFURIPS1->bindParam(':C_92',$_POST['data']['C_92']);
            $stmtFURIPS1->bindParam(':C_93',$_POST['data']['C_93']);
            $stmtFURIPS1->bindParam(':C_94',$_POST['data']['C_94']);
            $stmtFURIPS1->bindParam(':C_95',$_POST['data']['C_95']);
            $stmtFURIPS1->bindParam(':C_96',$_POST['data']['C_96']);
            $stmtFURIPS1->bindParam(':C_97',$_POST['data']['C_97']);
            $stmtFURIPS1->bindParam(':C_98',$_POST['data']['C_98']);
            $stmtFURIPS1->bindParam(':C_99',$_POST['data']['C_99']);
            $stmtFURIPS1->bindParam(':C_100',$_POST['data']['C_100']);
            $stmtFURIPS1->bindParam(':C_101',$_POST['data']['C_101']);

            $stmtFURIPS1->execute();
            $response['status']='success';
            $response['ID']=$Factura;
        }
    }
    echo json_encode($response);