<?php
/**
 * 
 */
class Cliente_model extends CI_model {
	
	public function getClientes($options = array())
	{
		if (isset($options['filter'])){
			if(isset($options['id_cliente']))
				$this->db->like('id_cliente',$options['id_cliente']);
			
			if(isset($options['nombre_contacto']))
				$this->db->like('nombre_contacto',$options['nombre_contacto'],'after');
			
			if(isset($options['apellido_paterno_contacto']))
				$this->db->like('apellido_paterno_contacto',$options['apellido_paterno_contacto'],'after');
			
			if(isset($options['apellido_materno_contacto']))
				$this->db->like('apellido_materno_contacto',$options['apellido_materno_contacto'],'after');
			
			if(isset($options['email_contacto']))
				$this->db->like('email_contacto',$options['email_contacto']);
			
			if(isset($options['telefono_contacto']))
				$this->db->like('telefono_contacto',$options['telefono_contacto']);
			
			if(isset($options['movil_contacto']))
				$this->db->like('movil_contacto',$options['movil_contacto']);
			
			if(isset($options['direccion_contacto']))
				$this->db->like('direccion_contacto',$options['direccion_contacto']);
			
			if(isset($options['nombre_empresa']))
				$this->db->like('nombre_empresa',$options['nombre_empresa']);
			
			if(isset($options['telefono_empresa']))
				$this->db->like('telefono_empresa',$options['telefono_empresa']);
			
			if(isset($options['movil_empresa']))
				$this->db->like('movil_empresa',$options['movil_empresa']);
			
			if(isset($options['direccion_empresa']))
				$this->db->like('direccion_empresa',$options['direccion_empresa']);
		}
		else{

			if(isset($options['id_cliente']))
				$this->db->where('id_cliente',$options['id_cliente']);
			
			if(isset($options['nombre_contacto']))
				$this->db->where('nombre_contacto',$options['nombre_contacto']);
			
			if(isset($options['apellido_paterno_contacto']))
				$this->db->where('apellido_paterno_contacto',$options['apellido_paterno_contacto']);
			
			if(isset($options['apellido_materno_contacto']))
				$this->db->where('apellido_materno_contacto',$options['apellido_materno_contacto']);
			
			if(isset($options['email_contacto']))
				$this->db->where('email_contacto',$options['email_contacto']);
			
			if(isset($options['telefono_contacto']))
				$this->db->where('telefono_contacto',$options['telefono_contacto']);
			
			if(isset($options['movil_contacto']))
				$this->db->where('movil_contacto',$options['movil_contacto']);
			
			if(isset($options['direccion_contacto']))
				$this->db->where('direccion_contacto',$options['direccion_contacto']);
			
			if(isset($options['nombre_empresa']))
				$this->db->where('nombre_empresa',$options['nombre_empresa']);
			
			if(isset($options['telefono_empresa']))
				$this->db->where('telefono_empresa',$options['telefono_empresa']);
			
			if(isset($options['movil_empresa']))
				$this->db->where('movil_empresa',$options['movil_empresa']);
			
			if(isset($options['direccion_empresa']))
				$this->db->where('direccion_empresa',$options['direccion_empresa']);
		}
			//limit /offset
		
		if(isset($options['limit']) && isset($options['offset']))
			$this->db->limit($options['limit'],$options['offset']);
		else if (isset($options['limit']))
			$this->db->limit($options['limit']);
		
		// sort
		
		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'],$options['sortDirection']);
		
		
		$query = $this->db->get('cliente');
		
		if(isset($options['count'])) return $query->num_rows();
		
		if(isset($options['id_cliente']))
			return $query->row(0);
		
		return $query->result();
		
	}
	
	public function addCliente($options = array())
	{
		$this->db->insert('cliente',$options);
		
		return $this->db->insert_id();
	}

	public function updateCliente($options = array())
	{
		if(isset($options['id_cliente']))
			$this->db->set('id_cliente',$options['id_cliente']);
		
		if(isset($options['nombre_contacto']))
			$this->db->set('nombre_contacto',$options['nombre_contacto']);
		
		if(isset($options['apellido_paterno_contacto']))
			$this->db->set('apellido_paterno_contacto',$options['apellido_paterno_contacto']);
		
		if(isset($options['apellido_materno_contacto']))
			$this->db->set('apellido_materno_contacto',$options['apellido_materno_contacto']);
		
		if(isset($options['email_contacto']))
			$this->db->set('email_contacto',$options['email_contacto']);
		
		if(isset($options['telefono_contacto']))
			$this->db->set('telefono_contacto',$options['telefono_contacto']);
		
		if(isset($options['movil_contacto']))
			$this->db->set('movil_contacto',$options['movil_contacto']);
		
		if(isset($options['direccion_contacto']))
			$this->db->set('direccion_contacto',$options['direccion_contacto']);
		
		if(isset($options['nombre_empresa']))
			$this->db->set('nombre_empresa',$options['nombre_empresa']);
		
		if(isset($options['telefono_empresa']))
			$this->db->set('telefono_empresa',$options['telefono_empresa']);
		
		if(isset($options['movil_empresa']))
			$this->db->set('movil_empresa',$options['movil_empresa']);
		
		if(isset($options['direccion_empresa']))
			$this->db->set('direccion_empresa',$options['direccion_empresa']);
		
		$this->db->where('id_cliente',$options['id_cliente']);
		
		$this->db->update('cliente');
		
		return $this->db->affected_rows();
		
	}
	function deleteCliente($options = array())
	{
		$this->db->where('id_cliente',$options['id_cliente']);
		$this->db->delete('cliente');
		
		return $this->db->affected_rows();
	}


}

?>