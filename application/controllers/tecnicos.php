<?php
/**
 *
 */
class Tecnicos extends CI_Controller {

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
		$this -> tecnico = $this -> tecnico_model -> getTecnicos(array('id_tecnico' => $this -> session -> userdata('id_tecnico'))); ;
	}

	public function index() {
		if ($this->input->post()) {
			$_POST['filter'] = true;
			$data['tecnicos'] = $this -> tecnico_model -> getTecnicos($_POST);			
		}
		else{
			$data['tecnicos'] = $this -> tecnico_model -> getTecnicos(array());	
		}
		
		//print_r($data['tecnicos']);
		//echo $this->db->last_query();
		//die();
		$data['tecnico'] = $this -> tecnico;
		$data['contenido'] = 'tecnicos/tecnicos_index';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	public function add() {
		$this -> form_validation -> set_rules('ci','Ci','trim|required|callback__check_ci');
		$this -> form_validation -> set_rules('nombre','Nombre','trim|required');
		$this -> form_validation -> set_rules('apellido_paterno','Apellido Paterno','trim|required');
		$this -> form_validation -> set_rules('apellido_materno','Apellido Materno','trim|required');
		$this -> form_validation -> set_rules('usuario','Usuario','trim|required|callback__check_user');
		$this -> form_validation -> set_rules('password','Password','trim|required');
		$this -> form_validation -> set_rules('repeat_password','Confirma tu Password','trim|required|matches[password]');
		$this -> form_validation -> set_rules('email','Email','trim|required|valid_email');
		$this -> form_validation -> set_rules('telefono','Telefono','trim|required|is_natural');
		$this -> form_validation -> set_rules('movil','Movil','trim|required|is_natural');	
		$this -> form_validation -> set_rules('direccion','Direccion','trim|required');

		if ($this->form_validation ->run()) {
			unset($_POST['repeat_password']);
			$_POST['password'] = md5($_POST['password']);
			$tecnico = $this->tecnico_model -> addTecnico($_POST);
			if ($tecnico) {
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
				redirect('tecnicos');
			} else {
				
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo agregar al Tecnico.</div>' 
											);
				redirect('tecnicos');
			}
		}


		$data['tecnico'] = $this -> tecnico;
		$data['contenido'] = 'tecnicos/tecnicos_add_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	/*
	*	Funciones de validacion para add
	*/
	public function _check_user($usuario){
		//echo "<script>alert('".$usuario."')</script>";
		$user_exists = $this -> tecnico_model -> getTecnicos(array('usuario'=>$usuario));
		if($user_exists){
			$this->form_validation->set_message('_check_user','El nombre de usuario ya existe seleciona otro.');
			//echo "<script>alert('elusuario existe')</script>";
			return false;
		}
		return true;
	}

	public function _check_ci($ci){
		$ci_exists = $this -> tecnico_model -> getTecnicos(array('ci'=>$ci));
		if($ci_exists){
			$this->form_validation->set_message('_check_ci','El ci ya existe en la bd seleciona otro.');
			//echo "<script>alert('elusuario existe')</script>";
			return false;
		}
		return true;	
	}

	/*
	*	Funciones de validacion para edit
	*/

	public function _check_user_edit($usuario){
		$user_exists = $this -> tecnico_model -> getTecnicos(array('usuario'=>$usuario));
		if(count($user_exists)>=1){
			$this->form_validation->set_message('_check_user_edit','El nombre de usuario ya existe seleciona otro.');
			return false;
		}
		return true;
	}

	public function _check_ci_edit($ci){
		
		$ci_exists = $this -> tecnico_model -> getTecnicos(array('ci'=>$ci));
		if(count($ci_exists)>=1){
			$this->form_validation->set_message('_check_ci_edit','El ci ya existe en la bd seleciona otro.');
			return false;
		}
		return true;	
	}

	public function edit($id_tecnico){

		$data['tecnico_selected'] = $this->tecnico_model -> getTecnicos(array('id_tecnico'=>$id_tecnico)); 

		if ($this->input->post('ci')!=$data['tecnico_selected']->ci) {
			$this -> form_validation -> set_rules('ci','Ci','trim|required|callback__check_ci_edit');
		}
		$this -> form_validation -> set_rules('nombre','Nombre','trim|required');
		$this -> form_validation -> set_rules('apellido_paterno','Apellido Paterno','trim|required');
		$this -> form_validation -> set_rules('apellido_materno','Apellido Materno','trim|required');
		if ($this->input->post('usuario')!=$data['tecnico_selected']->usuario) {
			$this -> form_validation -> set_rules('usuario','Usuario','trim|required|callback__check_user_edit');	
		}
			
		
		if (isset($_POST['password'])) {
			if ($_POST['password'] != '') {
				$this -> form_validation -> set_rules('password','Password','trim|required');
				$this -> form_validation -> set_rules('repeat_password','Confirma tu Password','trim|required|matches[password]');		
			}	
		}
		$this -> form_validation -> set_rules('email','Email','trim|required|valid_email');
		$this -> form_validation -> set_rules('telefono','Telefono','trim|required|is_natural');
		$this -> form_validation -> set_rules('movil','Movil','trim|required|is_natural');	
		$this -> form_validation -> set_rules('direccion','Direccion','trim|required');

		if ($this->form_validation ->run()) {
			
			if ($_POST['password'] == '') {
				unset($_POST['password']);
			}
			unset($_POST['repeat_password']);
			$_POST['id_tecnico'] = $id_tecnico;	
			
			//print_r($_POST);
			//die();
			if ($this->tecnico_model->updateTecnico($_POST)) {

				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Modificado exitosamente!.</div>' 
											);
				redirect('tecnicos');
			} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, no se pudo modificar al Tecnico.</div>' 
											);
				redirect('tecnicos');
			}
		}


		$data['tecnico'] = $this -> tecnico;
		$data['contenido'] = 'tecnicos/tecnicos_edit_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	public function delete($id_tecnico){

		$data['tecnico'] = $this->tecnico_model -> getTecnicos(array('id_tecnico'=>$id_tecnico));
		if (!$data['tecnico']) {
			redirect('tecnicos');
		}

		$message_delete_tecnico = $this->tecnico_model->delete(array('id_tecnico'=>$id_tecnico));

		$error = $this -> db -> _error_message();

		if ($message_delete_tecnico) {
			if ($error) {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, no se pudo eliminar al Tecnico.</div>' 
											);
				redirect('tecnicos');
			}
			$this->session->set_flashdata ( 
												'flashConfirm', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button> Success! Eliminado exitosamente!.</div>' 
												);
			redirect('tecnicos');
		} else {
			$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, no se pudo eliminar al Tecnico.</div>' 
											);
			redirect('tecnicos');
		}
	}


}
?>