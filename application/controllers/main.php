<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
	
		
		$this->config->set_item('language','spanish');
		$this->form_validation->set_error_delimiters('	<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>', '</div>');
	}
	
	
	public function index()
	{
		$data['contenido'] = "main/main_index";
		$this->load->view('templates/plantilla',$data);
		
	}
	public function login()
	{
		if($this->tecnico_model->secure()){	
			redirect ( 'panel' );
		}
		
		$this->form_validation->set_rules('usuario','Usuario','trim|required|callback__check_login');
		$this->form_validation->set_rules('password','Password','trim|required');
		

		if($this->form_validation->run()){
			
			//print_r($_POST);
			//die('muere');
			
			if($this->tecnico_model->login(array('usuario'=>$this->input->post('usuario'),'password'=>$this->input->post('password'))))
			{
				redirect('panel');
			}
			redirect('main/login');
		}
		
		$data['contenido'] = 'main/login_form';
		$this->load->view('templates/plantilla',$data);
	}
	public function _check_login($usuario)
	{
		if($this->input->post('password')){
			$tecnico = $this->tecnico_model->getTecnicos(array('usuario'=>$usuario,'password'=>$this->input->post('password')));
			if($tecnico)	return true;
		}
		$this->form_validation->set_message('_check_login','Tu usuario / password es una combinación invalida.');
		return false;
	}
	
	
	
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}
