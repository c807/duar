<?php if (isset($productos)):
    $a = (isset($aumenta)) ? $aumenta : 1;
    
?>
<?php foreach ($productos as $row):?>
<tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $row->nombre; ?></td>
    <td><?php echo $row->nombre_proveedor; ?></td>
    <td><?php echo $row->codproducto; ?></td>
    <td><?php echo $row->descripcion; ?></td>
    <td><?php echo $row->descripcion_generica; ?></td>
    <td><?php echo $row->funcion; ?></td>

    <td scope="row">
        <div class="custom-control custom-checkbox center-check">
            <input type="checkbox" class="custom-control-input" id="check_tlc"
                <?php if ($row->tlc == 1){ echo 'checked';} ?> onclick="return false">
        </div>
    </td>

    <td scope="row">
        <div class="custom-control custom-checkbox  center-check">
            <input type="checkbox" class="custom-control-input" id="check_permiso"
                <?php if ($row->permiso == 1){ echo 'checked';} ?> onclick="return false">
        </div>
    </td>


    <td scope="row">
        <div class="custom-control custom-checkbox  center-check">
            <input type="checkbox" class="custom-control-input" id="check_fito"
                <?php if ($row->fito == 1){ echo 'checked';} ?> onclick="return false">
        </div>
    </td>

    <td><?php echo $row->partida; ?></td>
    <td><?php echo $row->paisorigen ?></td>
    <td><?php echo formatoFecha($row->fecha, 2); ?></td>

    <td>

        <a href='#crear_producto' onclick="mostrar(2)" class="btn btn-primary btn-xs" title="Editar Producto" data-id=""
            data-toggle="modal" data-whatever="EDITAR PRODUCTO" data-book-id="<?php  echo $row->producimport;?>"
            data-book-id1="<?php echo $row->importador;?>" data-book-id2="<?php echo $row->codproducto;?>"
            data-book-id3="<?php echo $row->descripcion;?>" data-book-id4="<?php echo $row->descripcion_generica;?>"
            data-book-id5="<?php echo $row->funcion;?>" data-book-id6="<?php echo $row->partida;?>"
            data-book-id7="<?php echo $row->observaciones;?>" data-book-id8="<?php echo $row->permiso; ?> "
            data-book-id9="<?php echo $row->tlc; ?> " data-book-id10="<?php echo $row->nombre_proveedor; ?>"
            data-book-id14="<?php echo $row->marca; ?>" data-book-id16="<?php echo  $row->paisorigen ?>"
            data-book-id17="<?php echo  $row->fito ?>" data-book-id18="<?php echo  $row->idestado ?>"
            data-book-id19="<?php echo  $row->idunidad ?>" data-book-id20="<?php echo  $row->pais_procedencia ?>"
            data-book-id21="<?php echo  $row->pais_adquisicion ?>">

            <i class="glyphicon glyphicon-edit"></i> </a>
    </td>
    <td>
        <a href='#borrar_producto' onclick="datos_borrar(3)" class="btn btn-default btn-xs" title="Eliminar"
            data-toggle="modal" data-book-id="<?php echo trim($row->codproducto); ?>"
            data-book-id1="<?php echo trim($row->descripcion);?>" data-book-id2="<?php echo $row->producimport;?>">
            <i class="glyphicon glyphicon-trash"></i> </a>

    </td>
    <td>
        <a href='#verficha' onclick="mostrarficha()" class="btn btn-default btn-xs" title="Visualizar Ficha" data-id=""
            data-toggle="modal" data-book-id="<?php  echo $row->producimport;?>"
            data-book-id1="<?php echo $row->importador;?>" data-book-id2="<?php echo $row->codproducto;?>"
            data-book-id3="<?php echo $row->descripcion;?>" data-book-id4="<?php echo $row->descripcion_generica;?>"
            data-book-id5="<?php echo $row->funcion;?>" data-book-id6="<?php echo $row->partida;?>"
            data-book-id7="<?php echo $row->observaciones;?>" data-book-id8="<?php echo $row->permiso; ?> "
            data-book-id9="<?php echo $row->tlc; ?> " data-book-id10="<?php echo $row->nombre_proveedor; ?>"
            data-book-id11="<?php echo $row->peso_neto; ?>" data-book-id12="<?php echo $row->numeros; ?>"
            data-book-id13="<?php echo $row->no_bultos; ?>" data-book-id14="<?php echo $row->marca; ?>"
            data-book-id15="<?php echo ""?>" data-book-id16="<?php echo  $row->paisorigen ?>"
            data-book-id17="<?php echo  $row->nombre_pais ?>" data-book-id18="<?php echo "" ?>"
            data-book-id19="<?php echo  $row->nombre ?>">
            <i class="glyphicon glyphicon-list"></i> </a>

    </td>
</tr>
<?php endforeach ?>
<?php endif ?>

<?php if (isset($cantidad)): ?>
<tr id="cargarMas">
    <td colspan="100%">
        <p class="text-center" id="textocargar">
            <a href="javascript:;" onclick="vermas(<?php echo $cantidad; ?>)">Mostrar Más</a>
        </p>
    </td>
</tr>

<?php endif ?>