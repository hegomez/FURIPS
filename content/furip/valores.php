<div class="row row-bottom-margin">
    <div class="col-md-4 col-md-offset-4"><strong>Valor Total Facturado</strong></div>
    <div class="col-md-4"><strong>Valor Reclamado al ADRES</strong></div>
</div>
<div class="row row-bottom-margin">
    <div class="col-md-4">Gastos Medicos Quirurgicos</div>
    <div class="col-md-4">
        <?php echo frmControl(97,'placeholder'); ?>
    </div>
    <div class="col-md-4">
        <?php echo frmControl(98,'placeholder'); ?>
    </div>
</div>
<div class="row row-bottom-margin">
    <div class="col-md-4">Gastosde transporte y movilizacion</div>
    <div class="col-md-4">
        <?php echo frmControl(99,'placeholder'); ?>
    </div>
    <div class="col-md-4">
        <?php echo frmControl(100,'placeholder'); ?>
    </div>
</div>
<div class="row row-bottom-margin">    
    <div class="col-md-4">
    <strong>Servicios Habilitados</strong>
    </div>
    <div class="col-md-4">
    <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-user"></i></div>
            <?php echo frmControl(101,'tooltip'); ?>
        </div>
    </div> 
    <div class="col-md-4">
        <button type="submit" onclick="GenerateFURIPS()" class="btn btn-info btn-block btn-flat"><i class="fa fa-bell"></i> CREAR FURIP</button>
    </div>
</div>