<?php
class Tecnico_model extends CI_Model {
	
	function getTecnicos($options = array()){
		// para filtrar
		if (isset($options['filter'])){
			
			if (isset($options['id_tecnico']))
				$this->db->like('id_tecnico',$options['id_tecnico']);
		
			if (isset($options['ci']))
				$this->db->like('ci',$options['ci'],'after');
			
			if (isset($options['nombre']))
				$this->db->like('nombre',$options['nombre']);
			
			if (isset($options['apellido_paterno']))
				$this->db->like('apellido_paterno',$options['apellido_paterno']);
			
			if (isset($options['apellido_materno']))
				$this->db->like('apellido_materno',$options['apellido_materno']);
			
			if (isset($options['usuario']))
				$this->db->like('usuario',$options['usuario']);
			
			if (isset($options['password']))
				$this->db->like('password',md5($options['password']));
			
			if (isset($options['email']))
				$this->db->like('email',$options['email']);
			
			if (isset($options['telefono']))
				$this->db->like('telefono',$options['telefono']);
			
			if (isset($options['movil']))
				$this->db->like('movil',$options['movil']);
			
			if (isset($options['direccion']))
				$this->db->like('direccion',$options['direccion']);
		}
		else{//en caso de que no se filtren los datos	
		// Qualification
		if (isset($options['id_tecnico']))
			$this->db->where('id_tecnico',$options['id_tecnico']);
		
		if (isset($options['ci']))
			$this->db->where('ci',$options['ci']);
		
		if (isset($options['nombre']))
			$this->db->where('nombre',$options['nombre']);
		
		if (isset($options['apellido_paterno']))
			$this->db->where('apellido_paterno',$options['apellido_paterno']);
		
		if (isset($options['apellido_materno']))
			$this->db->where('apellido_materno',$options['apellido_materno']);
		
		if (isset($options['usuario']))
			$this->db->where('usuario',$options['usuario']);
		
		if (isset($options['password']))
			$this->db->where('password',md5($options['password']));
		
		if (isset($options['email']))
			$this->db->where('email',$options['email']);
		
		if (isset($options['telefono']))
			$this->db->where('telefono',$options['telefono']);
		
		if (isset($options['movil']))
			$this->db->where('movil',$options['movil']);
		
		if (isset($options['direccion']))
			$this->db->where('direccion',$options['direccion']);
		}
		$query = $this->db->get('tecnico');
		
		if (isset($options['usuario']) || isset($options['password']))
			return $query->row(0);
		
		if (isset($options['id_tecnico']))
			return $query->row(0);
		
		return $query->result();			
	}
	
	public function login($options = array()){
		$tecnico = $this->getTecnicos(array('usuario'=>$options['usuario'],'password'=>$options['password']));
		if (!$tecnico)return false;
		$this->session->set_userdata('id_tecnico',$tecnico->id_tecnico);
		return true;
	}
	
	public function secure(){
		if($this->session->userdata('id_tecnico'))return true;
		return false;
		
	}
	
	function addTecnico($options = array()) {
		$this->db->insert ( 'tecnico', $options );
		return $this->db->insert_id ();
	}

	function updateTecnico($options = array()) {
		
		if(isset($options['ci']))
			$this->db->set('ci',$options['ci']);
		
		if(isset($options['nombre']))
			$this->db->set('nombre',$options['nombre']);
		
		if(isset($options['apellido_paterno']))
			$this->db->set('apellido_paterno',$options['apellido_paterno']);
		
		if(isset($options['apellido_materno']))
			$this->db->set('apellido_materno',$options['apellido_materno']);
		
		if(isset($options['usuario']))
			$this->db->set('usuario',$options['usuario']);
		
		if(isset($options['password']))
			$this->db->set('password',md5($options['password']));
		
		if(isset($options['email']))
			$this->db->set('email',$options['email']);

		if(isset($options['telefono']))
			$this->db->set('telefono',$options['telefono']);

		if(isset($options['movil']))
			$this->db->set('movil',$options['movil']);

		if(isset($options['direccion']))
			$this->db->set('direccion',$options['direccion']);

		$this->db->where('id_tecnico',$options['id_tecnico']);
	
		$this->db->update('tecnico');
		
		return $this->db->affected_rows();
		
	}
	public function delete($options = array()){
		
		$this->db->where('id_tecnico',$options['id_tecnico']);
		$this->db->delete('tecnico');

		return $this->db->affected_rows();
	}

}