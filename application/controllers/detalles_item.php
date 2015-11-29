<?php
/**
 *
 */
class Detalles_item extends CI_Controller {
	var $tecnico = null;
	public function __construct() {
		parent::__construct();
		if (!$this -> tecnico_model -> secure()) {
			$this -> session -> set_flashdata('flashError', 'You must be logged into a valid admin account to access this section');
			redirect('login');
		}
		
		$this->config->set_item('language','spanish');
		$this->form_validation->set_error_delimiters('	<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>', '</div>');
		
		$this->tecnico = $this->tecnico_model->getTecnicos(array('id_tecnico'=>$this->session->userdata('id_tecnico')));;
	}

	function index($id_item = null) {
		if(!isset($id_item)){
			redirect('items/index');
		}
		
		$data['id_item'] = $id_item;
		$data['detalle_items'] = $this -> detalle_item_model -> getDetalleItems(array('id_item'=>$id_item));
		
		$data['item']  = $this->item_model->getItems(array('id_item'=>$id_item));
		
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'detalles_item/detalles_item_index';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function add($id_item = null) {
		if(!isset($id_item)){
			redirect('items/index');
		}
		
		$this -> form_validation -> set_rules('nombre_detalle', 'Nombre detalle', 'trim|required');
		$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|required');
		$this -> form_validation -> set_rules('serie', 'Serie', 'trim|required');
		
		
		if ($this -> form_validation -> run()) {
			$detalle_item = $this->detalle_item_model->addDetalleItem($_POST);
			if ($detalle_item) {
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
				redirect('detalles_item/index/'.$id_item);
			} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo agregar el detalle.</div>' 
											);
				redirect('detalles_item/index/'.$id_item);
			}
			
		}
		
		$data['id_item'] = $id_item;
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'detalles_item/detalles_item_add_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function edit($id_item,$id_detalle_item) {
	
		$data['detalle_item'] = $this -> detalle_item_model -> getDetalleItems(array('id_detalle_item'=>$id_detalle_item));
	
		if (!$data['detalle_item'])
			redirect('detalles_item/index/'.$id_item);
		
		$this -> form_validation -> set_rules('nombre_detalle', 'Nombre detalle', 'trim|required');
		$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|required');
		$this -> form_validation -> set_rules('serie', 'Serie', 'trim|required');
		
		
		if ($this -> form_validation -> run()) {
			//$_POST['id_cliente'] = $id_cliente;

			if ($this -> detalle_item_model -> updateDetalleItem($_POST)) {

				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Modificado exitosamente!.</div>' 
											);
				redirect('detalles_item/index/'.$id_item);
			} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo modificar el detalle.</div>' 
											);
				redirect('detalles_item/index/'.$id_item);
			}

		}
		
		//$data['id_detalle_item'] = $id_detalle_item;
		//$data['id_item'] = $id_item;
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'detalles_item/detalles_item_edit_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function delete($id_item,$id_detalle_item) {
		$data['detalle_item'] = $this -> detalle_item_model -> getDetalleItems(array('id_detalle_item'=>$id_detalle_item));
	
		if (!$data['detalle_item'])
			redirect('detalles_item/index/'.$id_item);
		
		if ($this -> detalle_item_model -> deleteDetalleItem(array('id_detalle_item' => $id_detalle_item))) {
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
			redirect('detalles_item/index/'.$id_item);
		} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo eliminar el detalle.</div>' 
											);
			redirect('detalles_item/index/'.$id_item);
		}
		
		
	}

}
?>