<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

	
	public function __construct(){
		
		parent::__construct();

		if(!$this->tecnico_model->secure()){
			$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Debes estar Logueado con un usuario valido para acceder a esta seccion.</div>' 
											);
			redirect ( 'login' );
		}
		date_default_timezone_set("America/La_Paz");
	}
	
	
	public function index()
	{
		$data['num_clientes'] = $this->cliente_model->getClientes (array('count'=>true));
		
		$data['num_items'] = $this->item_model->getItems(array('count'=>true));
		
		$datestring = "%Y-%m-%d";
		$time = time();
		$date_today = mdate($datestring, $time); 
		$date_yesterday = date("Y-m-d",time()-86400).'<br>';

		$data['num_recepciones_today'] =$this->tecnico_item->getTecnicoItems(array('count'=>true,'fecha_ingreso'=>$date_today));
		$data['num_recepciones_yesterday'] =$this->tecnico_item->getTecnicoItems(array('count'=>true,'fecha_ingreso'=>$date_yesterday));
		$data['num_items_recepcionados'] = $this->item_model->getItems(array('estado'=>'recepcionado','count'=>true));
		
		$data['num_salidas_hoy'] =$this->tecnico_item->getTecnicoItems(array('count'=>true,'fecha_egreso'=>$date_today));
		
		$data['num_equipos_listos'] =$this->tecnico_item->getTecnicoItems(array('count'=>true,'estado'=>'5'));
		
		$data['tecnico'] = $this->tecnico_model->getTecnicos(array('id_tecnico'=>$this->session->userdata('id_tecnico')));
		
		$data['contenido'] = "panel/panel_index";
		$this->load->view('templates/plantilla_main',$data);
		
	}
	
}
