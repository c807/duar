<form class="navbar-form navbar-left " role="search" method="get" action="<?php echo $action; ?>" id="formproducto" onsubmit="enviarformproducto(this); return false;">
    <div class="form-group">
    	<input type="hidden" value="0" name="inicio" id="inicio">
        <input type="text" class="form-control" placeholder="Razón Social ..." name="importador" required>
        <button type="submit" class="btn btn-success btn-sm" >
            <i class="glyphicon glyphicon-search"></i>
        </button>
    </div>
</form>