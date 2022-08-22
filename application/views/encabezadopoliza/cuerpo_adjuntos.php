<?php
    if (isset($l_adjuntos)) {
        foreach ($l_adjuntos as $row) { $ref=trim($row->referencia);  $referencia="'$ref'";  ?>
<tr>
    <td><?php echo $row->item; ?></td>
    <td><?php echo $row->tipodocumento; ?></td>
    <td><?php echo $row->referencia; ?></td>
    <td><?php echo $row->fecha_documento; ?></td>
    <td><?php echo $row->fecha_expiracion; ?></td>
    <td><?php echo $row->id_pais; ?></td>
    <td><?php echo $row->id_entidad; ?></td>
    <td><?php echo $row->monto_autorizado; ?></td>

    <td>
        <button class="btn btn-default btn-xs" onclick="consulta_adjunto(<?php echo $row->documento; ?>)"><i
                title="Editar documento adjunto" class="glyphicon glyphicon-edit"></i></button>
    </td>
    <td>
        <button class="btn btn-default btn-xs" onclick="eliminar_adjunto(<?php echo $row->documento; ?>)"><i
                title="Eliminar documento adjunto" class="glyphicon glyphicon-trash"></i></button>
    </td>

    <td>

    <button class="btn btn-default btn-xs" onclick="dowload_adjunto(<?php echo str_replace('%20',' ', $row->documento); ?> , <?php echo $referencia ; ?>)"><i
                title="Ver documento adjunto" class="glyphicon glyphicon-arrow-down"></i></button>
                <!--
        <button class="btn btn-default btn-xs" onclick="dowload_adjunto(<?php echo $row->documento; ?> , <?php echo $row->referencia; ?>)"><i
                title="Ver documento adjunto" class="glyphicon glyphicon-arrow-down"></i></button> -->
    </td>
<td> 


</td>
</tr>
<?php
    }
}
?>