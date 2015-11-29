<?php 
/**
 * 
 */
class Item_model extends CI_Model {
	
	
	function getItems($options = array())
	{

	$this->db->select('	item.id_item,
						item.nombre_item,item.id_cliente,
						cliente.nombre_contacto ,
						item.modelo,
						item.serie,
						item.estado,
						item.garantia,
						cliente.direccion_contacto,
						cliente.telefono_contacto,
						cliente.movil_contacto,
						cliente.apellido_paterno_contacto,
						cliente.apellido_materno_contacto');
						
	$this->db->from('item');
	$this->db->join('cliente', 'item.id_cliente = cliente.id_cliente');
	
	if (isset($options['filter'])){
		if(isset($options['id_item']))
			$this->db->like('id_item',$options['id_item']);
		
		if(isset($options['nombre_item']))
			$this->db->like('nombre_item',$options['nombre_item']);

		if(isset($options['estado']))
			$this->db->like('estado',$options['estado'],'none');
		
		if(isset($options['garantia']))
			$this->db->like('garantia',$options['garantia'],'none');
		
		if(isset($options['id_cliente']))
			$this->db->like('cliente.id_cliente',$options['id_cliente'],'none');
	}
	else{
		if(isset($options['id_item']))
			$this->db->where('id_item',$options['id_item']);
		
		if(isset($options['estado']))
			$this->db->where('estado',$options['estado']);
		
		if(isset($options['id_cliente']))
			$this->db->where('cliente.id_cliente',$options['id_cliente']);
	}
	//limit /offset
		
	if(isset($options['limit']) && isset($options['offset']))
		$this->db->limit($options['limit'],$options['offset']);
	
	else if (isset($options['limit']))
		$this->db->limit($options['limit']);
		
	// sort
		
	if(isset($options['sortBy']) && isset($options['sortDirection']))
		$this->db->order_by($options['sortBy'],$options['sortDirection']);
		
	
	$query = $this->db->get();
	
	if(isset($options['count'])) return $query->num_rows();
	
	if(isset($options['id_item']))
		return $query->row(0);
	
	return $query->result();		
	}
	
	function addItem($options = array())
	{
		$this->db->insert('item',$options);
		
		return $this->db->insert_id();
	}
	
	function updateItem($options = array())
	{
		if(isset($options['id_item']))
			$this->db->set('id_item',$options['id_item']);
		
		if(isset($options['nombre_item']))
			$this->db->set('nombre_item',$options['nombre_item']);
		
		if(isset($options['modelo']))
			$this->db->set('modelo',$options['modelo']);
		
		if(isset($options['serie']))
			$this->db->set('serie',$options['serie']);
		
		if(isset($options['id_cliente']))
			$this->db->set('id_cliente',$options['id_cliente']);
		
		if(isset($options['estado']))
			$this->db->set('estado',$options['estado']);
		
		if(isset($options['garantia']))
			$this->db->set('garantia',$options['garantia']);
		
		$this->db->where('id_item',$options['id_item']);
		
		$this->db->update('item');
		
		return $this->db->affected_rows();
		
	}
	
	function deleteItem($options = null)
	{
		$this->db->where('id_item',$options['id_item']);
		$this->db->delete('item');
		
		return $this->db->affected_rows();		
	}
	
	
}

?>