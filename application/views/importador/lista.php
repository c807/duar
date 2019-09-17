
<?php if (isset($productos)):  
	$a = (isset($aumenta)) ? $aumenta : 1;
?>
<?php foreach ($productos as $row): ?>
<tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $row->nombre; ?></td>
    <td><?php echo $row->nombre_proveedor; ?></td>
    <td><?php echo $row->codproducto; ?></td>
    <td><?php echo $row->descripcion; ?></td>
    <td><?php echo $row->descripcion_generica; ?></td>
    <td><?php echo $row->funcion; ?></td>
    <td><b><?php $res = ($row->tlc == 1) ? '&#10003;' : 'x'; echo $res; ?></b></td>
    <td><b><?php $res = ($row->permiso == 1) ? '&#10003;' : 'x'; echo $res; ?></b></td>
    <td><?php echo $row->partida; ?></td>
    <td><?php echo $row->paisorigen ?></td>
    <td><?php echo formatoFecha($row->fecha, 2); ?></td>

    <!-- <td><a href="#formedita" class="btn btn-default btn-xs" onclick="editarprod(<?php echo $row->producimport;?>);"
            title="Editar "><i class="glyphicon glyphicon-edit"></i></a></td>-->

    <td>

        <a href='#crear_producto' onclick="mostrar()" class="btn btn-primary btn-xs" title="Editar Producto" data-id=""
            data-toggle="modal" data-whatever="EDITAR PRODUCTO" style="margin-left:2px;"
            data-book-id="<?php  echo $row->producimport;?>" data-book-id1="<?php echo $row->importador;?>"
            data-book-id2="<?php echo $row->codproducto;?>" data-book-id3="<?php echo $row->descripcion;?>"
            data-book-id4="<?php echo $row->descripcion_generica;?>" data-book-id5="<?php echo $row->funcion;?>"
            data-book-id6="<?php echo $row->partida;?>" data-book-id7="<?php echo $row->observaciones;?>"
            data-book-id8="<?php echo $row->permiso; ?> " data-book-id9="<?php echo $row->tlc; ?> "
            data-book-id10="<?php echo $row->nombre_proveedor; ?>" data-book-id11="<?php echo $row->peso_neto; ?>"
            data-book-id12="<?php echo $row->numeros; ?>" data-book-id13="<?php echo $row->no_bultos; ?>"
            data-book-id14="<?php echo $row->marca; ?>" data-book-id15="<?php echo  $row->tipo_bulto ?>"
            data-book-id16="<?php echo  $row->paisorigen ?>">
            <i class="glyphicon glyphicon-edit"></i> </a>

        <a href='#borrar_producto' class="btn btn-default btn-xs" title="Eliminar " data-toggle="modal"
            style="margin-left:2px;" data-book-id="<?php echo trim($row->codproducto); ?>"
            data-book-id1="<?php echo trim($row->descripcion);?>">
            <i class="glyphicon glyphicon-trash"></i> </a>

            

            <a href='#verficha'  onclick="mostrarficha()" class="btn btn-default btn-xs" title="Visualizar Ficha" data-id=""
            data-toggle="modal"  style="margin-left:2px;"
            data-book-id="<?php  echo $row->producimport;?>" data-book-id1="<?php echo $row->importador;?>"
            data-book-id2="<?php echo $row->codproducto;?>" data-book-id3="<?php echo $row->descripcion;?>"
            data-book-id4="<?php echo $row->descripcion_generica;?>" data-book-id5="<?php echo $row->funcion;?>"
            data-book-id6="<?php echo $row->partida;?>" data-book-id7="<?php echo $row->observaciones;?>"
            data-book-id8="<?php echo $row->permiso; ?> " data-book-id9="<?php echo $row->tlc; ?> "
            data-book-id10="<?php echo $row->nombre_proveedor; ?>" data-book-id11="<?php echo $row->peso_neto; ?>"
            data-book-id12="<?php echo $row->numeros; ?>" data-book-id13="<?php echo $row->no_bultos; ?>"
            data-book-id14="<?php echo $row->marca; ?>" data-book-id15="<?php echo  $row->tipo_bulto ?>"
            data-book-id16="<?php echo  $row->paisorigen ?>"
            data-book-id17="<?php echo  $row->nombre_pais ?>"
            data-book-id18="<?php echo  $row->descripcion_bulto ?>"
            data-book-id19="<?php echo  $row->nombre ?>">
            <i class="glyphicon glyphicon-edit"></i> </a>

    </td>
</tr>
<?php endforeach ?>
<?php endif ?>

<?php if(isset($cantidad)): ?>
<tr id="cargarMas">
    <td colspan="100%">
        <p class="text-center" id="textocargar">
            <a href="javascript:;" onclick="vermas(<?php echo $cantidad; ?>)">Mostrar Más</a>
        </p>
    </td>
</tr>
<?php endif ?>