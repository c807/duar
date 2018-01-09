<?php
if (! function_exists('correo')) {
	function correo() {
		getcwd();
		chdir('../');
		require(getcwd() . "/enviar_correo.php");
	}
}

?>
