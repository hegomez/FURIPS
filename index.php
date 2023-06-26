<?php
	require_once('inc/func.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Formatos | WEB</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-vertical-tabs.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
	<header class="main-header">
		<a href="index.php" class="logo">
			<span class="logo-mini"><b>F</b>W</span>
			<span class="logo-lg"><b>Formatos</b>Web</span>
		</a>
		<nav class="navbar navbar-static-top">
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<i class="fas fa-bars"></i>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="dist/img/avatar.jpg" class="user-image" alt="User Image">
							<span class="hidden-xs">Administrador </span>
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<p>
                                	Administrador<small>FURIP</small>
								</p>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<aside class="main-sidebar">
		<section class="sidebar">
			<ul class="sidebar-menu" data-widget="tree">
				<li class="header">FORMATOS</li>
				<li>
					<a href="index.php">
						<i class="fa fa-th"></i> <span>FURIP</span>
					</a>
				</li>
			</ul>
		</section>
	</aside>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				FURIPS
				<small>Formulario para su Diligenciamiento</small>
			</h1>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-md-8">
					<div class="box">
						<div class="box-body">
							<div class="col-md-4">
								<?php
									$Titulo=array(
										''=>array('INICIAL','fas fa-plus-circle'),
										'I.'=>array('INSTITUCION','fas fa-building'),
										'II.'=>array('VICTIMA','fas fa-user-injured'),
										'III.'=>array('LUGAR','fas fa-map-marker-alt'),
										'IV.'=>array('VEHICULO','fas fa-car-crash'),
										'V.'=>array('PROPIETARIO','fas fa-user-tie'),
										'VI.'=>array('CONDUCTOR','fas fa-user'),
										'VII.'=>array('REMISION','fas fa-file-medical'),
										'VIII.'=>array('TRANSPORTE','fas fa-ambulance'),
										'IX.'=>array('ATENCION','fas fa-notes-medical'),
										'X.'=>array('VALORES','fas fa-file-invoice-dollar')
									);
								?>
								<ul class="nav nav-tabs tabs-left">
									<?php foreach( $Titulo as $key => $data ){ ?>
										<li class="<?php if(empty($key)){ echo 'active'; } ?>">
											<a href="#tab-<?php echo $data[0]; ?>" data-toggle="tab"><i class="<?php echo $data[1] ?>"></i> <?php echo $key.' '.$data[0]; ?></a>
										</li>
									<?php } ?>
								</ul>
							</div>
							<div class="col-md-8">
								<div class="tab-content">
									<?php
										$i=0;
										foreach( $Titulo as $key => $data ){
											$active=($i==0)?'active':'';
											echo'<div class="tab-pane '.$active.'" id="tab-'.$data[0].'">';
											include('content/furip/'.strtolower($data[0]).'.php');
											echo '</div>';
											$i++;
										}
									?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
				</div>
			</div>
		</section>
	</div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>Version</b> 2.4.18
		</div>
		<strong>PLantilla <a href="https://adminlte.io">AdminLTE</a>.</strong> 
	</footer>
	<div class="control-sidebar-bg"></div>
</div>

<script src="bower_components/jquery/dist/jquery.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script>
	$(document).ready(function () {
		$('.sidebar-menu').tree();
	})
	
	$(document).on('click','.checkbox',function(){
		let miscasillas=document.getElementById('RG');
		$("#RG").prop('checked', $("#RG").prop("checked"));
		console.log($("#RG").prop('checked'));
		if($(this).hasClass('checked')){
			$(this).removeClass('checked');
		}else{
			$(this).addClass('checked');
		}
	});
	
</script>
</body>
</html>

