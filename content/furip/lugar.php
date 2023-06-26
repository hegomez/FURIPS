<div class="row row-bottom-margin">
    <div class="col-md-12">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-file-signature"></i></div>
            <select class="form-control" name="lNatu" id="lNatu" data-toggle="tooltip" data-placement="top" title="" data-original-title="Naturaleza del Evento">
                <option disabled="" selected="" value="-1">...</option>
                <option value="0">Accidente de Transito</option>
                <option value="1">Sismo</option>
                <option value="2">Maremoto</option>
                <option value="3">Erupciones Volcánicas</option>
                <option value="4">Huracán</option>
                <option value="5">Inundaciones</option>
                <option value="6">Avalancha</option>
                <option value="7">Deslizamiento de Tierra</option>
                <option value="8">Incendio natural</option>
                <option value="9">Rayo</option>
                <option value="10">Vendaval</option>
                <option value="11">Tornado</option>
                <option value="12">Explosión</option>
                <option value="13">Masacre</option>
                <option value="14">Mina Antipersonal</option>
                <option value="15">Combate</option>
                <option value="16">Incendio</option>
                <option value="17">Ataques Terroristas</option>
                <option value="18">Otro</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-file-signature"></i></div>
            <input type="text" class="form-control" name="lNatuO" id="lNatuO" placeholder="Otra Naturaleza del Evento" value="">
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-map-signs"></i></div>
            <input type="text" class="form-control" name="lDire" id="lDire" placeholder="Dirección de Ocurrencia" value="">
        </div>
    </div>
    <div class="col-md-7">
        <div class="input-group">
            <div class="input-group-addon"><i class="far fa-calendar-alt"></i></div>
            <input type="date" class="form-control" name="lFecha" id="lFecha" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fecha de Evento">
        </div>
    </div>
    <div class="col-md-5">
        <div class="input-group">
            <div class="input-group-addon"><i class="far fa-clock"></i></div>
            <input type="time" class="form-control" name="lHora" id="lHora" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hora de Evento">
        </div>
    </div>
    <div class="col-md-5">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
            <select class="form-control" name="vDepto" id="lDepto">
                <option disabled="" selected="" value="-1">Departamento</option>
            </select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
            <select class="form-control" name="vMunic" id="lMunic">
                <option disabled="" selected="" value="-1">Municipio</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon"><i class="fas fa-map-marker-alt"></i></div>
            <select class="form-control" name="vMunic" id="lMunic" data-toggle="tooltip" data-placement="top" title="" data-original-title="Zona">
                <option disabled="" selected="" value="-1">..</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group">
            <div class="input-group-addon"><i class="far fa-edit"></i></div>
            <textarea class="form-control" name="lDesc" id="lDesc" placeholder="Descripción del Evento o Accidente" rows="3"></textarea>
        </div>
    </div>
</div>