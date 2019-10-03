
<select name="tipobulto" id="tipobulto" class="form-control chosen">          

<?php     
 


  foreach($tipobulto as $row){
    
?>   

     <option value="<?php echo $row->codigo; ?>" <?php if($row->codigo==$id) echo 'selected';?>><?php echo $row->codigo.' - '.$row->descripcion;?></option>
 <?php
 }

?>
</select>

<script>

$(".chosen").chosen( { width: "100%"} );

</script>
