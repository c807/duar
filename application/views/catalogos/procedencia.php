<select name="pais_procedencia" id="pais_procedencia" class="form-control chosen">

    <?php foreach ($paises as $row): ?>

    <option value="<?php echo $row->id_pais; ?>"><?php echo  $row->id_pais.' - '.$row->nombre; ?></option>

    <?php endforeach ?>

</select>
