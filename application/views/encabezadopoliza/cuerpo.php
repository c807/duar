<?php 
if (isset($l_items)) {
foreach ($l_items as $row) { ?>
<tr>
    
    <td><?php echo $row->item; ?></td>
    <td><?php echo $row->tipo_bulto; ?></td>
    <td><?php echo $row->no_bultos; ?></td>
    <td><?php echo $row->precio_item; ?></td>
    <td><?php echo $row->flete_interno; ?></td>
    <td><?php echo $row->flete_externo; ?></td>
    <td><?php echo $row->descripcion; ?></td>
    <td><?php echo $row->marcas_uno; ?></td>

    <td>
    <button class="btn btn-default btn-xs" onclick="consulta_item(<?php echo $row->detalle; ?>)"><i
                class="glyphicon glyphicon-edit"></i></button>
    </td>
    <td>
        <button class="btn btn-default btn-xs" onclick="eliminar_item(<?php echo $row->detalle; ?>)"><i
                class="glyphicon glyphicon-trash"></i></button>
    </td>
   
    <td>
        
    
    <a href='#add_adjuntos'  onclick="get_item_adjunto()" class="btn btn-default btn-xs" title="Documentos Adjuntos" data-id=""
            data-toggle="modal"  style="margin-left:2px;"
            data-book-id="<?php  echo $row->item;?>" 
            data-book-id1="<?php echo  $row->duaduana ?>">
            <i class="glyphicon glyphicon-paperclip"></i></a>
    </td>
</tr>
<?php
}
}
?>