<?php 
if(isset($datosdetalle)) { 
	$iddetalle   = $datosdetalle->detalle;
	$item        = $datosdetalle->item;
	$codpro 	 = $datosdetalle->codigo_producto;
	$marcas      = $datosdetalle->marcas;
	$numero      = $datosdetalle->numeros;
	$partida     = $datosdetalle->partida;
	$descripcion = $datosdetalle->descripcion;
	$comple      = $datosdetalle->comple;
	$desSac      = $datosdetalle->desc_sac;
	$numBultos   = $datosdetalle->no_bultos;
	$tipBultos   = $datosdetalle->tipo_bulto;
	$origen      = $datosdetalle->origen;
	$pesoBruto   = $datosdetalle->peso_bruto;
	$contenedor  = $datosdetalle->contenedor1;
	$regExt      = $datosdetalle->reg_ext;
	$regAdi      = $datosdetalle->reg_adi;
	$pesoNeto    = $datosdetalle->peso_neto;
	$doctrans    = $datosdetalle->doc_transp;
	$cuantia     = $datosdetalle->cuantia;
	$fob         = $datosdetalle->fob;
	$cif         = $datosdetalle->cif;
	$flete       = $datosdetalle->flete;
	$seguro      = $datosdetalle->seguro;
	$otros       = $datosdetalle->otros_gastos;
} else {
	$iddetalle   = '';
	$item        = $this->arance->agregarItem();
	$codpro      = '';
	$marcas      = '';
	$numero      = '';
	$partida     = '';
	$descripcion = '';
	$comple      = '';
	$desSac      = '';
	$numBultos   = '';
	$tipBultos   = '';
	$origen      = '';
	$pesoBruto   = '';
	$contenedor  = '';
	$regExt      = '';
	$regAdi      = '';
	$pesoNeto    = '';
	$doctrans    = '';
	$cuantia     = '';
	$fob         = '';
	$cif         = '';
	$flete       = '';
	$seguro      = '';
	$otros       = '';
}
?>
<div id="DetalleForm">
	<div class="well well-sm">
		<div class="row">
			<div class="col-sm-12">
				<form action="<?php echo base_url('index.php/poliza/arancelaria/guardardetalle');?>" method="POST" id="formDetalle">
					<input type="hidden" value="<?php echo $idDua;?>" name="duaduana" id="duaduana">
					<input type="hidden" value="<?php echo $iddetalle; ?>" name="detalle" id="detalle">
					<div class="form-group col-md-1">
						<label for="item">Item</label>
						<input type="text" class="form-control" name="item" id="item" value="<?php echo $item; ?>" readonly>
					</div>
					<div class="form-group col-md-2">
						<label for="cod_producto">Código Producto</label>
						<input type="text" class="form-control" name="codigo_producto" id="cod_producto" onblur="sugerencia(<?php echo $idDua; ?>, $(this).val() )" value="<?php echo $codpro; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="marcas">Marcas</label>
						<input type="text" class="form-control" name="marcas" id="marcas" value="<?php echo $marcas; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="numero">Números</label>
						<input type="text" class="form-control" name="numeros" id="numero" value="<?php echo $numero; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="partida">Partida</label>
						<input type="text" class="form-control" name="partida" id="partida" value="<?php echo $partida; ?>">
					</div>
					<div class="form-group col-sm-3">
						<label for="descripcion">Descripción</label>
						<textarea name="descripcion" id="descripcion"  rows="4" class="form-control"><?php echo $descripcion;?></textarea>
					</div>
					<div class="form-group col-md-3">
						<label for="comple">Comple</label>
						<input type="text" class="form-control" name="comple" id="comple" value="<?php echo $comple; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="des_sac">Desc. SAC</label>
						<input type="text" class="form-control" name="desc_sac" id="des_sac" value="<?php echo $desSac; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="num_bultos">Numero de bultos</label>
						<input type="number" step="any" class="form-control" name="no_bultos" id="num_bultos" value="<?php echo $numBultos; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="tipo_bulto">Tipo de Bulto</label>
						<select class="form-control" name="tipo_bulto" id="tipo_bulto">
							<option value="">-</option>
							<?php 
								if (isset($tipoBulto)){
									foreach($tipoBulto as $row){
										if ($tipBultos == $row->codigo){
											echo "<option value='{$tipBultos}' selected>{$row->codigo} - {$row->descripcion}</option>";
										} else {
											echo "<option value='{$row->codigo}'>{$row->codigo} - {$row->descripcion}</option>";
										}
									}
								}
							?>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="origen">Origen</label>
						<select class="form-control" name="origen" id="origen">
							<option value="">-</option>
							<?php
							if (isset($paises)){
								foreach ($paises as $row) {
									if($origen == $row->id_pais){
										echo "<option value='{$origen}' selected>{$row->id_pais} - {$row->nombre}</option>";
									} else {
										echo "<option value='{$row->id_pais}'>{$row->id_pais} - {$row->nombre}</option>";
									}
								}
							}
							?>
						</select>
					</div>
					<div class="form-group col-md-3">
						<label for="peso_bruto">Peso Bruto</label>
						<input type="number" step="any" class="form-control" name="peso_bruto" id="peso_bruto" value="<?php echo $pesoBruto; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="contenedor">Contenedor</label>
						<input type="type" class="form-control" name="contenedor1" id="contenedor" value="<?php echo $contenedor; ?>">
					</div>
					<div class="form-group col-md-3">
						<label for="peso_neto">Peso Neto</label>
						<input type="number" step="any" class="form-control" name="peso_neto" id="peso_neto" value="<?php echo $pesoNeto; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="reg_ext">Regimen Extendido</label>
						<input type="type" class="form-control" name="reg_ext" id="reg_ext" value="<?php echo $regExt; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="reg_adi">Regimen Adicional</label>
						<input type="type" class="form-control" name="reg_adi" id="reg_adi" value="<?php echo $regAdi; ?>">
					</div>
					
					<div class="form-group col-md-2">
						<label for="doc_trans">Documento Transporte</label>
						<input type="text" class="form-control" name="doc_transp" id="doc_trans" value="<?php echo $doctrans; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="cuantia">Cuantia</label>
						<input type="number" step="any"class="form-control" name="cuantia" id="cuantia" value="<?php echo $cuantia; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="fob">FOB</label>
						<input type="number" step="any" class="form-control" name="fob" onblur="prorrateo($(this).val())" id="fob" value="<?php echo $fob; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="flete">Flete</label>
						<input type="number" step="any" class="form-control" name="flete"  id="flete" readonly value="<?php echo $flete; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="seguro">Seguro</label>
						<input type="number" step="any" class="form-control" name="seguro"  id="seguro" readonly value="<?php echo $seguro; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="otros">Otros</label>
						<input type="number" step="any" class="form-control" name="otros_gastos"  id="otros" readonly value="<?php echo $otros; ?>">
					</div>
					<div class="form-group col-md-2">
						<label for="cif">CIF</label>
						<input type="number" step="any" class="form-control" name="cif" id="cif" value="<?php echo $cif; ?>">
					</div>
					<div class="form-group col-sm-12 text-right">
						<a class="btn btn-danger btn-sm load" href="<?php echo base_url("index.php/poliza/arancelaria/detalle/{$idDua}") ?>"><i class="glyphicon glyphicon-plus"></i></a>
						<button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-floppy-saved"></i> Guardar</button>
						<a href="javascript:" type="button" class="btn btn-info btn-sm  open_list" onclick="listas('#idlista')"><i class="glyphicon glyphicon-sort"></i></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
