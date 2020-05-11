<?php
    if (isset($l_equipamiento)) {
        foreach ($l_equipamiento as $row) { ?>
<tr>
    <td><?php echo $row->item; ?></td>
    <td><?php echo $row->id_equipamiento; ?></td>
    <td><?php echo $row->numero_paquetes; ?></td>
    <td><?php echo $row->tara; ?></td>
    <td><?php echo $row->peso_mercancias; ?></td>
    

    <td>
        <button class="btn btn-default btn-xs" onclick="consulta_equipamiento(<?php echo $row->equipamiento; ?>)"><i
                title="Editar equipamiento" class="glyphicon glyphicon-edit"></i></button>
    </td>

    <td>
        <button class="btn btn-default btn-xs" onclick="eliminar_equipamiento(<?php echo $row->equipamiento; ?>)"><i
              tile="Eliminar equipamiento"  class="glyphicon glyphicon-trash"></i></button>
    </td>
</tr>
<?php
    }
}
?>