<?php
/**
 *
 */
class Reportes extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (!$this -> tecnico_model -> secure()) {
			$this -> session -> set_flashdata('flashError', '<div class="alert alert-error" >
														<button class="close" data-dismiss="alert">
															×
														</button>Debes estar Logueado con un usuario valido para acceder a esta seccion.</div>');
			redirect('login');
		}

		$this -> load -> library('fpdf');
		define('FPDF_FONTPATH', BASEPATH . 'application/libraries/font/');
	}

	public function index() {
		$data['tecnico'] = $this -> tecnico_model -> getTecnicos(array('id_tecnico' => $this -> session -> userdata('id_tecnico')));
		$data['contenido'] = "reportes/reportes_index";
		$this -> load -> view('templates/plantilla_main', $data);
	}

	public function listaRecepciones() {
		//inicializa pagina pdf
		$this -> fpdf -> Open();
		$this -> fpdf -> AddPage();
		//dibuja rectangulo
		$this -> fpdf -> Rect(20, 10, 180, 137, 'D');
		$this -> fpdf -> SetFont('Arial', 'B', 16);
		$clientes = $this -> cliente_model -> getClientes(array());
		foreach ($clientes as $cliente) {
			$this -> fpdf -> Cell(40, 10, $cliente -> nombre_contacto);
		}

		//finaliza y muestra en pantalla pdf
		$this -> fpdf -> Output();
	}

	public function listaClientes($id_cliente = null) {
				
		//inicializa pagina pdf
		$this -> fpdf -> Open();
		$this -> fpdf -> AddPage();
		
		if (isset($id_cliente)) {
			$this->fpdf->SetFont('Arial','B',20);
			// Title
			$this->fpdf->Cell(0,10,'PERFIL',0,0,'L');
			$this->fpdf->Ln();
			$this->fpdf->Cell(0,10,'DE CLIENTE',0,0,'L');
			// Line break
			$this->fpdf->Ln(20);
			$cliente = $this -> cliente_model -> getClientes(array('id_cliente'=>$id_cliente));
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Nombre de cliente: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(0, 10, $cliente -> nombre_contacto .' '. $cliente -> apellido_paterno_contacto .' '. $cliente -> apellido_materno_contacto, 1);
				
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Email: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(0, 10, $cliente -> email_contacto , 1);
				
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Telefono: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> Cell(50, 10, $cliente -> telefono_contacto , 1);
		
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Movil: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(50, 10, $cliente -> movil_contacto , 1);
				
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Direccion: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(0, 10, $cliente -> direccion_contacto , 1);
				$this -> fpdf -> Ln();
			
			
		}
		else{
			$this->fpdf->SetFont('Arial','B',20);
			// Title
			$this->fpdf->Cell(0,10,'LISTA',0,0,'L');
			$this->fpdf->Ln();
			$this->fpdf->Cell(0,10,'DE CLIENTES',0,0,'L');
			// Line break
			$this->fpdf->Ln(20);
			$clientes = $this -> cliente_model -> getClientes(array());
			foreach ($clientes as $cliente) {
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Nombre de cliente: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(0, 10, $cliente -> nombre_contacto .' '. $cliente -> apellido_paterno_contacto .' '. $cliente -> apellido_materno_contacto, 1);
				
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Email: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(0, 10, $cliente -> email_contacto , 1);
				
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Telefono: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> Cell(50, 10, $cliente -> telefono_contacto , 1);
		
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Movil: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(50, 10, $cliente -> movil_contacto , 1);
				
				$this -> fpdf -> SetFont('Arial', 'B', 12);
				$this -> fpdf -> Cell(45, 10, 'Direccion: ', 1,0);
				$this -> fpdf -> SetFont('Arial', '', 12);
				$this -> fpdf -> MultiCell(0, 10, $cliente -> direccion_contacto , 1);
				$this -> fpdf -> Ln();
			
			}
		}

		//finaliza y muestra en pantalla pdf
		$this -> fpdf -> Output();
	}

}
?>