
<select name="tipobulto" id="tipobulto" class="form-control">          

<?php     
     
if (isset($_SESSION['tb_seleccionado']))
{
 $id=$_SESSION['tb_seleccionado'];

}else
{
   $id="";
}

$id=$_POST['tipobulto'];
  foreach($tipobulto as $row){
    
?>   

     <option value="<?php echo $row->codigo; ?>" <?php if($row->codigo==$id) echo 'selected';?>><?php echo $row->codigo.' - '.$row->descripcion;?></option>
 <?php
 }

?>
</select>

<script>

$(".chosen").chosen( { width: "50%"} );

</script>
