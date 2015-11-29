<?php
   /**
    * 
    */
   class Perfil extends CI_Controller {
       
       function __construct() {
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
		$this->config->set_item('language','spanish');
		$this->form_validation->set_error_delimiters('	<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>', '</div>');
		$this->tecnico = $this->tecnico_model->getTecnicos(array('id_tecnico'=>$this->session->userdata('id_tecnico')));
       	
       	$this->load->library('fpdf');
		define('FPDF_FONTPATH',BASEPATH.'application/libraries/font/');
	   }
	   
	   function index($id_tecnico_item)
	   {
		
			$data['tecnico_item'] = $this -> tecnico_item -> getTecnicoItems(array('id_tecnico_item' => $id_tecnico_item));
			if (!$data['tecnico_item']) {
				redirect('recepcion/index');
			}
			
			$data['diagnosticos'] = $this -> diagnostico_model -> getDiagnosticos(array('id_tecnico_item' => $id_tecnico_item));
			$data['reparaciones'] = $this -> reparacion_model -> getReparaciones(array('id_tecnico_item' => $id_tecnico_item));
			
			$data['items_cambiados'] = $this-> item_cambiado_model -> getItemsCambiados(array('id_tecnico_item' => $id_tecnico_item));
			
			
			
			$id_item = $data['tecnico_item']->id_item;
			
			$data['item'] = $this->item_model->getItems(array('id_item'=>$id_item));
			
			$data['accesorios'] = $this->accesorio_model->getAccesorios(array('id_tecnico_item'=>$id_tecnico_item));
	
			
			$data['tecnico'] = $this->tecnico;
			
		   	$data['contenido'] = 'perfil/perfil_index';
		   	$this->load->view('templates/plantilla_main',$data);
	   }
	   
	   /*
	   Adicionar un diagnostico.
	   */
	   function addDiagnostico($id_tecnico_item){
	   	$this -> form_validation -> set_rules('problema_encontrado', 'Problema encontrado', 'trim|required');
		$this -> form_validation -> set_rules('tipo_problema', 'Tipo problema', 'trim|required');
		
		if ($this -> form_validation -> run()) {
			
			$_POST['id_tecnico_item'] = $id_tecnico_item;
			
			$this->db->trans_start();
			
			$diagnostico = $this->diagnostico_model->addDiagnostico($_POST);
			
			$estado_actual = $this->tecnico_item->getTecnicoItems(array('id_tecnico_item'=>$id_tecnico_item))->estado;
			
			if ($estado_actual =='0') {
				$this->tecnico_item->updateTecnicoItem(array('id_tecnico_item'=>$id_tecnico_item,'estado'=>'1'));
			}
			
			$this->db->trans_complete();

			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$this->session->set_flashdata ( 
											'flashConfirmDiagnostico', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$id_tecnico_item);
			}
			else{
				$this->db->trans_rollback();
				$this->session->set_flashdata ( 
											'flashErrorDiagnostico', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$id_tecnico_item);
			}		
				
		}
		
		$data['id_tecnico_item'] = $id_tecnico_item;
		$data['tecnico'] = $this->tecnico;
	   	$data['contenido'] = 'perfil/perfil_add_diagnostico_form';
	   	$this->load->view('templates/plantilla_main',$data);
	   }
	   
	   public function editDiagnostico($id_diagnostico){

	   	$data['diagnosticos'] = $this -> diagnostico_model -> getDiagnosticos(array('id_diagnostico' => $id_diagnostico));
		
		$this -> form_validation -> set_rules('problema_encontrado', 'Problema encontrado', 'trim|required');
		
		if ($this -> form_validation -> run()) {
			$_POST['id_diagnostico'] = $id_diagnostico;	
			//print_r($_POST);
			if ($this -> diagnostico_model -> updateDiagnostico($_POST)) {

				$this->session->set_flashdata ( 
											'flashConfirmDiagnostico', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Modificado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$data['diagnosticos']->id_tecnico_item);
			} else {
				$this->session->set_flashdata ( 
											'flashErrorDiagnostico', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$data['diagnosticos']->id_tecnico_item);
			}
			
		}
		$data['tecnico'] = $this->tecnico;
	   	$data['contenido'] = 'perfil/perfil_edit_diagnostico_form';
	   	$this->load->view('templates/plantilla_main',$data);
	   }
	   
	   public function deleteDiagnostico($id_diagnostico)
	   {
	    	$data['diagnosticos'] = $this -> diagnostico_model -> getDiagnosticos(array('id_diagnostico' => $id_diagnostico));

			if (!$data['diagnosticos'])
				redirect('perfil/index/'.$data['diagnosticos']->id_tecnico_item);

			$this->db->trans_start();

			$estado_actual = $this-> tecnico_item -> getTecnicoItems(array('id_tecnico_item'=>$data['diagnosticos']->id_tecnico_item))->estado;
			if ($estado_actual == '1') {
				$numero_diagnosticos = count($this-> diagnostico_model -> getDiagnosticos(array('id_tecnico_item'=>$data['diagnosticos']->id_tecnico_item)));		
				//echo $numero_diagnosticos;
				if ($numero_diagnosticos == 1) {
					$this->tecnico_item->updateTecnicoItem(array('id_tecnico_item'=>$data['diagnosticos']->id_tecnico_item,'estado'=>'0'));
				}
			}

			
			$this -> diagnostico_model -> deleteDiagnostico(array('id_diagnostico' => $id_diagnostico));

			$this->db->trans_complete();

	
			if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				$this->session->set_flashdata ( 
											'flashConfirmDiagnostico', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$data['diagnosticos']->id_tecnico_item);
			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata ( 
											'flashErrorDiagnostico', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$data['diagnosticos']->id_tecnico_item);
			}
	   }
	   
	    function addReparacion($id_tecnico_item)
	   {
	   		$this -> form_validation -> set_rules('solucion', 'Solucion', 'trim|required');
			
			if ($this -> form_validation -> run()) {
				$_POST['id_tecnico_item'] = $id_tecnico_item;
				
				$reparacion = $this->reparacion_model->addReparacion($_POST);
			
				if($reparacion)
				{
				$this->session->set_flashdata ( 
											'flashConfirmReparacion', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
					redirect('perfil/index/'.$id_tecnico_item);
				}
				else{
				$this->session->set_flashdata ( 
											'flashErrorReparacion', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
					redirect('perfil/index/'.$id_tecnico_item);
				}		
				
			}
			$data['tecnico'] = $this->tecnico;
			$data['id_tecnico_item'] = $id_tecnico_item;
		   	$data['contenido'] = 'perfil/perfil_add_reparacion_form';
		   	$this->load->view('templates/plantilla_main',$data);
	   }
	   
	     public function editReparacion($id_reparacion){
	   	$data['reparaciones'] = $this -> reparacion_model -> getReparaciones(array('id_reparacion' => $id_reparacion));
		
		$this -> form_validation -> set_rules('solucion', 'Problema encontrado', 'trim|required');
		
		if ($this -> form_validation -> run()) {
			$_POST['id_reparacion'] = $id_reparacion;	
			//print_r($_POST);
			if ($this -> reparacion_model -> updateReparacion($_POST)) {

				$this->session->set_flashdata ( 
											'flashConfirmReparacion', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Modificado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$data['reparaciones']->id_tecnico_item);
			} else {
				$this->session->set_flashdata ( 
											'flashErrorReparacion', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$data['reparaciones']->id_tecnico_item);
			}
			
		}
		$data['tecnico'] = $this->tecnico;
	   	$data['contenido'] = 'perfil/perfil_edit_reparacion_form';
	   	$this->load->view('templates/plantilla_main',$data);
	   }
	   
	    public function deleteReparacion($id_reparacion)
	   {
	    	$data['reparaciones'] = $this -> reparacion_model -> getReparaciones(array('id_reparacion' => $id_reparacion));

			if (!$data['reparaciones'])
				redirect('perfil/index/'.$data['reparaciones']->id_tecnico_item);
	
			if ($this -> reparacion_model -> deleteReparacion(array('id_reparacion' => $id_reparacion))) {
				$this->session->set_flashdata ( 
											'flashConfirmReparacion', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$data['reparaciones']->id_tecnico_item);
			} else {
				$this->session->set_flashdata ( 
											'flashErrorReparacion', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$data['reparaciones']->id_tecnico_item);
			}
	   }

		public function addAccesorio($id_tecnico_item)
		{
			$this -> form_validation -> set_rules('nombre_accesorio', 'Nombre accesorio', 'trim|required');
			$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|required');
			
			if ($this -> form_validation -> run()) {
				$_POST['id_tecnico_item'] = $id_tecnico_item;

				$accesorio = $this->accesorio_model->addAccesorio($_POST);
			
				if($accesorio)
				{
				$this->session->set_flashdata ( 
											'flashConfirmAccesorio', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
					redirect('perfil/index/'.$id_tecnico_item);
				}
				else{
				$this->session->set_flashdata ( 
											'flashErrorAccesorio', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
					redirect('perfil/index/'.$id_tecnico_item);
				}		
				
			}
			$data['tecnico'] = $this->tecnico;
			$data['id_tecnico_item'] = $id_tecnico_item;
		   	$data['contenido'] = 'perfil/perfil_add_accesorio_form';
		   	$this->load->view('templates/plantilla_main',$data);
		}
		
		public function editAccesorio($id_accesorio)
		{
			$data['accesorios'] = $this -> accesorio_model -> getAccesorios(array('id_accesorio' => $id_accesorio));
		
			$this -> form_validation -> set_rules('nombre_accesorio', 'Nombre accesorio', 'trim|required');
			$this -> form_validation -> set_rules('descripcion', 'Descripcion', 'trim|required');
		
			if ($this -> form_validation -> run()) {
				$_POST['id_accesorio'] = $id_accesorio;	
				//print_r($_POST);
				if ($this -> accesorio_model -> updateAccesorio($_POST)) {
	
					$this->session->set_flashdata ( 
												'flashConfirmAccesorio', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button> Success! Modificado exitosamente!.</div>' 
												);
					redirect('perfil/index/'.$data['accesorios']->id_tecnico_item);
				} else {
					$this->session->set_flashdata ( 
												'flashErrorAccesorio', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button>Error! Ocurrio un error con la base de datos.</div>' 
												);
					redirect('perfil/index/'.$data['accesorios']->id_tecnico_item);
				}
			
		}
		$data['tecnico'] = $this->tecnico;
	   	$data['contenido'] = 'perfil/perfil_edit_accesorio_form';
	   	$this->load->view('templates/plantilla_main',$data);
			
		}
		
		
		 public function deleteAccesorio($id_accesorio)
	   {
	    	$data['accesorios'] = $this -> accesorio_model -> getAccesorios(array('id_accesorio' => $id_accesorio));

			if (!$data['accesorios'])
				redirect('perfil/index/'.$data['accesorios']->id_tecnico_item);
	
			if ($this -> accesorio_model -> deleteAccesorio(array('id_accesorio' => $id_accesorio))) {
				$this->session->set_flashdata ( 
											'flashConfirmAccesorio', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$data['accesorios']->id_tecnico_item);
			} else {
				$this->session->set_flashdata ( 
											'flashErrorAccesorio', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$data['accesorios']->id_tecnico_item);
			}
	   }
		
		public function addItemCambiado($id_tecnico_item)
		{
			$this -> form_validation -> set_rules('nombre_item_cambiado', 'Nombre', 'trim|required');
			$this -> form_validation -> set_rules('detalle', 'Detalle', 'trim|required');
			
			if ($this -> form_validation -> run()) {
				$_POST['id_tecnico_item'] = $id_tecnico_item;

				$item_cambiado = $this->item_cambiado_model->addItemCambiado($_POST);
			
				if($item_cambiado)
				{
				$this->session->set_flashdata ( 
											'flashConfirmItemCambiado', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Agregado exitosamente!.</div>' 
											);
					redirect('perfil/index/'.$id_tecnico_item);
				}
				else{
				$this->session->set_flashdata ( 
											'flashErrorItemCambiado', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
					redirect('perfil/index/'.$id_tecnico_item);
				}		
				
			}
			$data['tecnico'] = $this->tecnico;
			$data['id_tecnico_item'] = $id_tecnico_item;
		   	$data['contenido'] = 'perfil/perfil_add_item_cambiado_form';
		   	$this->load->view('templates/plantilla_main',$data);
		}

		public function editItemCambiado($id_item_cambiado)
		{
			$data['item_cambiado'] = $this -> item_cambiado_model -> getItemsCambiados(array('id_item_cambiado' => $id_item_cambiado));
		
			$this -> form_validation -> set_rules('nombre_item_cambiado', 'Nombre', 'trim|required');
			$this -> form_validation -> set_rules('detalle', 'Detalle', 'trim|required');
		
			if ($this -> form_validation -> run()) {
				$_POST['id_item_cambiado'] = $id_item_cambiado;	
				//print_r($_POST);
				if ($this -> item_cambiado_model -> updateItemCambiado($_POST)) {
	
					$this->session->set_flashdata ( 
												'flashConfirmItemCambiado', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button> Success! Modificado exitosamente!.</div>' 
												);
					redirect('perfil/index/'.$data['item_cambiado']->id_tecnico_item);
				} else {
					$this->session->set_flashdata ( 
												'flashErrorItemCambiado', 
												'<div class="alert alert-error" >
															<button class="close" data-dismiss="alert">
																×
															</button>Error! Ocurrio un error con la base de datos.</div>' 
												);
					redirect('perfil/index/'.$data['item_cambiado']->id_tecnico_item);
				}
			
		}
		$data['tecnico'] = $this->tecnico;
	   	$data['contenido'] = 'perfil/perfil_edit_item_cambiado_form';
	   	$this->load->view('templates/plantilla_main',$data);
		}



		
		 public function deleteItemCambiado($id_item_cambiado)
	   {
	    	$data['item_cambiado'] = $this -> item_cambiado_model -> getItemsCambiados(array('id_item_cambiado' => $id_item_cambiado));

			if (!$data['item_cambiado'])
				redirect('perfil/index/'.$data['item_cambiado']->id_tecnico_item);
	
			if ($this -> item_cambiado_model -> deleteItemCambiado(array('id_item_cambiado' => $id_item_cambiado))) {
				$this->session->set_flashdata ( 
											'flashConfirmItemCambiado', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button> Success! Eliminado exitosamente!.</div>' 
											);
				redirect('perfil/index/'.$data['item_cambiado']->id_tecnico_item);
			} else {
				$this->session->set_flashdata ( 
											'flashErrorItemCambiado', 
											'<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Error! Ocurrio un error con la base de datos.</div>' 
											);
				redirect('perfil/index/'.$data['item_cambiado']->id_tecnico_item);
			}
	   }
		
		
		
		
		public function imprimirPerfil($id_tecnico_item)
		{
				
			$tecnico_item = $this -> tecnico_item -> getTecnicoItems(array('id_tecnico_item' => $id_tecnico_item));
			$diagnosticos = $this -> diagnostico_model -> getDiagnosticos(array('id_tecnico_item' => $id_tecnico_item));
			$reparaciones = $this -> reparacion_model -> getReparaciones(array('id_tecnico_item' => $id_tecnico_item));
			$items_cambiados = $this -> item_cambiado_model -> getItemsCambiados(array('id_tecnico_item' => $id_tecnico_item));			
			$id_item = $tecnico_item->id_item;
		
			$item = $this->item_model->getItems(array('id_item'=>$id_item));
		
			//$detalle_items = $this->detalle_item_model->getDetalleItems(array('id_item'=>$id_item));
			$accesorios = $this->accesorio_model->getAccesorios(array('id_tecnico_item'=>$id_tecnico_item));
			
			//colores de fondo
			$red = 247;
			$grey = 246;
			$black = 246;
			//inicializa pagina pdf	
			$this->fpdf->Open();
			
			$this->fpdf->SetTitle('Recepcion',true);

			$this->fpdf->AddPage('','Letter');

			$path_image = base_url().'assets/images/logo.gif';

			$this->fpdf->Image($path_image,10,6,40);
			
			$this->fpdf->SetFont('Arial','B',15);
		    // Title
		   	$this->fpdf->Cell(0,10,'NOTA DE RECEPCION',0,0,'C');

		    // Line break
		    $this->fpdf->Ln(10);

			$this->fpdf->SetFont('Arial','B',6);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,5,'NUMERO',1,0,'C',true);
			$this->fpdf->Cell(25,5,'FECHA DE INGRESO',1,0,'C',true);
			if($tecnico_item ->fecha_egreso != '0000-00-00'){
				$this->fpdf->Cell(25,5,'FECHA DE SALIDA',1,0,'C');	
			}
			
			
			$this->fpdf->Ln();
			$this->fpdf->SetFont('Arial','',6);
			$this->fpdf->Cell(25,5,$tecnico_item ->id_tecnico_item,1,0,'C');
			$this->fpdf->Cell(25,5,$tecnico_item ->fecha_ingreso,1,0,'C');
			if($tecnico_item ->fecha_egreso != '0000-00-00'){
			$this->fpdf->Cell(25,5,$tecnico_item ->fecha_egreso,1,0,'C');
			}
			$this->fpdf->Ln(10);
			
			
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Cliente: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$item ->nombre_contacto.' '.$item ->apellido_paterno_contacto.' '.$item ->apellido_materno_contacto,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Direccion: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$item ->direccion_contacto,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Telefono: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(50,10,$item ->telefono_contacto,1);
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Movil: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$item ->movil_contacto,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Equipo: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$tecnico_item ->nombre_item,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Serie: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(50,10,$item ->serie,1);
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Garantia: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(15,10,$item ->garantia,1);
		
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(25,10,'Estado: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			($tecnico_item->estado==0)? $estado = "Recepcionado": $estado = "Entregado";
			
			if($tecnico_item->estado==0)
				{
					$estado = 'Recepcionado';
				}
				if($tecnico_item->estado==1)
				{
					$estado = 'Diagnostico realizado';
				}
				if($tecnico_item->estado==2)
				{
					$estado = 'Reparacion aceptada';
				}
				if($tecnico_item->estado==3)
				{
					$estado = 'Reparacion cancelada';
				}
				if($tecnico_item->estado==4)
				{
					$estado = 'En reparacion';
				}
				if($tecnico_item->estado==5)
				{
					$estado = 'Listo';
				}
				if($tecnico_item->estado==6)
				{
					$estado = 'Entregado';
				}
			$this->fpdf->Cell(0,10,$estado,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(70,10,'Falla Comunicada por el Cliente: ',1,0,'',true);
			$this->fpdf->Ln();
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->MultiCell(0,10,$tecnico_item ->problema_reportado,1);
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->SetFillColor($red,$grey,$black);
			$this->fpdf->Cell(70,10,'Personal que recepciono: ',1,0,'',true);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$tecnico_item ->nombre_tec_recepciono.' '.$tecnico_item ->apellido_paterno_tec_recepciono.' '.$tecnico_item ->apellido_materno_tec_recepciono,1);
			$this->fpdf->Ln();

			/*
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(40,10,'Fecha de Ingreso: ',1);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$tecnico_item ->fecha_ingreso,1);
			$this->fpdf->Ln();
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(40,10,'Fecha de salida: ',1);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(0,10,$tecnico_item ->fecha_egreso,1);
			$this->fpdf->Ln();
			*/
			$this->fpdf->Ln();	
			if(isset($accesorios) && is_array($accesorios) && count($accesorios)>0){
				foreach ($accesorios as $accesorio){
					
					
					$this->fpdf->SetFont('Arial','B',12);
					$this->fpdf->Cell(70,10,'Nombre del Accesorio: ',1);
					$this->fpdf->SetFont('Arial','',12);
					$this->fpdf->Cell(0,10,$accesorio->nombre_accesorio,1);
					$this->fpdf->Ln();
					
					$this->fpdf->SetFont('Arial','B',12);
					$this->fpdf->Cell(70,10,'Descripcion del accesorio: ',1);
					$this->fpdf->SetFont('Arial','',12);
					$this->fpdf->MultiCell(0,10,$accesorio->descripcion,1);
					$this->fpdf->Ln();

				}
			}
			
			if(isset($diagnosticos) && is_array($diagnosticos) && count($diagnosticos)>0){
			
				foreach ($diagnosticos as $diagnostico){
					
					$this->fpdf->SetFont('Arial','B',12);
					$this->fpdf->Cell(50,10,'Diagnostico: ',1);
					$this->fpdf->Ln();
					$this->fpdf->SetFont('Arial','',12);
					$this->fpdf->MultiCell(0,10,$diagnostico->problema_encontrado,1);
	
						
					$this->fpdf->SetFont('Arial','B',12);
					$this->fpdf->Cell(50,10,'Tipo de problema: ',1);
					$this->fpdf->SetFont('Arial','',12);
					$this->fpdf->MultiCell(0,10,$diagnostico->tipo_problema,1);
					$this->fpdf->Ln();
				}
			}
			/*
			else{
			Actualmente no hay un diagnostico.
			}
			*/
			if(isset($reparaciones) && is_array($reparaciones) && count($reparaciones)>0){
			
				foreach ($reparaciones as $reparacion){
						
					$this->fpdf->SetFont('Arial','B',12);
					$this->fpdf->Cell(50,10,'Solucion aplicada: ',1);
					$this->fpdf->Ln();
					$this->fpdf->SetFont('Arial','',12);
					$this->fpdf->MultiCell(0,10,$reparacion->solucion,1);
					$this->fpdf->Ln();
				}
			}
		
			if(isset($items_cambiados) && is_array($items_cambiados) && count($items_cambiados)>0){
			
				foreach ($items_cambiados as $item_cambiado){
						
					$this->fpdf->SetFont('Arial','B',12);
					$this->fpdf->Cell(50,10,'Pieza cambiada: ',1);
					$this->fpdf->Ln();
					$this->fpdf->SetFont('Arial','',12);
					$this->fpdf->MultiCell(0,10,$item_cambiado->nombre_item_cambiado,1);
					$this->fpdf->Ln();
				}
			}
			
			
			//$this->fpdf->SetFont('Arial','B',12);
			//$this->fpdf->Cell(70,10,'Clausulas ',1);
			//$this->fpdf->Ln();
			//$this->fpdf->SetFont('Arial','',10);
			//$this->fpdf->MultiCell(0,10,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,',1);
			//$this->fpdf->Ln();
			
			
			/* if the signed is required 
			$this->fpdf->Cell(30,5,'',0);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(50,5,'....................... ',0,0,'C');
			$this->fpdf->Cell(40,5,'',0,0);
			$this->fpdf->Cell(50,5,'....................... ',0,1,'C');
			
			$this->fpdf->Cell(30,5,'',0);
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(50,5,'Firma SRL',0,0,'C');
			$this->fpdf->Cell(40,5,'',0,0);
			$this->fpdf->Cell(50,5,'Firma Cliente ',0,1,'C');
			*/
			//finaliza y muestra en pantalla pdf

			$fecha = date("d_m_Y_H_i_s");
			$nombre_archivo= $item ->nombre_contacto.'_'.$item ->apellido_paterno_contacto.'_'.$item ->apellido_materno_contacto. '_'.$tecnico_item ->nombre_item.'_'.$fecha;
			$this->fpdf->Output($tecnico_item->id_tecnico_item,'I');

		}
	   
   }
   
?>