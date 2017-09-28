<?php 
   if(isset($encabezado)){
      $duaduana      = $encabezado->duaduana;
      $aduanaEntrada = $encabezado->aduana_entrada;
      $fecha         = $encabezado->fecha;
      $nit           = $encabezado->nit;
      $bultos        = $encabezado->bultos;
      $aduanaSalida  = $encabezado->aduana_salida;
      $modelo        = $encabezado->modelo;
      $regisTransp   = $encabezado->registro_transportista;
      $modoTransp    = $encabezado->mod_transp;
      $declaranteid  = $encabezado->declarante;
      $ver = $this->crear->empresas($declaranteid);
      $declarantenom = $ver->nombre;
      $paisProce     = $encabezado->pais_proc;
      $paisExpor     = $encabezado->pais_export;
      $lugarCarga    = $encabezado->lugar_carga;
      $referencia    = $encabezado->referencia;
      $paisDestino   = $encabezado->pais_destino;
      $pais          = $encabezado->pais;
      $cantArt       = $encabezado->cant_arti;
      $flete         = $encabezado->flete;
      $seguro        = $encabezado->seguro;
      $otros         = $encabezado->otros;
      $tasas         = $encabezado->tasas;
      $tipoCambio    = $encabezado->tipo_cambio;
      $totalFacturar = $encabezado->total_facturar;
      $destinatario  = $encabezado->destinatario;
      $incoterm      = $encabezado->incoterm;
      $localMerca    = $encabezado->localizacion_de_merc;
      $fileid        = $encabezado->c807_file;
      $fob           = $encabezado->fob;
   } else {
      $duaduana      = '';
      $aduanaEntrada = '';
      $fecha         = date('Y-m-d');
      $nit           = '';
      $bultos        = '';
      $aduanaSalida  = '';
      $modelo        = '';
      $regisTransp   = '';
      $modoTransp    = '';
      $declaranteid  = '';
      $declarantenom = '';
      $paisProce     = '';
      $paisExpor     = '';
      $lugarCarga    = '';
      $referencia    = '';
      $paisDestino   = '';
      $pais          = '';
      $cantArt       = '';
      $flete         = '';
      $seguro        = '';
      $otros         = '';
      $tasas         = '';
      $tipoCambio    = '';
      $totalFacturar = '';
      $incoterm      = '';
      $localMerca    = '';
      $destinatario  = '';
      $fileid        = $file;
      $fob           = '';
   }
?>
  <div class="well well-sm">
     <div class="row">
        <div class="col-sm-12">
         <form class="" action="<?php echo base_url('index.php/poliza/crear/guardar_encabezado')?>" method="POST" id="formEncabezado">
         	<input type="hidden" value="<?php echo $duaduana; ?>" name="duaduana" id="dua_id">
          	<input type="hidden" value="<?php echo $fileid; ?>" name='c807_file'>
            <input type="hidden" value="<?php echo date('Y'); ?>" name="anio">
            <div class="form-group col-sm-4">
               <label for="aduana_entrada" class=" control-label">Aduana Entrada</label>
               <select type="text" class="form-control" name="aduana_entrada" id="aduana_entrada">
                   <option value="">-</option>
                  <?php
                  if(isset($aduana)) {
                     foreach($aduana as $row){
                        if($row->aduana == $aduanaEntrada){
                           echo "<option value='{$row->aduana}' selected>{$row->aduana} - {$row->nombre}</option>";
                        } else {
                        echo "<option value='{$row->aduana}'>{$row->aduana} - {$row->nombre}</option>";
                        }
                     }
                  }
                  ?>
               </select>
            </div>
            <div class="form-group col-sm-3">
               <label for="fecha" class="control-label">Fecha</label>
               <input type="date" class="form-control" name="fecha" id="fecha" requierd value="<?php echo $fecha; ?>">
            </div>
            <div class="form-group col-sm-3">
               <label for="nit" class="control-label">NIT</label>
               <select name="nit" id="nit" onchange="vernombrepresa($(this).val());">
               		<option value="">-</option>
               	 <?php 
                  if (isset($declarante)){
                     foreach ($declarante as $row){
                        if($nit == $row->cod_empresa){
                           echo "<option value='{$nit}' selected>{$row->cod_empresa} - {$row->nombre}</option>";   
                        } else {
                           echo "<option value='{$row->cod_empresa}'>{$row->cod_empresa} - {$row->nombre}</option>";
                        }
                     }
                  }
                  ?>
               </select>
            </div>
            <div class="form-group col-sm-2">
               <label for="bultos" class="control-label">Bultos</label>
               <input type="text" class="form-control" name="bultos" id="bultos" requierd value="<?php echo $bultos; ?>">
            </div>
            <div class="form-group col-sm-4">
               <label for="adu_salida" class="control-label">Aduana Salida</label>
               <select class="form-control" name="aduana_salida" id="adu_salida">
                  <option value="">-</option>
                  <?php
                  if(isset($aduana)) {
                     foreach($aduana as $row){
                        if($aduanaSalida == $row->aduana){
                           echo "<option value='{$aduanaSalida}' selected>{$row->aduana} - {$row->nombre}</option>";
                        } else {
                           echo "<option value='{$row->aduana}'>{$row->aduana} - {$row->nombre}</option>";
                        }
                     }
                  }
                  ?>
               </select>
            </div>
            <div class="form-group col-sm-3">
               <label for="modelo" class="control-label">Modelo</label>
               <input type="text" class="form-control" name="modelo" id="modelo" value="<?php echo $modelo; ?>">
            </div>
             <div class="form-group col-sm-3">
               <label for="reg_trans" class="control-label">Registro Transportista</label>
                  <input type="text" class="form-control" name="registro_transportista" id="reg_trans" value="<?php echo $regisTransp; ?>">
             </div>
            <div class="form-group col-sm-2">
               <label for="mod_transp" class="control-label">Modo Transporte</label>
               <select class="form-control" name="mod_transp" id="mod_transp">
                  <option value="">-</option>
                  <?php 
                    if (isset($modotransp)) {
                      foreach ($modotransp as $row) {
                        if ($modoTransp == $row->codigo) {
                          echo "<option value='{$modoTransp}' selected>{$row->codigo} - {$row->nombre}</option>";
                        } else { 
                          echo "<option value='{$row->codigo}'>{$row->codigo} - {$row->nombre}</option>";
                        }
                      }
                    }
                  ?>
               </select>
            </div>
             <div class="form-group col-sm-4">
               <label for="declarante" class="control-label">Declarante</label>
               <input type="text" class="form-control" id="nomdeclarante" readonly value="<?php echo $declarantenom; ?>">
               <input type="hidden" name="declarante" id="declarante" value="<?php echo $declaranteid; ?>">
            </div>
            <div class="form-group col-sm-3">
               <label for="pais_proce" class="control-label">País Procedencia</label>
               <select class="form-control" name="pais_proc" id="pais_proce">
                  <option value="">-</option> 
                  <?php
                  if (isset($paises)){
                    foreach ($paises as $row) {
                      if($paisProce == $row->id_pais){
                        echo "<option value='{$paisProce}' selected>{$row->id_pais} - {$row->nombre}</option>";
                      } else {
                        echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
                      }
                    }
                  }
                  ?>
               </select>
            </div>
            <div class="form-group col-sm-3">
               <label for="pais_expor" class="control-label">País Exportación</label>
               <select class="form-control" name="pais_export" id="pais_expor"> 
                  <option value="">-</option>
                  <?php
                  if (isset($paises)){
                    foreach ($paises as $row) {
                      if($paisExpor == $row->id_pais){
                        echo "<option value='{$paisExpor}' selected>{$row->id_pais} - {$row->nombre}</option>";
                      } else {
                        echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
                      }
                    }
                  }
                  ?>
               </select>
             </div>
             <div class="form-group col-sm-2">
               <label for="lugar_carga" class="control-label">Lugar de Carga</label>
                  <input type="text" class="form-control" name="lugar_carga" id="lugar_carga" value="<?php echo $lugarCarga; ?>">
             </div>
              <div class="form-group col-sm-4">
               <label for="referencia" class="control-label">Referencias</label>
                  <textarea rows="4" class="form-control" name="referencia" id="referencia"><?php echo $referencia; ?></textarea>
             </div>
            <div class="form-group col-sm-3">
               <label for="pais_des" class="control-label">País Destino</label>
               <select class="form-control" name="pais_destino" id="pais_des">
                  <option value="">-</option>
                  <?php
                  if (isset($paises)){
                    foreach ($paises as $row) {
                      if($paisDestino == $row->id_pais){
                        echo "<option value='{$paisDestino}' selected>{$row->id_pais} - {$row->nombre}</option>";
                      } else {
                        echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
                      }
                    }
                  }
                  ?>
               </select>
            </div>
            <div class="form-group col-sm-3">
               <label for="pais" class="control-label">País</label> 
               <select class="form-control" name="pais" id="pais">
                  <option value="">-</option>
                  <?php
                  if (isset($paises)){
                    foreach ($paises as $row) {
                      if($pais == $row->id_pais){
                        echo "<option value='{$pais}' selected>{$row->id_pais} - {$row->nombre}</option>";
                      } else {
                        echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
                      }
                    }
                  }
                  ?>
               </select>
            </div>
             <div class="form-group col-sm-2">
               <label for="cant_art" class="control-label">Cant Art</label>
                 <input type="text" class="form-control" name="cant_arti" id="cant_art" value="<?php echo $cantArt; ?>">
             </div>
            <div class="form-group col-sm-2">
               <label for="fob" class="control-label">FOB</label>
               <input type="text" class="form-control" name="fob" id="fob" value="<?php echo $fob; ?>">
             </div>

            <div class="form-group col-sm-2">
              <label for="flete" class="control-label">Flete</label>
              <input type="text" class="form-control" name="flete" id="flete" value="<?php echo $flete; ?>">
            </div>
            <div class="form-group col-sm-2">
               <label for="seguro" class="control-label">Seguro</label>
               <input type="text" class="form-control" name="seguro" id="seguro" value="<?php echo $seguro; ?>">
            </div>
             <div class="form-group col-sm-1">
               <label for="otros" class="control-label">Otros</label>
               <input type="text" class="form-control" name="otros" id="otros" value="<?php echo $otros; ?>">
             </div>
            <div class="form-group col-sm-1">
               <label for="tasas" class="control-label">Tasas</label>
               <input type="text" class="form-control" name="tasas" id="tasas" value="<?php echo $tasas; ?>">
            </div>
            <div class="form-group col-sm-2">
               <label for="tipo_cambio" class="control-label">Tipo Cambio</label>
               <input type="text" class="form-control" name="tipo_cambio" id="tipo_cambio" value="<?php echo $tipoCambio; ?>">
            </div>
             <div class="form-group col-sm-2">
               <label for="tot_factu" class="control-label">Total Factura</label>
               <input type="text" class="form-control" name="total_facturar" id="tot_factu" value="<?php echo $totalFacturar; ?>">
             </div>
            <div class="form-group col-sm-2">
               <label for="destinatario" class="control-label">Destinatario</label>
               <input type="text" class="form-control" name="destinatario" id="destinatario" value="<?php echo $destinatario; ?>">
            </div>
            <div class="form-group col-sm-3">
               <label for="intercom" class="control-label">Incoterm</label>
               <select class="form-control" name="incoterm" id="intercom">
                  <option value="">-</option>
                  <?php 
                    if(isset($incoterms)){
                      foreach ($incoterms as $row){
                        if($incoterm == $row->CODIGO){
                          echo "<option value='{$incoterm}' selected>{$row->CODIGO} - {$row->DESCRIPCION}</option>";
                        } else {
                          echo "<option value='{$row->CODIGO}'>{$row->CODIGO} - {$row->DESCRIPCION}</option>";
                        }
                      }
                    }
                  ?>
               </select>
            </div>
             <div class="form-group col-sm-3">
               <label for="locali_merca" class="control-label">Localización Mercancia</label>
               <input type="text" class="form-control"  name="localizacion_de_merc" id="locali_merca" value="<?php echo $localMerca;?>">
             </div>
             <!--<div class="form-group col-sm-3">
               <label for="cero" class="control-label">Cero</label>
               <input type="text" class="form-control" name="cero" id="cero">
             </div>
             <div class="form-group col-sm-3">
               <label for="cont" class="control-label">Cont.</label>
               <input type="text" class="form-control" name="cont" id="cont">
             </div>
             <div class="form-group col-sm-3">
               <label for="t_liq" class="control-label">T. LIQ.</label>
               <input type="text" class="form-control" name="t_liq" id="t_liq">
             </div>
             <div class="form-group col-sm-3">
               <label for="t_esp_pag" class="control-label">T. Esp. Pag</label>
               <input type="text" class="form-control" name="t_esp_pag" id="t_esp_pag">
             </div>-->
                  <div class="form-group col-sm-12 text-right" style="margin-top:20px;">
                    <button  class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Guardar</button>
                      <?php if(!empty($duaduana)) { ?>
                  
                    <a href="<?php echo base_url('index.php/poliza/arancelaria/detalle/'.$duaduana) ?>" class="btn btn-sm btn-default"> <i class="glyphicon glyphicon-th-list"></i>  Detalle</a>
                  <a href="<?php echo base_url('index.php/poliza/documentosop/docsoporte/'.$duaduana) ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-file"></i> Documento Soporte</a>

               <?php } ?>
             </div>
         </form>

      </div>
   </div>
</div>
