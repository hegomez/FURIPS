<div class="row row-bottom-margin">
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-hashtag"></i></i></div>
            <input type="text" class="form-control" id="tPlaca" name="tPlaca" placeholder="Placa Vehiculo">
        </div>
    </div>
</div>
<div class="row row-bottom-margin">
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-external-link-alt"></i></div>
            <input type="text" class="form-control" id="tDesde" name="tDesde" placeholder="Transporte Desde" value="">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-external-link-alt fa-rotate-180"></i></div>
            <input type="text" class="form-control" id="tHasta" name="tHasta" placeholder="Transporte Hasta" value="">
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-ambulance"></i></div>
            <select class="form-control" id="tAmb" name="tAmb">
                <option selected disabled value="-1">Tipo de Ambulancia</option>
                <option value="1">Ambulancia básica</option>
                <option value="2">Ambulancia medicalizada</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
            <select class="form-control" id="tZona" name="tZona">
                <option selected disabled value="-1">Zona</option>
                <option value="U">Urbana</option>
                <option value="R">Rural</option>
            </select>
        </div>
    </div>
</div>