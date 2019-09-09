<div class="container-fluid" id="prueba">
    <div class="col-md-7">
        <ul class="list-group">
            <li class="list-group-item ">
                <form action="<?php echo $action; ?>" class="form-horizontal" method="post"
                    onsubmit="enviaredicion(this); return false;">
                   
                    <?php echo $action; ?>
                    <?php echo $idprod; ?>
                    <div class="form-group form-group-sm">
                        <?php echo $lab_codigo; ?>
                        <div class="col-md-4">
                            <?php echo $codigo; ?>
                        </div>

                        <?php echo $lab_partida; ?>
                        <div class="col-md-4">
                            <?php echo $partida; ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <?php echo $lab_pneto; ?>
                        <div class="col-md-4">
                            <?php echo $pneto; ?>
                        </div>

                        <?php echo $lab_origen; ?>
                        <div class="col-md-4">
                            <?php echo $origen; ?>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <?php echo $lab_tipbulto; ?>
                        <div class="col-md-4">
                            <?php echo $tipbulto; ?>
                        </div>

                        <?php echo $lab_nobulto; ?>
                        <div class="col-md-4">
                            <?php echo $nobulto; ?>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <?php echo $lab_numeros; ?>
                        <div class="col-md-4">
                            <?php echo $numeros; ?>
                        </div>

                        <?php echo $lab_marca; ?>
                        <div class="col-md-4">
                            <?php echo $marca; ?>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <?php echo $lab_descripcion; ?>
                        <div class="col-md-4">
                            <?php echo $descripcion; ?>
                        </div>

                        <?php echo $lab_descripcion_generica; ?>
                        <div class="col-md-4">
                            <?php echo $descripcion_generica; ?>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <?php echo $lab_funcion; ?>
                        <div class="col-md-4">
                            <?php echo $funcion; ?>
                        </div>

                        <?php echo $lab_observaciones; ?>
                        <div class="col-md-4">
                            <?php echo $observaciones; ?>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <?php echo $lab_nombre_proveedor; ?>
                        <div class="col-md-10">
                            <?php echo $nombre_proveedor; ?>
                        </div>
                    </div>

                    <div class="div">
                        <label class="col-sm-2 "></label>
                        <div class="col-md-3">
                            <div class="row">
                                <label><?php echo $tlc; ?> Aplica TLC</label>
                               
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <label><?php echo $permiso; ?> Permiso</label>
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <label><?php echo $importador; ?> Importador</label>
                            </div>

                        </div>
                    </div><br><br><br>
                    <div class="row ">
                    <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <button class="btn btn-success btnsuccess btn-md pull-right"> <i class="glyphicon glyphicon-edit"></i> Actualizar
                                Información</button>
                         </div>
                         <div >       
                            <button type="button" class="btn btn-default btn-md pull-left" onclick="cerrar('formedita')"> <i
                                    class="glyphicon glyphicon-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </div>

    <div class="col-md-5">
        <ul class="list-group">
            <li class="list-group-item">
                <?php if ($informacion): ?>
                <h5 class="text-center"><b><?php echo $informacion->nombre; ?></b></h5>
                <div class="row">

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-tag"></i> Producto:</b>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->descripcion; ?>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-barcode"></i> Código:</b>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->codproducto; ?> <br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-star"></i> Marca:</b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->marca; ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-registration-mark"></i> Partida:</b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->partida; ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-indent-right"></i> Peso Neto: </b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->peso_neto; ?><br>
                    </div>


                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-th"></i> Numeros: </b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->numeros; ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-certificate"></i> Tipo Bulto:</b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->nombrebulto ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-th"></i> Número de Bultos:</b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->no_bultos ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-road"></i> País de Origen</b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo $informacion->npaisorigen ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-calendar"></i> Fecha: </b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo formatoFecha($informacion->fecha, 2); ?><br>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-wrench"></i> Aplica TLC: </b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo ($informacion->tlc == 1) ? 'SI' : 'NO'; ?>
                    </div>

                    <div class="col-sm-5">
                        <b><i class="glyphicon glyphicon-ok"></i> Permiso: </b> <br>
                    </div>

                    <div class="col-sm-7">
                        <?php echo ($informacion->permiso == 1) ? 'SI' : 'NO'; ?>
                    </div>

                </div>

                <?php endif ?>

            </li>
        </ul>
    </div>
</div>