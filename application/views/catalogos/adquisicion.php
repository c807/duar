<select name="pais_adquisicion" id="pais_adquisicion" class="form-control chosen">

    <?php foreach ($paises as $row): ?>

    <option value="<?php echo $row->id_pais; ?>"><?php echo  $row->id_pais.' - '.$row->nombre; ?></option>

    <?php endforeach ?>

</select>
