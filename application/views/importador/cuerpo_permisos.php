<?php
if (isset($lista_p)) {
   $c=1;
    foreach ($lista_p as $row) { ?>
<tr>
    <td><?php echo $row->idpermiso; ?></td>
    <td><?php echo $row->descripcion; ?></td>
    <td>
        <button class="btn btn-default btn-xs" onclick="eliminar_permiso(<?php echo $row->id; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
    </td>
</tr>
<?php
    $c=$c+1;
}
}
?>

