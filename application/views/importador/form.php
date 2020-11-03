<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <script src="<?php echo base_url('public/js/importador.js') ?>"></script>
<script  type="text/javascript" src="<?php echo base_url('public/js/productos.js') ?>"></script>
</head>

<body>
    <form class="navbar-form navbar-left " role="search" method="get" action="<?php echo $action; ?>" id="formproducto"
        onsubmit="enviarformproducto(this); return false;">
        <div class="form-group">
            <input type="hidden" value="0" name="inicio" id="inicio">
            <input type="text" class="form-control" placeholder="Razón Social ..." name="importador" required>
            <button type="submit" class="btn btn-success btn-sm">
                <i class="glyphicon glyphicon-search"></i>
            </button>

           <!-- <button type="button" class="btn btn-primary btn-md pull-center" data-toggle="modal" data-target="#upModal">
                <i class="glyphicon glyphicon-open" title="Importar productos desde archivo  Excel"></i>
                Productos</button> -->
                <button type="button" class="btn btn-primary btn-md pull-center"  onclick="modal_producto_importador(7)">
                <i class="glyphicon glyphicon-open"></i>Productos</button> 

          <!--  <button type="button" class="btn btn-success btn-md pull-center btnsuccess" data-toggle="modal"
                data-target="#crear_producto" data-whatever="AGREGAR PRODUCTO">
                <i class="glyphicon glyphicon-plus" title="Agregar un nuevo producto"></i> Agregar</button> -->

                <button type="button" class="btn btn-success btn-md pull-center btnsuccess"  onclick="modal_producto_importador(1)">
                <i class="glyphicon glyphicon-plus"></i>Agregar</button> 

            <button type="button" class="btn btn-success btn-md pull-center btnsuccess"  onclick="modal_producto_importador(6)">
                <i class="glyphicon glyphicon-list"></i></button> 
                
        </div>

    </form>
    
</body>

</html>

<script>

//cambia header de modal: Agrgar /Editar
$(document).ready(function() {

    $('#crear_producto').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')

        var modal = $(this)
        modal.find('.modal-title').text(recipient)

    });
});
</script>


<script>
$('#tbld').toggle();
</script>
