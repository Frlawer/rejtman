<fieldset>
    <div class="form-group">
        <label for="nombre">Area *</label>
          <input type="text" name="area_id" value="<?php echo htmlspecialchars($edit ? $cita['area_id'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Area id" class="form-control" required="required" id = "area" >
    </div> 

    <div class="form-group">
        <label for="apellido">Abogada *</label>
        <input type="text" name="abogada_id" value="<?php echo htmlspecialchars($edit ? $cita['abogada_id'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Abogada id" class="form-control" required="required" id="abogada_id">
    </div> 

    <div class="form-group">
        <label for="nombre">Nombre</label>
            <input  type="text" name="cita_nombre" value="<?php echo htmlspecialchars($edit ? $cita['cita_nombre'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Nombre" class="form-control" id="nombre">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
            <input name="cita_email" value="<?php echo htmlspecialchars($edit ? $cita['cita_email'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="email@email.com" class="form-control"  type="email" id="email">
    </div> 

    <div class="form-group">
        <label for="tel">Teléfono</label>
            <input name="cita_tel" value="<?php echo htmlspecialchars($edit ? $cita['cita_tel'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="987654321" class="form-control"  type="text" id="tel">
    </div> 

    <div class="form-group">
        <label>Fecha</label>
        <input name="cita_fecha" value="<?php echo htmlspecialchars($edit ? $cita['cita_fecha'] : '', ENT_QUOTES, 'UTF-8'); ?>"  placeholder="2020-12-28" class="form-control"  type="text" id="dir" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
    </div>

    <div class="form-group">
        <label>Horario</label>
        <input name="horario_id" value="<?php echo htmlspecialchars($edit ? $cita['horario_id'] : '', ENT_QUOTES, 'UTF-8'); ?>"  placeholder="Horario id" class="form-control"  type="text" id="horario">
    </div>

    <div class="form-group">
        <label>Descripción</label>
        <textarea name="cita_desc" value="<?php echo htmlspecialchars($edit ? $cita['cita_desc'] : '', ENT_QUOTES, 'UTF-8'); ?>"  placeholder="Descripción" class="form-control" id="horario"><?php echo htmlspecialchars($edit ? $cita['cita_desc'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Guardar <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>
