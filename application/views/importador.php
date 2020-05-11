
<select name="importador" id="importador" class="chosen" data-placeholder="Seleccione...">


<?php foreach ($importador as $row): ?>    
      <option value="<?php echo $row->no_identificacion; ?>"><?php echo  $row->no_identificacion.' - '.$row->nombre; ?></option>

<?php endforeach ?>

</select>

