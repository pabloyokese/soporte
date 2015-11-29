<?php
/**
 *
 */
class Clientes extends CI_Controller {
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
		$this->load->library('fpdf');
		define('FPDF_FONTPATH',BASEPATH.'application/libraries/font/');
		
	}

	function index($offset = 0) {

		$this->load->library('pagination');
		$perpage = 400;
		
		$config['base_url'] = base_url(). 'clientes/index/';
		$config['total_rows'] = $this->cliente_model->getClientes (array('count'=>true));
		$config['per_page']=$perpage;
		$config['url_segment'] = 3;
		$config['first_link'] = 'Primero';
		$config['last_link'] = 'Ultimo';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		if ($this->input->post()) {
			$_POST['filter'] = true;
			$_POST['limit'] = $perpage;
			$_POST['offset'] = $offset;
			$_POST['sortDirection'] = 'desc';
			$_POST['sortBy'] = 'id_cliente';

			$data['clientes'] = $this -> cliente_model -> getClientes($_POST);
		}
		else{
			$data['clientes'] = $this -> cliente_model -> getClientes(array('limit'=>$perpage,'offset' =>$offset,'sortDirection'=>'desc','sortBy'=>'id_cliente'));
		}
		
		//echo $this->db->last_query();
		//$data['clientes'] = $this -> cliente_model -> getClientes(array('limit'=>$perpage,'offset' =>$offset,'sortDirection'=>'desc','sortBy'=>'id_cliente'));
		$data['total_rows'] = $config['total_rows'];
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'clientes/clientes_index';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function add() {
		/*
		 * Para ajax
		 * */
		if(isset($_POST['ajax'])){
			unset($_POST['ajax']);
			$cliente = $this -> cliente_model -> addCliente($_POST);
			
			if ($cliente) {
				echo '<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' ;
			}
			else{
				echo '<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Error! Ocurrio un error con la base de datos.</div>' ;
			}
			die();
		}
		
		
		
		$this -> form_validation -> set_rules('nombre_contacto', 'Nombre', 'trim|required');
		$this -> form_validation -> set_rules('apellido_paterno_contacto', 'Apellido Paterno', 'trim|required');
		$this -> form_validation -> set_rules('apellido_materno_contacto', 'Apellido Materno', 'trim|required');
		$this -> form_validation -> set_rules('email_contacto', 'Email', 'trim|required|valid_email');
		$this -> form_validation -> set_rules('telefono_contacto', 'Telefono', 'trim|required|is_natural');
		$this -> form_validation -> set_rules('movil_contacto', 'Movil', 'trim|required|is_natural');
		$this -> form_validation -> set_rules('direccion_contacto', 'Direccion', 'trim|required');
		//$this->form_validation->set_rules ( 'nombre_empresa', 'Nombre', 'trim|required' );
		//$this->form_validation->set_rules ( 'telefono_empresa', 'Telefono', 'trim|required' );
		//$this->form_validation->set_rules ( 'movil_empresa', 'Movil', 'trim|required' );
		//$this->form_validation->set_rules ( 'direccion_empresa', 'Direccion', 'trim|required' );
		if ($this -> form_validation -> run()) {
			//print_r($_POST);
			$cliente = $this -> cliente_model -> addCliente($_POST);

			if ($cliente) {
				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
				redirect('clientes');
			} else {
				
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo agregar al Cliente.</div>' 
											);
				redirect('clientes');
			}
		}
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'clientes/clientes_add_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function edit($id_cliente) {

		$data['clientes'] = $this -> cliente_model -> getClientes(array('id_cliente' => $id_cliente));

		if (!$data['clientes'])
			redirect('clientes');
		$this -> form_validation -> set_rules('nombre_contacto', 'Nombre', 'trim|required');
		$this -> form_validation -> set_rules('apellido_paterno_contacto', 'Apellido Paterno', 'trim|required');
		$this -> form_validation -> set_rules('apellido_materno_contacto', 'Apellido Materno', 'trim|required');
		$this -> form_validation -> set_rules('email_contacto', 'Email', 'trim|required|valid_email');
		$this -> form_validation -> set_rules('telefono_contacto', 'Telefono', 'trim|required|is_natural');
		$this -> form_validation -> set_rules('movil_contacto', 'Movil', 'trim|required|is_natural');
		$this -> form_validation -> set_rules('direccion_contacto', 'Direccion', 'trim|required');
		//$this->form_validation->set_rules ( 'nombre_empresa', 'Nombre', 'trim|required' );
		//$this->form_validation->set_rules ( 'telefono_empresa', 'Telefono', 'trim|required' );
		//$this->form_validation->set_rules ( 'movil_empresa', 'Movil', 'trim|required' );
		//$this->form_validation->set_rules ( 'direccion_empresa', 'Direccion', 'trim|required' );
			

		if ($this -> form_validation -> run()) {
			$_POST['id_cliente'] = $id_cliente;
			
			if ($this -> cliente_model -> updateCliente($_POST)) {

				$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Modificado exitosamente!.</div>' 
											);
				redirect('clientes');
			} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, no se pudo modificar al cliente.</div>' 
											);
				redirect('clientes');
			}

		}
		
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'clientes/clientes_edit_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function delete($id_cliente) {
		$data['clientes'] = $this -> cliente_model -> getClientes(array('id_cliente' => $id_cliente));

		if (!$data['clientes'])
			redirect('clientes');

		$message_delete_cliente = $this -> cliente_model -> deleteCliente(array('id_cliente' => $id_cliente));

		$error = $this -> db -> _error_message();

		if ($message_delete_cliente) {
			if ($error) {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, no se pudo eliminar al Cliente</div>' 
											);
				redirect('clientes');
			}
			$this->session->set_flashdata ( 
											'flashConfirm', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
			redirect('clientes');
		} else {
			$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, no se pudo eliminar al Cliente.</div>' 
											);
			redirect('clientes');
		}

	}
	/*
	 * Lista de clientes para ajax
	 */ 
	function listarClientes(){
		$data['clientes'] = $this -> cliente_model -> getClientes(array());

		$this->load->view('clientes/lista_clientes',$data);
	}
	
	
	
	function imprimir()
	{
		//inicializa pagina pdf
		$this->fpdf->Open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Arial','B',15);
	    // Move to the right
	    $this->fpdf->Cell(70);
	    // Title
	   	$this->fpdf->Cell(50,10,'Lista de Clientes',0,0,'C');
	    // Line break
	    $this->fpdf->Ln(20);
		//dibuja rectangulo
		//$this->fpdf->Rect(20,10,180,137,'D');
		$this->fpdf->SetFont('Arial','',12);
		$clientes = $this->cliente_model->getClientes(array());
		
		foreach ($clientes as $cliente) {
			$nombre_cliente = $cliente->nombre_contacto.' '.$cliente->apellido_paterno_contacto. ' '.$cliente->apellido_materno_contacto ;
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(40,10,'Nombre Usuario: ',1);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$nombre_cliente,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Email: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(40,10,$cliente->email_contacto);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Telefono: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(40,10,$cliente->telefono_contacto,0);
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Movil: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$cliente->movil_contacto);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Direccion: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$cliente->direccion_contacto);
			$this->fpdf->Ln();
			

			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(45,10,'Nombre Empresa: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$cliente->nombre_empresa);
			$this->fpdf->Ln();

			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(45,10,'Telefono Empresa: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$cliente->telefono_empresa);
			$this->fpdf->Ln();
			
			
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(45,10,'Movil Empresa: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$cliente->movil_empresa);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(45,10,'Direccion Empresa: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$cliente->direccion_empresa);
			$this->fpdf->Ln();
				
		}
		
		/*
		$header = array('Id de cliente', 
						'Nombre ', 
						'Apellido Paterno', 
						'Apellido Materno',
						'Email',
						'Telefono',
						'Movil',
						'Direccion',
						'Nombre Empresa',
						'Telefono Empresa',
						'Movil Empresa',
						'Direccion Empresa');
		// Header
	    foreach($header as $col)
	        $this->fpdf->Cell(40,7,$col,1);
	    $this->fpdf->Ln();
	    // Data
	    foreach($clientes as $row)
	    {
	        foreach($row as $col)
	            $this->fpdf->Cell(40,6,$col,1);
	        $this->fpdf->Ln();
	    }
		 
		 */
		//finaliza y muestra en pantalla pdf
		$this->fpdf->Output();		
	}

}
?>