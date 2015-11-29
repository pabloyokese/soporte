<?php 
/**
 * 
 */
class Detalle_item_model extends CI_Model {
	
	
	function getDetalleItems($options = array())
	{
	
	$this->db->select('*');
	$this->db->from('detalle_item');
	if(isset($options['id_item']))
		$this->db->where('id_item',$options['id_item']);
	if(isset($options['id_detalle_item']))
		$this->db->where('id_detalle_item',$options['id_detalle_item']);
	
	$query = $this->db->get();
	
	if(isset($options['id_detalle_item']))
			return $query->row(0);
	
	return $query->result();		
	}
	
	
	function addDetalleItem($options = array())
	{
		$this->db->insert('detalle_item',$options);
		
		return $this->db->insert_id();
	}
	
	function updateDetalleItem($options = array())
	{
		
		if(isset($options['id_detalle_item']))
			$this->db->set('id_detalle_item',$options['id_detalle_item']);
		
		if(isset($options['nombre_detalle']))
			$this->db->set('nombre_detalle',$options['nombre_detalle']);
		
		if(isset($options['descripcion']))
			$this->db->set('descripcion',$options['descripcion']);
		
		
		if(isset($options['serie']))
			$this->db->set('serie',$options['serie']);
		
		$this->db->where('id_detalle_item',$options['id_detalle_item']);
		
		$this->db->update('detalle_item');
		
		return $this->db->affected_rows();
		
	}
	function deleteDetalleItem($options)
	{
		$this->db->where('id_detalle_item',$options['id_detalle_item']);
		$this->db->delete('detalle_item');
		
		return $this->db->affected_rows();
	} 
	
	
	
}

?>