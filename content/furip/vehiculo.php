<div class="row row-bottom-margin">
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-shield-alt"></i></div>
            <select class="form-control" id="vEstado" name="vEstado">
                <option selected disabled value="-1">Estado de Aseguramiento</option>
                <option value="1">Asegurado</option>
                <option value="2">No Asegurado</option>
                <option value="3">Vehiculo Fantasma</option>
                <option value="4">Poliza Falsa</option>
                <option value="5">Vehiculo en Fuga</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-car"></i></div>
            <input type="text" class="form-control" title="Marca Vehiculo" id="vMarca" name="vMarca" placeholder="Marca Vehiculo">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-hashtag"></i></i></div>
            <input type="text" class="form-control" title="Placa Vehiculo" id="vPlaca" name="vPlaca" placeholder="Placa Vehiculo">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-taxi"></i></div>
            <select class="form-control" id="vServicio" name="vServicio">
                <option selected disabled value="-1">Tipo Servicio</option>
                <option value="3">Particular</option>
                <option value="4">Público</option>
                <option value="5">Oficial</option>
                <option value="6">De emergencia</option>
                <option value="7">Diplomático o consular</option>
                <option value="8">Transporte Masivo</option>
                <option value="9">Escolar</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-user-shield"></i></div>
            <select class="form-control" id="vCodigoSOAT" name="vCodigoSOAT">
                <option selected disabled value="-1">Aseguradora</option>
                <option value="13-15">Allianz Colombia</option>
                <option value="36937">Aseguradora Solidaria de Colombia</option>
                <option value="13-61">Axa Colpatria</option>
                <option value="13-17">Seguros Mundial</option>
                <option value="14-29">La Equidad</option>
                <option value="14-23">La Previsora</option>
                <option value="13-33">Liberty Seguros</option>
                <option value="13-26">MAPFRE</option>
                <option value="14-07">Seguros Bolivar</option>
                <option value="14-19">Seguros del Estado</option>
                <option value="14-28">SURA</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-qrcode"></i></div>
            <input type="text" class="form-control" id="vPoliza" name="vPoliza" placeholder="Nro Poliza">
        </div>
    </div>

    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="far fa-calendar-check"></i></div>
            <input type="date" class="form-control" data-toggle="tooltip" data-placement="top" title="F. Inicial Poliza" id="vFini" name="vFini" placeholder="F. Inicial Poliza">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <div class="input-group-addon"><i class="far fa-calendar-times"></i></div>
            <input type="date" class="form-control last-ctrl" data-toggle="tooltip" data-placement="top" title="F. Final Poliza" id="vFfin" name="vFfin" placeholder="F. Final Poliza">
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-gavel"></i></div>
            <select class="form-control" data-toggle="tooltip" data-placement="top" title="Intervencion Autoridad" id="vInterv" name="vInterv">
                <option selected value="N">NO</option>
                <option value="S">SI</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-dollar-sign"></i></div>
            <select class="form-control" data-toggle="tooltip" data-placement="top" title="Cobro Excedente" id="vCobro" name="vCobro">
                <option selected value="N">NO</option>
                <option value="S">SI</option>
            </select>
        </div>
    </div>
</div>