<select name="u_comercial" id="u_comercial" class="form-control chosen">

    <?php foreach ($u_comercial as $row): ?>

    <option value="<?php echo $row->idunidad; ?>"><?php echo  $row->idunidad.' - '.$row->descripcion; ?></option>

    <?php endforeach ?>

</select>
