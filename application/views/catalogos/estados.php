<select name="estados" id="estados" class="form-control chosen">

    <?php foreach ($estados as $row): ?>

    <option value="<?php echo $row->idestado; ?>"><?php echo  $row->idestado.' - '.$row->descripcion; ?></option>

    <?php endforeach ?>

</select>

<script>

</script>