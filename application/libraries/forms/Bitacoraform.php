<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Bitacoraform {
	protected $procs;
	protected $clase;
	protected $datos;
	protected $action;
	protected $file;

	public function __construct(){
		$this->procs = & get_instance();
		$this->clase = 'form-control';
		$this->datos = array();
	}

	public function set_action($accion){
		$this->action = $accion;
	}

	public function set_file($file){
		$this->file = $file;
	}

	private function Openform(){

		$this->datos['iniciaform'] = form_open(
			$this->action,
			array(
				'id'    => 'formcomenta'
				)
		);
	}
	private function Nofile(){
		$this->datos['lab_file'] = form_label(
            'File: ', 
            'inp-file'
        );

        $this->datos['inp_file'] = form_input(
        	array(
        		'name'  => 'inp-file',
        		'id'    => 'inp-file',
        		'class' => $this->clase,
        		'readonly' => 'readonly'
        		),
        	((isset($this->file)) ? $this->file : '')
        );
	}

    private function mensaje(){
        $this->datos['lab_mensaje'] = form_label(
            'Descripción:', 
            'inp-mensaje'
        );

    	$this->datos['inp_mensaje'] = form_textarea(
    		array(
				'rows'  => 5,
				'class' => $this->clase,
				'id'    => 'inp-mensaje',
				'name'  => 'descripcion'
    			)
    	);
    }

	private function Closeform(){

		$this->datos['button'] = form_button (
				array(
					"class"   => "btn btn-primary btn-sm",
					"id"      => "btn-save",
					"type"    => "submit"
				),
				"Guardar"
		);

		$this->datos['cierraform'] = form_close();
	}

    public function mostrar(){
    	$this->Openform();
    	$this->Nofile();
    	$this->mensaje();
    	$this->Closeform();
    	return $this->datos;
    }


}
?>

