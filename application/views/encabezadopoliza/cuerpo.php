<?php
if (isset($l_items)) {
    $c = 1;
    foreach ($l_items as $row) { ?>
        <tr>

            <td><?php echo $row->item; ?></td>
            <td><?php echo $row->tipo_bulto; ?></td>
            <td><?php echo $row->no_bultos; ?></td>
            <td><?php echo $row->precio_item; ?></td>
            <td><?php echo $row->origen; ?></td>
            <td><?php echo $row->peso_bruto; ?></td>
            <td><?php echo $row->peso_neto; ?></td>
            <td><?php echo $row->codigo_preferencia; ?></td>
            <td><?php echo $row->descripcion; ?></td>
            <td><?php echo $row->marcas_uno; ?></td>
            <td><?php echo $row->doc_transp; ?></td>
            <th scope="row">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="<?php echo 'chk' . $c ?>">
                   
                </div>
            </th>
            <td>
                <button class="btn btn-default btn-xs" onclick="consulta_item(<?php echo $row->detalle; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
            </td>
            <td>
                <button class="btn btn-default btn-xs" onclick="eliminar_item(<?php echo $row->detalle; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
            </td>
            <td>
                <a href='#add_adjuntos' onclick="get_item_adjunto()" class="btn btn-default btn-xs" title="Documentos Adjuntos" data-id="" data-toggle="modal" style="margin-left:2px;" data-book-id="<?php echo $row->item; ?>" data-book-id1="<?php echo  $row->duaduana ?>">
                    <i class="glyphicon glyphicon-paperclip"></i></a>
            </td>
        </tr>
<?php
        $c = $c + 1;
    }
}
?>




<!-- Modal -->
<div class="modal fade" id="addPermisoModalc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">CARGAR ADJUNTOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group form-group-sm">
                                <div class="col-md-3">
                                    <input type="file" name="file_up" id="file_up" class="w-50" required accept=".pdf" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"  name="btn_up" id="btn_up" onclick="cargar_adjunto_masivo()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
