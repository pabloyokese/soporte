<?php
/**
 *
 */
class Recepcion extends CI_Controller {
	
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
		$this->tecnico = $this->tecnico_model->getTecnicos(array('id_tecnico'=>$this->session->userdata('id_tecnico')));
		date_default_timezone_set("America/La_Paz");
		
	}
	
	public function index()
	{
		$datos = array();
		if ($this->input->post()) {
			$datos = $_POST;
			$datos['filter'] = true;
			
			if ($_POST['id_cliente2']!='') {
				$datos['id_cliente'] = $datos['id_cliente2'];
				unset($datos['id_cliente2']);				
			}

			if ($_POST['id_cliente2']=='') {
				unset($datos['id_cliente2']);				
			}


			if ($_POST['id_tecnico_item']=='') {
				unset($datos['id_tecnico_item']);				
			}

			if ($_POST['id_tecnico_encargado']=='') {
				unset($datos['id_tecnico_encargado']);				
			}

			if ($datos['fecha_ingreso'] == '') {
				unset($datos['fecha_ingreso']);
			}

			if ($_POST['estado']=='vacio') {
				unset($datos['estado']);				
			}
			if ($_POST['estado']=='recepcionado') {
				$datos['estado'] = '0';				
			}
			if ($_POST['estado']=='diagnostico_realizado') {
				$datos['estado'] = '1';
			}
			if ($_POST['estado']=='reparacion_aceptada') {
				$datos['estado'] = '2';				
			}
			if ($_POST['estado']=='reparacion_cancelada') {
				$datos['estado'] = '3';				
			}
			if ($_POST['estado']=='en_reparacion') {
				$datos['estado'] = '4';				
			}
			if ($_POST['estado']=='listo') {
				$datos['estado'] = '5';				
			}
			if ($_POST['estado']=='entregado') {
				$datos['estado'] = '6';				
			}
			
			$datos['sortDirection'] = 'desc';
			$datos['sortBy'] = 'id_tecnico_item';
			$data['tecnico_items'] = $this->tecnico_item->getTecnicoItems($datos);
			//$data['tecnicos'] = $this -> tecnico_model -> getTecnicos($_POST);			
		}
		else{
			$data['tecnico_items'] = $this->tecnico_item->getTecnicoItems(array('sortDirection'=>'desc','sortBy'=>'id_tecnico_item'));
		}
		//print_r($datos);
		//print_r($_POST);
		//echo $this->db->last_query();
		print_r($data['tecnico_items']);
		//die();
		$data['clientes'] = $this->cliente_model->getClientes(array());
		$data['tecnicos'] = $this->tecnico_model->getTecnicos(array());

		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'recepcion/recepcion_index';
		$this -> load -> view('templates/plantilla_main', $data);
	}
	
	public function add()
	{
		
		$data['items'] = $this->item_model->getItems(array());	
		
		/*
		 * 
		 */
		$data['clientes'] = $this->cliente_model->getClientes(array());
		//
		
		$this -> form_validation -> set_rules('fecha_ingreso', 'Fecha de ingreso', 'trim|required');
		$this -> form_validation -> set_rules('id_item', 'Nombre de Producto', 'trim|required');
		$this -> form_validation -> set_rules('problema_reportado', 'Problema reportado', 'trim|required');
		
		
		if ($this -> form_validation -> run()) {
			
			//id de tecnico que recepciona
			$_POST['id_tecnico'] = $this->session->userdata('id_tecnico');

			//por ahora es el tecnico que tiene la session abierta luego se cambiar en modificar
			$_POST['id_tecnico_encargado'] = $this->session->userdata('id_tecnico');
			
			unset($_POST['id_cliente']);
			
			$this->db->trans_start();

			$id_recepcion = $this->tecnico_item->addTecnicoItem($_POST);
			/*
			 *	obtenemos el id de rececpion para modificar el estado del item a recepcionado
			 *  */
			$recepcion = $this->tecnico_item->getTecnicoItems(array('id_tecnico_item'=>$id_recepcion));
			
			$id_item = $recepcion->id_item;
			
			$this->item_model->updateItem(array('id_item'=>$id_item,'estado'=>'recepcionado'));
			/*
			 * 	ahora vamos a obtener todos los detalles del item actual para pasarlo a la tabla accesorios para historial 
			*/
			$detalles = $this->detalle_item_model->getDetalleItems(array('id_item'=>$id_item));
			
			foreach ($detalles as $detalle) {
				$array_detalles = array();
				//$array_detalles['id_accesorio']=$detalle->id_detalle_item;
				$array_detalles['nombre_accesorio']=$detalle->nombre_detalle;
				$array_detalles['descripcion']=$detalle->descripcion;
				$array_detalles['serie']=$detalle->serie;
				$array_detalles['id_tecnico_item']=$id_recepcion;	
				
				$this->accesorio_model->addAccesorio($array_detalles);
			}
		
			$this->db->trans_complete();
			
			
			
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
				redirect('recepcion');

			}
			else{
				$this->db->trans_rollback();
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('recepcion');
			}
			
		}
		
		$datestring = "%Y-%m-%d";
		$time = time();
		$data['fecha'] = mdate($datestring, $time); 
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'recepcion/recepcion_add_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	
	
	public function edit($id_tecnico_item)
	{
		$data['tecnico_item'] = $this->tecnico_item->getTecnicoItems(array('id_tecnico_item'=>$id_tecnico_item));
		$data['items'] = $this->item_model->getItems(array());	
		
		if (!$data['tecnico_item'])
			redirect('recepcion');
		
		$this -> form_validation -> set_rules('fecha_ingreso', 'Fecha de ingreso', 'trim|required');
		//$this -> form_validation -> set_rules('id_item', 'Nombre de Producto', 'trim|required');
		
		
		if ($this -> form_validation -> run()) {
			
			$_POST['id_tecnico_item'] = $id_tecnico_item;
			$_POST['id_tecnico'] = $this->session->userdata('id_tecnico');
			
			$datestring = "%Y-%m-%d";
			$time = time();
			$date_today = mdate($datestring, $time);

			
			$this->db->trans_start();
			
			
			$recepcion = $this->tecnico_item->getTecnicoItems(array('id_tecnico_item'=>$id_tecnico_item));	
			$id_item = $recepcion->id_item;
			
			
			if ($_POST['estado']==4) {
				if ($_POST['estado'] != $recepcion->estado) {
					$_POST['fecha_inicio_reparacion'] = $date_today;	
				}
			}
			
			if ($_POST['estado']==5) {
				if ($_POST['estado'] != $recepcion->estado) {
				$_POST['fecha_fin_reparacion'] = $date_today;
				}
			}
			
			if ($_POST['estado']==6) {
				if ($_POST['estado'] != $recepcion->estado) {
				$_POST['fecha_egreso'] = $date_today;
				$_POST['id_tecnico_que_entrego'] = $this->session->userdata('id_tecnico');
				$this->item_model->updateItem(array('id_item'=>$id_item,'estado'=>'norecepcionado'));
				}	
			}
			
			
			$id = $this->tecnico_item->updateTecnicoItem($_POST);
			$this->db->trans_complete();
			
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Modificado exitosamente!.</div>' 
											);
				redirect('recepcion');
			}
			else{
				$this->db->trans_rollback();
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('recepcion');
			}
		}
		
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'recepcion/recepcion_edit_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}
	public function delete($id_tecnico_item)
	{
		$data['tecnico_item'] = $this -> tecnico_item -> getTecnicoItems(array('id_tecnico_item' => $id_tecnico_item));

		if (!$data['tecnico_item'])
			redirect('recepcion');
			
		$id_item = $data['tecnico_item']->id_item;
		
		
		$this->db->trans_start();
		
		 //si el estado es igual 0 o recepcionado 
		if ($data['tecnico_item']->estado == '0' || $data['tecnico_item']->estado == '1' || $data['tecnico_item']->estado == '2' || $data['tecnico_item']->estado == '3'|| $data['tecnico_item']->estado == '4'|| $data['tecnico_item']->estado == '5') {
			$this->item_model->updateItem(array('id_item'=>$id_item,'estado'=>'norecepcionado'));
		}
		$this->item_cambiado_model->deleteItemCambiado(array('id_tecnico_item' => $id_tecnico_item));
		$this->diagnostico_model->deleteDiagnostico(array('id_tecnico_item' => $id_tecnico_item));
		$this->reparacion_model->deleteReparacion(array('id_tecnico_item' => $id_tecnico_item));
		$this->accesorio_model->deleteAccesorio(array('id_tecnico_item' => $id_tecnico_item));
		$this -> tecnico_item -> deleteTecnicoItem(array('id_tecnico_item' => $id_tecnico_item));
		$this->db->trans_complete();
		
		
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
			redirect('recepcion');
		} else {
			$this->db->trans_rollback();
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
			redirect('recepcion');
		}
		
	}
	
	
	/*
	 * functiones para devolver valores para ajx
	 */
	
	function listaItemsPorIdCliente()
	{
		$id_cliente = $this->input->post('id_cliente');
		$data['items'] = $this -> item_model -> getItems(array('id_cliente'=>$id_cliente,'estado'=>'norecepcionado'));
	
		//echo json_encode($data['items']);
		
		$this->load->view('recepcion/lista_items_por_id_cliente',$data);
	}

	/*
	*	function para cambiar el estado en perfil
	*/

	function cambiarEstado()
	{
		//echo 'Estado enviado desde el servidor ' . $this->input->post('estado');
		$datos = array();

		$estado = $this->input->post('estado');
		$id_tecnico_item = $this->input->post('id_tecnico_item');

		$datestring = "%Y-%m-%d";
		$time = time();
		$date_today = mdate($datestring, $time);
			
		$recepcion = $this->tecnico_item->getTecnicoItems(array('id_tecnico_item'=>$id_tecnico_item));	
		$id_item = $recepcion->id_item;

		$datos['id_tecnico_item'] = $id_tecnico_item;
		$datos['estado'] = $estado;

		if ($estado == 4) {
			$datos['fecha_inicio_reparacion'] = $date_today;	
		}
			
		if ($estado == 5) {	
			$datos['fecha_fin_reparacion'] = $date_today;
		}
			
		if ($estado == 6) {
			$datos['fecha_egreso'] = $date_today;
			$datos['id_tecnico_que_entrego'] = $this->session->userdata('id_tecnico');
			$this->item_model->updateItem(array('id_item'=>$id_item,'estado'=>'norecepcionado'));
		}
		//print_r($datos);
		//die();
		echo $this-> tecnico_item ->updateTecnicoItem($datos);

		/*

		if ($estado == '0') {
			echo '<option value="0"  >Recepcionado</option>';
		}					
		if($estado == '1'){
			echo '<option value="1">Diagnostico realizado</option>';
			echo '<option value="2">Reparacion Aceptada</option>';
			echo '<option value="3">Reparacion Cancelada</option>';
		}
		if ($estado == '2') {
			echo '<option value="2">Reparacion Aceptada</option>';
			echo '<option value="4">En reparacion</option>';
		}
		if ($estado == '3') {
			echo '<option value="3">Reparacion Cancelada</option>';
			echo '<option value="6">Entregado</option>';
		}
		if($estado == '4'){
			echo '<option value="4">En reparacion</option>';
			echo '<option value="5">Listo</option>';
		}
		if ($estado == '5') {
			echo '<option value="5">Listo</option>';
			echo '<option value="6">Entregado</option>';
		}
		if ($estado == '6') {
			echo '<option value="6">Entregado</option>';
		}
		*/
	}

}
?>