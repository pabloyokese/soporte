<?php
/**
 *
 */
class Items extends CI_Controller {
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
		$this->load->library('fpdf');
		define('FPDF_FONTPATH',BASEPATH.'application/libraries/font/');
	}

	function index() {
		
		if ($this->input->post()) {
			$_POST['filter'] = true;
			if ($_POST['id_cliente2']!='') {
				$_POST['id_cliente'] = $_POST['id_cliente2'];				
			}
			if ($_POST['estado']=='') {
				unset($_POST['estado']);				
			}
			if ($_POST['garantia']=='') {
				unset($_POST['garantia']);				
			}				
			
			//unset($_POST['id_cliente2']);
			$_POST['sortDirection'] = 'desc';
			$_POST['sortBy'] = 'id_item';
			$data['items'] = $this -> item_model -> getItems($_POST);
			//$data['tecnicos'] = $this -> tecnico_model -> getTecnicos($_POST);			
		}
		else{
			$data['items'] = $this -> item_model -> getItems(array('sortDirection'=>'desc','sortBy'=>'id_item'));
		}
		//print_r($_POST);
		//echo $this->db->last_query();

		$data['clientes'] = $this->cliente_model->getClientes();
		
		$data['tecnico'] = $this->tecnico;
		
		$data['contenido'] = 'items/items_index';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function add() {
		/*
		 * Para ajax
		 * */
		
		if(isset($_POST['ajax'])){
			unset($_POST['ajax']);
			
			$item = $this -> item_model -> addItem($_POST);
			if ($item) {
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
		
		
		
		$data['clientes'] = $this -> cliente_model -> getClientes(array());
		
		$this -> form_validation -> set_rules('nombre_item', 'Nombre', 'trim|required');
		$this -> form_validation -> set_rules('id_cliente', 'Nombre de Cliente', 'trim|required');
		$this -> form_validation -> set_rules('garantia', 'Garantia', 'trim|required');
		
		if ($this -> form_validation -> run()) {
			
			$item = $this->item_model->addItem($_POST);
			
			if($item)
			{
				$this->session->set_flashdata ( 
												'flashConfirm', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button> Success! Agregado exitosamente!.</div>' 
												);
				redirect('items');
			}
			else{
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo agregar el Producto.</div>' 
											);
				redirect('items');
			}		
		}
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'items/items_add_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function edit($id_item) {
			
		$data['items'] = $this -> item_model -> getItems(array('id_item' => $id_item));
		$data['clientes'] = $this -> cliente_model -> getClientes(array());
		
		if (!$data['items'])
			redirect('items');
		
		$this -> form_validation -> set_rules('nombre_item', 'Nombre', 'trim|required');
		$this -> form_validation -> set_rules('id_cliente', 'Nombre de Cliente', 'trim|required');
		
		if ($this -> form_validation -> run()) {
			
		$_POST['id_item'] = $id_item;
				
			if ($this -> item_model -> updateItem($_POST)) {

				$this->session->set_flashdata ( 
												'flashConfirm', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button> Success! Modificado exitosamente!.</div>' 
												);
				redirect('items');
			} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo modificar el producto.</div>' 
											);
				redirect('items');
			}

		}
		$data['tecnico'] = $this->tecnico;
		$data['contenido'] = 'items/items_edit_form';
		$this -> load -> view('templates/plantilla_main', $data);
	}

	function delete($id_item) {
		$data['items'] = $this -> item_model -> getItems(array('id_item' => $id_item));

		if (!$data['items'])
			redirect('items');

		$message_delete_item = $this -> item_model -> deleteItem(array('id_item' => $id_item));

		$error = $this -> db -> _error_message();
		//para capturar el error
		
		
		if ($message_delete_item) {
			if ($error) {
				$this->session->set_flashdata ( 
												'flashConfirm', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button>Error! Ocurrio un error con la base de datos, No se pudo elimiar el producto.</div>' 
												);
				redirect('items');
			}	
				$this->session->set_flashdata ( 
												'flashConfirm', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button> Success! Eliminado exitosamente!.</div>' 
												);
				redirect('items');
		} else {
				$this->session->set_flashdata ( 
											'flashError', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos, No se pudo elimiar el producto.</div>' 
											);
			redirect('items');
		}

	}
	/*
	function getItemsTable()
	{
		$id_cliente = $_POST['id_cliente'];
		if ($_POST['id_cliente']=='null') {
			$data['items'] = $this -> item_model -> getItems(array('sortDirection'=>'desc','sortBy'=>'id_item'));
		}
		else{
			$data['items'] = $this -> item_model -> getItems(array('id_cliente'=>$id_cliente,'sortDirection'=>'desc','sortBy'=>'id_item'));
		}
		
		$this->load->view('items/items_table_ajax',$data);
	}
	*/
	
	
	
	
		function imprimir()
	{
		//inicializa pagina pdf
		$this->fpdf->Open();
		$this->fpdf->AddPage();
		
		$this->fpdf->SetFont('Arial','B',15);
	    // Move to the right
	    $this->fpdf->Cell(70);
	    // Title
	   	$this->fpdf->Cell(50,10,'Lista de Productos',0,0,'C');
	    // Line break
	    $this->fpdf->Ln(20);
		//dibuja rectangulo
		//$this->fpdf->Rect(20,10,180,137,'D');
		$this->fpdf->SetFont('Arial','',12);
		$items = $this->item_model->getItems(array());
		
		foreach ($items as $item) {
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Producto: ',1);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$item->nombre_item,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(30,10,'Pertenece a: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(40,10,$item->nombre_contacto .' '. $item->apellido_paterno_contacto .' '. $item->apellido_materno_contacto,0);
			$this->fpdf->Ln();
			
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Modelo: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(40,10,$item->modelo,0);
			$this->fpdf->Ln();

			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(25,10,'Serie: ',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(40,10,$item->serie,0);
			$this->fpdf->Ln();	
			
			/*
			 * aqui comienza el detalle
			 */
			
			$detalles = $this->detalle_item_model->getDetalleItems(array('id_item'=>$item->id_item));
			
			
			
			
			foreach ($detalles as $detalle) {
				
				$this->fpdf->SetFont('Arial','B',12);
				$this->fpdf->Cell(0,10,'Detalle: ',0);
				$this->fpdf->SetFont('Arial','',12);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(40,10,$detalle->nombre_detalle,0);
				$this->fpdf->Ln();
				
				$this->fpdf->SetFont('Arial','',12);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(40,10,$detalle->descripcion,0);
				$this->fpdf->Ln();		
				
				$this->fpdf->SetFont('Arial','',12);
				$this->fpdf->Cell(25);
				$this->fpdf->Cell(40,10,$detalle->serie,0);
				$this->fpdf->Ln();
			}
			
			$this->fpdf->Ln();				
		}

		//finaliza y muestra en pantalla pdf
		$this->fpdf->Output();		
	}
	
}
?>