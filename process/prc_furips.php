<?php
    echo '<pre>'.print_r($_POST,true).'</pre>';
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
    }
    echo json_encode($response);