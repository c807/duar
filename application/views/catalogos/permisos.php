<select name="catalogopermisos" id="catalogopermisos" class="form-control chosen">

    <?php foreach ($catalogopermisos as $row): ?>

    <option value="<?php echo $row->idpermiso; ?>"><?php echo  $row->idpermiso.' - '.$row->descripcion; ?></option>

    <?php endforeach ?>

</select>
