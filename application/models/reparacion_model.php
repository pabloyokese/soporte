<?php 
/**
 * 
 */
class Reparacion_model extends CI_Model {
	
	function getReparaciones($options)
	{
		if(isset($options['id_tecnico_item']))
			$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
		
		if(isset($options['id_reparacion']))
			$this->db->where('id_reparacion',$options['id_reparacion']);
		
		if(isset($options['solucion']))
			$this->db->where('solucion',$options['solucion']);	
		
		$query = $this->db->get('reparacion');
		
		if(isset($options['id_reparacion']))
			return $query->row(0);
			
		return $query->result();
		
	}
	
	public function addReparacion($options = array())
	{
		$this->db->insert('reparacion',$options);
		return $this->db->insert_id();
	}
	
	public function updateReparacion($options){
				
		if(isset($options['id_reparacion']))
		$this->db->set('id_reparacion',$options['id_reparacion']);
			
		if(isset($options['solucion']))
			$this->db->set('solucion',$options['solucion']);
			
		$this->db->where('id_reparacion',$options['id_reparacion']);
			
		$this->db->update('reparacion');
			
		return $this->db->affected_rows();
	}
	
	public function deleteReparacion($options)
	{
		if(isset($options['id_reparacion']))
			$this->db->where('id_reparacion',$options['id_reparacion']);
		
		if(isset($options['id_tecnico_item']))
			$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
		
		$this->db->delete('reparacion');
		
		return $this->db->affected_rows();
	}
	
}

?>