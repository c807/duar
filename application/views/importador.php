
<select name="importador" id="importador" class="form-control chosen">

<?php foreach ($importador as $row): ?>    

    <option value="<?php echo $row->no_identificacion; ?>"><?php echo $row->nombre; ?></option>

<?php endforeach ?>

</select>



<script>

$(".chosen").chosen( { width: "100%"} );

</script>