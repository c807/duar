<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subir_archivo extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
		$this->load->library("session");
		$this->load->model(array('subir_archivos/Subir_archivos_model'));
		$this->datos = array();
		$this->datos["sinmenu"] = true;
    }


    public function index()
    {
    	$this->datos["vista"] = 'subir_archivos/subir_archivo';
        $this->load->view("principal", $this->datos);
    }

	public function import()
 		{
			if(isset($_FILES["file"]["name"]) && isset($_POST['c807_file'])  )
			{
				$id_file = $this->Subir_archivos_model->obtener_datos_file($_POST['c807_file']);

				$this->datos['contador'] = 0;

				if (!isset($id_file)) {
					$this->session->set_flashdata('css','success');
					#$this->session->set_flashdata('mensaje', 'Número de file: ' . $_POST['c807_file'] . ' no existe');
					$_SESSION["no_clasificado"] = 'Número de File'. $_POST['c807_file'] .' no existe.';
					$this->load->view('subir_archivos/subir_archivo');
				}else{

					$config['upload_path']          = './public/uploads/file/';
					$config['allowed_types']        = 'xls|xlsx';
					$this->load->library('upload', $config);
					if (! $this->upload->do_upload('file'))
						{
							#$this->session->set_flashdata('css','success');
							#$this->session->set_flashdata('mensaje',$this->upload->display_errors());
							$_SESSION["no_clasificado"] = $this->upload->display_errors();
							$this->load->view('subir_archivos/subir_archivo');
						}else {

						$nombre_archivo = $this->upload->data();
						$file_name      = $nombre_archivo['file_name'];
						$path           =  $file = './public/uploads/file/'.$file_name;

						$object = PHPExcel_IOFactory::load($path);

						$existe_Factura = '';
						foreach($object->getWorksheetIterator() as $worksheet)
						{
							$highestRow = $worksheet->getHighestRow();
							$highestColumn = $worksheet->getHighestColumn();
							for($row=2; $row<=$highestRow; $row++)
							{
								$num_factura  = 	$worksheet->getCellByColumnAndRow(0, $row)->getValue();
								$data = array(
									'num_factura' => $num_factura,
									'num_file'  => $_POST['c807_file']

								);

								$cantidad = $this->Subir_archivos_model->existe_factura($data);

								if ($cantidad->cantidad == 0) {
									$existe_Factura = 'N';
								}else
								{
									$existe_Factura = 'S';
								}
							}
						}

						if ($existe_Factura == 'S')
						{
							$_SESSION["no_clasificado"] = 'Factuta ya fue Procesada al file '. $_POST['c807_file'];
							#$this->session->set_flashdata('css','danger');
							#$this->session->set_flashdata('mensaje', 'Factura ya fue Procesada.');

							$this->datos['registros'] = $this->Subir_archivos_model->consulta($id_file->id);
							$this->load->view('subir_archivos/subir_archivo', $this->datos);

						}else
						{
							foreach($object->getWorksheetIterator() as $worksheet)
							{
								$highestRow    = $worksheet->getHighestRow();
								$highestColumn = $worksheet->getHighestColumn();
								for($row=2; $row<=$highestRow; $row++)
								{
									$num_factura     = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
									$codigo          = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
									$descripcion     = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
									$pais_origen     = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
									$unidades        = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
									$precio_unitario = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
									$total           = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

									$data = array(
											'num_factura'     => $num_factura,
											'id_file'         => $id_file->id,
											'codigo_producto' => $codigo,
											'descripcion'     => $descripcion,
											'pais_origen'     => $pais_origen,
											'cuantia'         => $unidades,
											'precio_unitario' => $precio_unitario,
											'total'           => $total
										);

									$this->Subir_archivos_model->insert($data);
									$this->datos['contador'] += 1;
								}
							}
							#$this->session->set_flashdata('css','success');
							#$this->session->set_flashdata('mensaje', 'Datos Procesados');
							$_SESSION["no_clasificado"] = 'Datos Procesados al file '. $_POST['c807_file'];


							$this->datos['registros'] = $this->Subir_archivos_model->consulta($id_file->id);

							$this->load->view('subir_archivos/subir_archivo', $this->datos);
						}
					}
				}
			}
 		}


	public function clasificar_productos()
		{
			$this->datos['vista'] = "subir_archivos/clasificar_productos";
			$this->load->view('principal', $this->datos);

		}

	public function no_clasificados()
		{

			$id_file = $this->Subir_archivos_model->obtener_datos_file($_POST['c807_file']);

				if (!isset($id_file)) {
					$this->session->set_flashdata('css','success');
					$this->session->set_flashdata('mensaje', 'Número de file: ' . $_POST['c807_file'] . ' no existe');
					$this->load->view('subir_archivos/no_clasificados');
				}else{

					$this->datos['registros'] = $this->Subir_archivos_model->consulta($id_file->id, $id_file->cliente_hijo_id);
					$this->datos['num_file'] = $_POST['c807_file'];

					$this->session->set_flashdata('css','success');
					$this->session->set_flashdata('mensaje', '');
					$this->load->view('subir_archivos/no_clasificados', $this->datos);
				}

		}

	public function traer_informacion_producto($id_reg, $num_file)
		{
			$datos = $this->Subir_archivos_model->traer_informacion_producto($id_reg);
			$cod_importador = $this->Subir_archivos_model->obtener_datos_file($num_file);

			enviarJson(
				array(
					'codigo_producto' => $datos->codigo_producto,
					'descripcion'     => $datos->descripcion,
					'importador'      => $cod_importador->cliente_hijo_id
				));

		}


	public function grabar_partida()
	{
		if (isset($_POST['partida_arancelaria']) && strlen(trim($_POST['partida_arancelaria'])) >0  )
		{
			$this->Subir_archivos_model->insertar_partida($_POST);
		}else
		{
			enviarJson(array('mensaje' => 'Error, falta la partida arancelaria.'));
		}

	}

	public function mostrar_clasificados()
	{
		$this->datos["vista"] = 'subir_archivos/generar_archivo_clasificado';
		$this->load->view("principal", $this->datos);
	}


	public function generar_excel()
	{


		if(isset($_POST["c807_file"]) &&  isset($_POST["doc_transporte"]) && isset($_POST["tot_bultos"]) && isset($_POST["tot_kilos"]) )
		{

			//Obtener id_file, cliente_id
			$this->datos['cliente'] = $this->Subir_archivos_model->obtener_datos_file($_POST ["c807_file"]);
			//$this->datos['partida'] = "1205";

			//var_dump($this->datos['cliente']->id);
			//var_dump($this->datos['cliente']->cliente_hijo_id);
			//var_dump($this->datos['partida']);

			//die();

			//Obtener datos de Partida Arancelaria
			$registros  = $this->Subir_archivos_model->generar_excel($_POST ["c807_file"] , $_POST['doc_transporte']);

			//var_dump($registros);
			//die();
			// Crea un nuevo objeto PHPExcel
			//  $inputFileName = getcwd()."/public/fls/autoconsulta.xls";

			$objPHPExcel = new PHPExcel();

			// Establecer propiedades
			$objPHPExcel->getProperties()->setCreator("IMPALA - C807")
										->setLastModifiedBy("Maarten Balliauw")
										->setTitle("Office 2007 XLSX Test Document")
										->setSubject("Office 2007 XLSX Test Document")
										->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
										->setKeywords("office 2007 openxml php")
										->setCategory("Test venta");

			//Agrenar Encabezados
			$pos = 1;

			if ($registros) {
				//Obtener Cuantia, Total Fob
				$total_Cuantia = 0;
				$total_fob = 0;
				for ($x = 0; $x < count($registros); $x++)
					{

						foreach ($registros[$x]  as $item => $field) {
							if ($item == 'cuantia')
							{
								$total_Cuantia += $field;
							}
							if ($item == 'fob')
							{
								$total_fob += $field;
							}

						}
					}

				//var_dump($total_fob);
				//die();

				//Buscar Paises
				for ($x = 0; $x < count($registros); $x++)
					{

						foreach ($registros[$x]  as $item => $field) {
							if ($item == 'partida')
							{
								$this->datos['partida'] = $field;
							}
							if ($item == 'pais')
							{

								//Pasar Partida Arancelaria, Cod Importador(codigo de cliente) y Id_File
								//var_dump($this->datos['cliente']->id);
								//var_dump($this->datos['cliente']->cliente_hijo_id);

								$det_Paises = '';

								if (isset($this->datos['partida']))
								{
									$paises = $this->Subir_archivos_model->traer_paises($this->datos);
									for ($i=0; $i < count($paises) ; $i++) {
										foreach ($paises[$i] as $key => $value) {
										//var_dump($value);
										$det_Paises = $det_Paises . $value . " ";
										//var_dump($det_Paises);
										}
									}
								}


								///var_dump($det_Paises);
								//die();
								$registros[$x]->pais = $det_Paises;

							}
						}
					}



				//var_dump($registros[0]);
				//die();
				//Prorratar Bultos
				for ($x = 0; $x < count($registros); $x++)
					{
						$cuantia_Paquete = 0;
						$fob_Paquete = 0;
						$flete_Paquete = 0;
						$seguro_Paquete = 0;
						$otros_Paquete = 0;
						foreach ($registros[$x]  as $item => $field) {
							if ($item == 'cuantia')
							{
								$cuantia_Paquete = round($field * $_POST["tot_bultos"] / $total_Cuantia,2);
							}
							if ($item == 'numero_de_bultos'){
								$registros[$x]->numero_de_bultos  = $cuantia_Paquete;
								$cuantia_Paquete = 0;
							}

							if ($item == 'fob')
							{
								$fob_Paquete = round($field * $_POST["tot_kilos"] / $total_fob,2);
								$flete_Paquete = round($_POST["flete"] / $total_fob * $field,2);
								$seguro_Paquete = round($_POST["seguro"] / $total_fob * $field,2);
								$otros_Paquete = round($_POST["otros"] / $total_fob * $field,2);
							}
							if ($item == 'peso_bruto'){
								$registros[$x]->peso_bruto  = $fob_Paquete;
								$fob_Paquete = 0;
							}
							if ($item == 'flete'){
								$registros[$x]->flete  = $flete_Paquete;
								$flete_Paquete = 0;
							}
							if ($item == 'seguro'){
								$registros[$x]->seguro  = $seguro_Paquete;
								$seguro_Paquete = 0;
							}
							if ($item == 'otros'){
								$registros[$x]->otros  = $otros_Paquete;
								$otros_Paquete = 0;
							}
						}
					}

				//Recalcular CIF
				$tot_Gastos = 0;
				for ($x = 0; $x < count($registros); $x++)
					{
						foreach ($registros[$x]  as $item => $field) {
							if ($item == 'flete')
							{
								$tot_Gastos = $field;
							}
							if ($item == 'seguro')
							{
								$tot_Gastos += $field;
							}
							if ($item == 'otros')
							{
								$tot_gastos += $field;
							}
							if ($item == 'cif')
							{
								$registros[$x]->cif  += $tot_Gastos;
								$tot_Gastos  = 0;
							}
						}
					}


				for ($x = 0; $x < count($registros); $x++)
					{
						if ( $x == 0) { //solo imprime los encabezados
							$datos = array();
							foreach ($registros[$x]  as $item => $field) {
								$datos[] = $item;
							}
							$objPHPExcel->getActiveSheet()->fromArray($datos, NULL, "A{$pos}");
							$pos += 1;
						}

						$datos = array();
						foreach ($registros[$x]  as $item => $field) {
							$datos[] = $field;
						}
						$objPHPExcel->getActiveSheet()->fromArray($datos, NULL, "A{$pos}");
						$pos += 1;
					}
			}




			// Renombrar Hoja
			$objPHPExcel->getActiveSheet()->setTitle('Cuadricula Generada');

			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$objPHPExcel->setActiveSheetIndex(0);

			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$_POST ["c807_file"].'.xls');
			header('Cache-Control: max-age=0');
			header('Cache-Control: max-age=1');

			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			ob_end_clean();
			$objWriter->save('php://output');

			exit;
		}
	}



}

/* End of file Controllername.php */

