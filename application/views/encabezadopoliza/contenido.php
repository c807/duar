<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Declaracion de Mercancias</title>
    <style>
        .size {
            width: 20%;
        }

        .size2 {
            width: 25%;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" id="titulo">Declarión de Mercancias<span id="defile"></span>
            </div>
            <div class="panel-body" id="contmodelo">

                <div class="wrap w-100">
                    <ul class="tabs">
                        <li><a href="#tab1"><span class="fa fa-home"></span><span class="tab-text">Segmento
                                    General</span></a>
                        </li>
                        <li><a href="#tab2"><span class="fa fa-group"></span><span class="tab-text">Items</span></a>
                        </li>
                        <!--  <li><a href="#tab3"><span class="fa fa-briefcase"></span><span
                                    class="tab-text">Adjuntos</span></a></li> -->
                        <li><a href="#tab4"><span class="fa fa-bookmark"></span><span class="tab-text">Equipamiento</span></a>
                        </li>
                        <li><a href="#tab5"><span class="fa fa-bookmark"></span><span class="tab-text">xml</span></a>
                    </ul>


                    <div class="secciones">
                        <article id="tab1">
                            <!--Segmento General-->
                            <div class="container-fluid">
                                <form enctype="multipart/form-data" class="form_sg" id="form_sg" action="javascript:guardar_seg_general(<?php echo "'" . $_SESSION['numero_file'] . "'" ?>)">

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="aduana_registro" class="control-label">Número de Póliza
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control input-sm" id="id_dua" name="id_dua" readonly value="<?php echo $duaduana; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="aduana_registro" class="control-label">Aduana de
                                                        Registro</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="aduana_registro" id="aduana_registro" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($aduanas as $row) : ?>
                                                            <option value="<?php echo $row->codigo; ?>">
                                                                <?php echo  $row->codigo . ' - ' . $row->nombre; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="manifiesto" class="control-label ">Manifiesto</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control input-sm" id="manifiesto" name="manifiesto" placeholder="Manifiesto">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="aduana_entrada_salida" class="control-label">Aduana
                                                        Entrada/Salida</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="aduana_entrada_salida" id="aduana_entrada_salida" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($aduanas as $row) : ?>
                                                            <option value="<?php echo $row->codigo; ?>">
                                                                <?php echo  $row->codigo . ' - ' . $row->nombre; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="modelo" class="control-label">Modelo de
                                                        Declaración</label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="modelo" id="selectmod" class="chosen" data-placeholder="Seleccione..." onchange="dependencia(1, this.value, 'selectregext',1)">
                                                        <option value=""></option>
                                                        <?php foreach ($modelos as $row) {
                                                            echo "<option value='{$row->codigo}'>{$row->codigo} - {$row->descripcion}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="reg_extendido" class="control-label">Régimen</label>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <select name="reg_extendido" id="selectregext" class="chosen" data-placeholder="Seleccione..." onchange="dependencia(2, this.value, 'selectregadi',1)">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="nit_exportador" class="control-label ">Exportador</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control input-sm" id="nit_exportador" name="nit_exportador" placeholder="Exportador">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control input-sm" id="nombre_exportador" name="nombre_exportador" placeholder="Nombre exportador">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="nit_consignatario" class="control-label">Consignatario</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control input-sm" id="nit_consignatario" name="nit_consignatario" placeholder="NIT consignatario">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control input-sm" id="consignatario" name="consignatario" placeholder="Consignatario">
                                                    <!--
                                                    <select name="consignatario" id="consignatario"
                                                        class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($empresas as $row) {
                                                            echo "<option value='{$row->cod_empresa}'>{$row->cod_empresa} - {$row->nombre}</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                    -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="declarante" class="control-label ">Declarante</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="declarante" name="declarante" placeholder="Declarante" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="pais_export" class="control-label">Pais de
                                                        Exportación</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="pais_export" id="pais_export" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($paises as $row) : ?>
                                                            <option value="<?php echo $row->id_pais; ?>">
                                                                <?php echo  $row->id_pais . ' - ' . $row->nombre; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="registro_transportista" class="control-label ">Registro
                                                        Transportista/Medio</label>
                                                </div>
                                                <div class="col-md-2 " style="padding-right: 2">
                                                    <input type="text" class="form-control input-sm" name="registro_transportista" id="registro_transportista" placeholder="Registro transportista">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 " style="padding-left: 0;margin-top:2px">
                                            <select name="pais_reg_tm" id="pais_reg_tm" class="form-control chosen" data-placeholder="Seleccione...">
                                                <option value=""></option>
                                                <?php foreach ($paises as $row) : ?>
                                                    <option value="<?php echo $row->id_pais; ?>">
                                                        <?php echo  $row->id_pais . ' - ' . $row->nombre; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group form-group-sm">
                                            <div class="col-md-3 text-left size">
                                                <label for="registro_nac_medio" class="control-label ">Registro y
                                                    nacionalidad del medio</label>
                                            </div>
                                            <div class="col-md-2" style="padding-right: 2">
                                                <input type="text" class="form-control input-sm" name="registro_nac_medio" id="registro_nac_medio" placeholder="Registro y nacionalidad del medio">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="incoterm" class="control-label">Incoterms</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="incoterm" id="incoterm" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($incoterm as $row) {
                                                            echo "<option value='{$row->CODIGO}'>{$row->CODIGO} - {$row->DESCRIPCION}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="total_facturar" class="control-label">Total
                                                        Factura</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="total_facturar" name="total_facturar" placeholder="Ingrese Monto" min="0" step="0.01">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="flete_interno" class="control-label">Flete
                                                        Interno</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="flete_interno" name="flete_interno" placeholder="Ingrese Monto" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="flete_externo" class="control-label">Flete
                                                        Externo</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="flete_externo" name="flete_externo" placeholder="Ingrese Monto" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="seguro" class="control-label">Seguro</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="seguro" name="seguro" placeholder="Ingrese Monto" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="otros" class="control-label">Otros Costos</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="otros" name="otros" placeholder="Ingrese Monto" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="deducciones" class="control-label">Deduccciones</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="deducciones" name="deducciones" placeholder="deducciones" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="localizacion_mercancia" class="control-label">Localizacion</label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="localizacion_mercancia" id="localizacion_mercancia" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($localmercancia as $row) {
                                                            echo "<option value='{$row->codigo}'>{$row->codigo} - {$row->descripcion}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="bultos" class="control-label">Total de bultos</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="bultos" name="bultos" placeholder="bultos" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="referencia" class="control-label">Referencia de la
                                                        DUCA</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="referencia" name="referencia" placeholder="referencia" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="pais_proc" class="control-label">Pais de
                                                        procedencia</label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="pais_proc" id="pais_proc" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($paises as $row) : ?>
                                                            <option value="<?php echo $row->id_pais; ?>">
                                                                <?php echo  $row->id_pais . ' - ' . $row->nombre; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="pais_destino" class="control-label">Pais de
                                                        destino</label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="pais_destino" id="pais_destino" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($paises as $row) : ?>
                                                            <option value="<?php echo $row->id_pais; ?>">
                                                                <?php echo  $row->id_pais . ' - ' . $row->nombre; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="mod_transp" class="control-label">Modo de
                                                        Transporte</label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="mod_transp" id="mod_transp" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($modotransporte as $row) : ?>
                                                            <option value="<?php echo $row->codigo; ?>">
                                                                <?php echo  $row->codigo . ' - ' . $row->nombre; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="pais_transporte" class="control-label">Lugar de
                                                        desembarque</label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="pais_transporte" id="pais_transporte" class="chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($paises as $row) {
                                                            echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="lugar_carga" class="control-label"> </label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="lugar_carga" id="lugar_carga" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($lugardecarga as $row) : ?>
                                                            <option value="<?php echo $row->codigo; ?>">
                                                                <?php echo  $row->codigo . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="presentacion" class="control-label">Modalidad de Pago
                                                    </label>
                                                </div>
                                                <div class="col-md-6 offset-md-4">
                                                    <select name="presentacion" id="presentacion" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($presentacion as $row) : ?>
                                                            <option value="<?php echo $row->codigo; ?>">
                                                                <?php echo  $row->codigo . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-3 text-left size">
                                                    <label for="info_adicional" class="control-label">Información
                                                        Adicional</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" rows="3" id="info_adicional" name="info_adicional" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-5">
                                            <button class="btn btn-success btn-sm">Guardar</button>
                                        </div>

                                    </div>
                                </form>

                            </div> <!-- fin container segmento general-->
                            <br>


                        </article>

                        <article id="tab2">
                            <!--Items-->
                            <div class="container-fluid">
                                <form enctype="multipart/form-data" class="form_item" id="form_item">
                                    <div class="row">
                                        <!--
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label">Item</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control input-sm" id="item"
                                                        name="item" placeholder="Item" min="0" step="1">
                                                </div>
                                            </div>
                                        </div>
                                    -->

                                        <input type="hidden" id="file_number" name="file_number" value="<?php echo  $_SESSION["numero_file"]; ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Marcas y Números
                                                    1</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control input-sm" id="marcas_num_uno" name="marcas_num_uno">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Marcas y Números
                                                    2</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control input-sm" id="marcas_num_dos" name="marcas_num_dos">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Número de
                                                    Paquetes</label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control input-sm" id="numero_paquetes" name="numero_paquetes" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Embalaje</label>
                                                <div class="col-sm-7">
                                                    <select name="embalaje" id="embalaje" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($tipoBulto as $row) : ?>
                                                            <option value="<?php echo $row->codigo; ?>">
                                                                <?php echo  $row->codigo . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div style="background:#A5CF61; padding:10px; border-radius:5px;margin-bottom:5px">

                                                <div class="form-group row">
                                                    <label class="col-sm-5 control-label text-left">Código de
                                                        Mercancia</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control input-sm" id="codigo_mercancia" name="codigo_mercancia">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-5 control-label text-left">Descripción
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control input-sm" id="descripcion_comercial" name="descripcion_comercial">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Pais Origen</label>
                                                <div class="col-sm-7">
                                                    <select name="pais_origen_item" id="pais_origen_item" class="chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($paises as $row) {
                                                            echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Peso Bruto</label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control input-sm" id="peso_bruto" name="peso_bruto" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Peso Neto</label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control input-sm" id="peso_neto" name="peso_neto" min="0" step="0.01">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Preferencia</label>
                                                <div class="col-sm-7">
                                                    <select name="preferencia" id="preferencia" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($preferencia as $row) : ?>
                                                            <option value="<?php echo $row->codigo_preferencia; ?>">
                                                                <?php echo  $row->codigo_preferencia . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Cuota</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control input-sm" id="cuota" name="cuota">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-5 control-label text-left">Doc. transporte</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control input-sm" id="doc_transporte" name="doc_transporte">
                                                </div>
                                            </div>

                                        </div><!-- fin primera columna-->


                                        <div class="col-md-6">
                                            <!-- inicio segunda columna-->

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Cuantia
                                                </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="unidades_sup" name="unidades_sup" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Unidades Suplementarias
                                                    1
                                                </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="unidades_sup_uno" name="unidades_sup_uno" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left" min="0" step="0.01">Unidades Suplementarias
                                                    2
                                                </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="unidades_sup_dos" name="unidades_sup_dos">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Referencia Licencia
                                                </label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control input-sm" id="referencia_licencia" name="referencia_licencia">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Valor Deducido </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="valor_deducido" name="valor_deducido" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Precio Item</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="precio_item" name="precio_item" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Flete Externo</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="flete_externo_i" name="flete_externo_i" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Flete Interno</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="flete_interno_i" name="flete_interno_i" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Seguro</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="seguro_item" name="seguro_item" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Otros Costos</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="otros_costos_item" name="otros_costos_item" min="0" step="0.01">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-6 control-label text-left">Deducciones</label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control input-sm" id="deducciones_item" name="deducciones_item" min="0" step="0.01">
                                                </div>
                                            </div>

                                        </div><!-- fin segunda columna-->

                                    </div> <!-- fin row-->

                                    <div class="row">
                                        <input type="hidden" class="form-control input-sm" id="id_detalle" name="id_detalle">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4"> </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success pull-right" onclick="guardar_items()">Guardar Item</button>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-default" onclick="limpiar_input_item()">Limpiar</button>
                                        </div>
                                        <div class="col-md-4"> </div>
                                    </div>


                                </form>

                                <br><br> <button type="button" class="btn btn-primary" onclick="get_detalle_dpr()">Cargar detalle DPR</button>

                                <button type="button" class="btn btn-primary" onclick="cargar_adjunto_masivo()">Cargar
                                    adjunto</button>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_adjuntos">
                                    Launch demo modal
                                </button>
                                <br>
                                <br>

                                <div class="panel panel-default" id="panel_lista">
                                    <div class="panel-heading" id="titulo">
                                        Detalle de Items
                                    </div>
                                    <div class="panel-body" id="contenido">
                                        <table class="table" id="tbl_items">
                                            <thead>

                                                <tr>
                                                    <th>Número Item</th>
                                                    <th>Embalaje</th>
                                                    <th>Items</th>
                                                    <th>Precio</th>
                                                    <th>Flete Interno</th>
                                                    <th>Flete externo</th>
                                                    <th>Marca y No. de Paquete</th>
                                                    <th>Marca</th>
                                                    <th colspan="3">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contenidoLista">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- fin Items-->

                        </article>

                        <!--<article id="tab3">
                            Adjuntos 

                        </article> -->
                        <!--fin Adjuntos -->
                        <article id="tab4">
                            <!--Equipamiento-->
                            <div class="container-fluid">
                                <form enctype="multipart/form-data" method="post" class="form_equipamiento" id="form_equipamiento" action="javascript:guardar_equipamiento()">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="item_eq" class="control-label">Item</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" class="form-control input-sm" id="item_eq" name="item_eq" placeholder="Item" min="0" step="0.01" value="1" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="id_equipamiento" class="control-label">Equipamiento</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="id_equipamiento" id="id_equipamiento" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($equipamiento as $row) : ?>
                                                            <option value="<?php echo $row->id_equipamiento; ?>">
                                                                <?php echo  $row->id_equipamiento . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="tamano_equipo" class="control-label">Tamaño de
                                                        Equipo</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control input-sm" id="tamano_equipo" name="tamano_equipo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="equipamiento" class="control-label">ID
                                                        Equipamiento</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control input-sm" id="equipamiento" name="equipamiento">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="contenedor" class="control-label">Contenedor</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control input-sm" id="contenedor" name="contenedor">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="num_paq_eq" class="control-label">Numero de
                                                        Paquetes</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="num_paq_eq" name="num_paq_eq" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="tipo_contenedor" class="control-label">Tipo
                                                        Contenedor</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="tipo_contenedor" id="tipo_contenedor" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($tipocontenedor as $row) : ?>
                                                            <option value="<?php echo $row->id_contenedor; ?>">
                                                                <?php echo  $row->id_contenedor . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="codigo_entidad" class="control-label">Tipo Carga</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="tipo_carga" id="tipo_carga" class="form-control chosen" data-placeholder="Seleccione...">
                                                        <option value=""></option>
                                                        <?php foreach ($tipocarga as $row) : ?>
                                                            <option value="<?php echo $row->id_carga; ?>">
                                                                <?php echo  $row->id_carga . ' - ' . $row->descripcion; ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="tara" class="control-label">Tara</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="tara" name="tara" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-group-sm">
                                                <div class="col-md-2 text-left">
                                                    <label for="peso_mercancias" class="control-label">Peso de
                                                        mercancias</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control input-sm" id="peso_mercancias" name="peso_mercancias" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" class="form-control input-sm" id="dua_adjunto_eq" name="dua_adjunto">
                                        <input type="hidden" class="form-control input-sm" id="id_doc_eq" name="id_doc_eq">
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4"> </div>
                                        <div class="col-md-2">
                                            <input type="submit" value="Guardar" id="enviar_equipamiento" class="btn btn-success" />
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-default" onclick="limpiar_input_equipamiento()">Limpiar</button>
                                        </div>
                                        <div class="col-md-4"> </div>
                                    </div>

                                </form>
                                <br>
                                <div class="panel panel-default" id="panel_lista_equipamiento">
                                    <div class="panel-heading" id="titulo">
                                        Equipamiento
                                    </div>
                                    <div class="panel-body" id="contenido">
                                        <table class="table">
                                            <thead>

                                                <tr>
                                                    <th>Item</th>
                                                    <th>ID Equipamiento</th>
                                                    <th>Bultos</th>
                                                    <th>Tara</th>
                                                    <th>Peso Mercancia</th>
                                                    <th colspan="2">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contenidoLista_equipamiento">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--fin container documentos equipamientos -->

                        </article>
                        <article id="tab5">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-5">
                                    <button type="button"  name="btn_gen_xml"  id="btn_gen_xml" class="boton" onclick="generar_xml()">Generar XML</button>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-2 col-md-offset-5">
                                    <?php $fname = 'dm.xml'; ?>
                                    <a href="<?php echo base_url(); ?>/index.php/poliza/crear/download_xml/<?php echo $fname; ?>" class="boton"  name="btn_down_xml"  id="btn_down_xml">Download XML</a>
                                </div>
                            </div>

                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear adjuntos -->
    <div class="container-fluid">
        <div class="modal fade" id="add_adjuntos" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header hdmodal buttonclose">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="opcion" class="modal-title border-bottom pb-3 mb-4"><strong>AGREGAR ADJUNTOS</strong>
                        </h4>

                    </div>
                    <div class="row-fluid  message" id="message"></div>
                    <div class="modal-body">

                        <form enctype="multipart/form-data" method="post" class="form_adjunto" id="form_adjunto" action="javascript:guardar_adjunto()">

                            <div class="container">
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="id_opc" name="id_opc">
                                </div>
                                <div class="row">

                                    <div class="col">

                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="item_adjunto" class="control-label">Item</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control input-sm" id="item_adjunto" name="item_adjunto" placeholder="Item" min="0" step="0.01" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="doc_adjunto" class="control-label">Documento adjunto</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="doc_adjunto" id="doc_adjunto" class="form-control chosen" data-placeholder="Seleccione...">
                                                    <option value=""></option>
                                                    <?php foreach ($tipodocumento as $row) : ?>
                                                        <option value="<?php echo $row->codigo; ?>">
                                                            <?php echo  $row->codigo . ' - ' . $row->descripcion; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="referencia_doc" class="control-label">Referencia *</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control input-sm" id="referencia_doc" name="referencia_doc">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="fecha_doc" class="control-label">Fecha del Documento</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" class="form-control input-sm" id="fecha_doc" name="fecha_doc">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="fecha_exp" class="control-label">Fecha de Expiración</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" class="form-control input-sm" id="fecha_exp" name="fecha_exp">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="codigo_pais_adj" class="control-label">Código de
                                                    Pais</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="codigo_pais_adj" id="codigo_pais_adj" class="form-control chosen" data-placeholder="Seleccione...">
                                                    <option value=""></option>
                                                    <?php foreach ($paises as $row) : ?>
                                                        <option value="<?php echo $row->id_pais; ?>">
                                                            <?php echo  $row->id_pais . ' - ' . $row->nombre; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="entidad" class="control-label">Código de Entidad</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="codigo_entidad" id="codigo_entidad" class="form-control chosen" data-placeholder="Seleccione...">
                                                    <option value=""></option>
                                                    <?php foreach ($entidad as $row) : ?>
                                                        <option value="<?php echo $row->id_entidad; ?>">
                                                            <?php echo  $row->id_entidad . ' - ' . $row->descripcion; ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="otra_entidad" class="control-label">Otra Entidad</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control input-sm" id="otra_entidad" name="otra_entidad">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="monto_autorizado" class="control-label">Monto
                                                    Autorizado</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control input-sm" id="monto_autorizado" name="monto_autorizado" min="0" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-group-sm">
                                            <div class="col-md-2 text-left">
                                                <label for="doc_escaneado" class="control-label">Documento
                                                    Escaneado</label>
                                            </div>
                                            <div class="col-md-3">

                                                <input type="file" name="file" id="file" class="w-50" required accept=".pdf" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <input type="hidden" class="form-control input-sm" id="dua_adjunto" name="dua_adjunto">
                                <input type="hidden" class="form-control input-sm" id="id_doc" name="id_doc">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-2">
                                    <input type="submit" value="Guardar" id="enviar_adjunto" class="btn btn-success" />
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-default" onclick="limpiar_input_adjuntos()">Limpiar</button>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>

                        </form>
                        <br>
                        <div class="panel panel-default" id="panel_lista_adjuntos">
                            <div class="panel-heading" id="titulo">
                                Documentos Adjuntos
                            </div>
                            <div class="panel-body" id="contenido">
                                <table class="table">
                                    <thead>

                                        <tr>
                                            <th>Item</th>
                                            <th>Doc. Adjunto</th>
                                            <th>Referencia</th>
                                            <th>Fecha Documento Interno</th>
                                            <th>Fecha Expiración</th>
                                            <th>Código Pais</th>
                                            <th>Código Entidad</th>
                                            <th>Monto Autorizado</th>
                                            <th colspan="3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenidoLista_adjuntos">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Fin Modal Crear adjunto -->


    <!-- Modal subir archivo Excel  DPR-->

    <div class="modal fade" id="upDPR" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header hdmodal buttonclose">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title border-bottom pb-3 mb-4"><strong>SUBIR ARCHIVO </strong></h4>

                </div>
                <div class="row-fluid" id="messagefile"></div>
                <form enctype="multipart/form-data" method="post" class="form_adjunto_m" id="form_adjunto_m" action="javascript:subir_productos()">
                    <div class="modal-body">

                        <div class="container-fluid">
                            <div class="row">
                                <input type="file" name="file" id="file" class="w-50" required accept=".pdf" />
                            </div>
                        </div>

                    </div> <br>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                        <input type="submit" value="Aceptar" id="enviar" class="btn btn-success" />

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- fin modal subir archivo excel -->




    <script>
        $('ul.tabs li a:first').addClass('active');
        $('.secciones article').hide();
        $('.secciones article:first').show();

        $('ul.tabs li a').click(function() {
            $('ul.tabs li a').removeClass('active');
            $(this).addClass('active');
            $('.secciones article').hide();

            var activeTab = $(this).attr('href');
            $(activeTab).show();
            return false;
        });
    </script>

    <!--busca nombre consignatario -->
    <script>
        $(document).ready(function() {
            $("#nit_consignatario").blur(function() {
                //  $(this).css("background-color", "#FFFFCC");
                var nit = $("#nit_consignatario").val();
                var url = base_url("index.php/poliza/crear/consulta_consignatario/" + nit);
                $.getJSON(url, {}, function(data) {
                    //  alert(data.nombre);
                    $("#consignatario").val(data.nombre);
                });
            });
        });
    </script>

    <!--busca nombre exportador -->
    <script>
        $(document).ready(function() {
            $("#nit_exportador").blur(function() {
                //  $(this).css("background-color", "#FFFFCC");
                var nit = $("#nit_exportador").val();
                var url = base_url("index.php/poliza/crear/consulta_consignatario/" + nit);
                $.getJSON(url, {}, function(data) {
                    //  alert(data.nombre);
                    $("#nombre_exportador").val(data.nombre);
                });
            });
        });
    </script>


    <script>
        detalle_poliza();
    </script>

    <script>
        $(document).ready(function() {
            $("#codigo_mercancia").blur(function() {
                //  $(this).css("background-color", "#FFFFCC");
                var partida = $("#codigo_mercancia").val();
                var url = base_url("index.php/poliza/crear/consulta_producto/" + partida);
                $.getJSON(url, {}, function(data) {
                    $("#descripcion_comercial").val(data.descripcion);
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectmod').change(function(e) {
                var cadena = document.getElementById('selectmod').value;
                var valor = cadena.substr(0, 2);
                if (valor === "EX") {
                    $('#nit_exportador').prop("disabled", false);
                    $('#nit_consignatario').prop("disabled", true)
                    $('#nombre_exportador').prop("disabled", true)
                    $('#consignatario').prop("disabled", false)

                    $('#nit_consignatario').val("");
                    $('#consignatario').val("");

                } else {
                    $('#nit_exportador').prop("disabled", true);
                    $('#nit_consignatario').prop("disabled", false)
                    $('#nit_exportador').val("");
                    $('#nombre_exportador').val("");
                    $('#nombre_exportador').prop("disabled", false)
                    $('#consignatario').prop("disabled", true)


                    //$('#exportador').prop("disabled",true)
                }
            })
        });

       
    </script>
    <script>
         $("#btn_gen_xml").click(function() {
            
          //  document.getElementById("btn_down_xml").click(); 
         });
    </script>

</body>

</html>