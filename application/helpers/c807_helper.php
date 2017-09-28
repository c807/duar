<?php

if ( ! function_exists('login_url'))
{
	function login_url()
	{
		return "http://" . $_SERVER['SERVER_NAME'] . "/grupo_c807/";
	}
}

if ( ! function_exists('login'))
{
	function login()
	{
		if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists('sys_url'))
{
	function sys_url($url = '')
	{
		return "http://" . $_SERVER['SERVER_NAME'] . "/grupo_c807/" . $url;
	}
}

if ( ! function_exists('formatoFecha')) {
	function formatoFecha($fecha = '', $tipo = 1) {
		if (!empty($fecha)) {
			if ($fecha == "0000-00-00" || $fecha == ' "' || $fecha == '" ' || $fecha == '"') {
				return null;
			} else {
				switch ($tipo) {
					case 1:
						$formato = 'd/m/Y H:i:s';
						break;
					case 2:
						$formato = 'd/m/Y';
						break;
					case 3: 
						$fh = explode('/', $fecha);
						return $fh[2].'-'.$fh[1].'-'.$fh[0];
						break;
					default:
						$formato = 'Y-m-d';
						break;
				}
				$date = new DateTime($fecha);
				return $date->format($formato);
			}
		} else {
			return $fecha;
		}
	}
}

if ( ! function_exists('opcionesSelect')) {
	function opcionesSelect($datos, $indice, $campo, $valor = array())
	{
		$arreglo = array('' => '-');

		foreach ($datos as $row) {
			if (empty($valor)) {
				$arreglo[$row->$indice] = $row->$campo;
			} else {
				if (is_array($valor) && in_array($row->$indice, $valor)) {
					$arreglo[$row->$indice] = $row->$campo;
				}
			}
		}

		return $arreglo;
	}
}

if (! function_exists('verDato')) {
	function verDato($arre, $dato){
		if (isset($arre[$dato]) && (!empty($arre[$dato]) || ($arre[$dato]==0)) ) {
			return true;
		}
		return false;
	}
}

if (! function_exists('verDatovalor')) {
	function verDatovalor($arre, $dato){
		if (!empty($arre[$dato])) {
			return true;
		}
		return false;
	}
}

if (!function_exists('limite')) {
	function limite() {
		return 10;
	}
}