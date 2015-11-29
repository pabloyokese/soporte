<?php
/**
 * 		Estados 
 * 		0 recepcionado
 *		
 *		1 diagnostico realizado
 *		
 *		2 reparacion aceptada	3 reparacion cancelada
 *		
 *		4 en reparacion
 *		
 *		5 Listo
 *		
 *		6 entregado
 */
class Tecnico_item extends CI_Model {
		
	//tabla para recpcionar un item
	function getTecnicoItems($options)
	{
		$this->db->select("	tecnico_item.id_tecnico_item,
							tecnico_item.fecha_ingreso,
							tecnico_item.fecha_inicio_reparacion,
							tecnico_item.fecha_fin_reparacion,
							tecnico_item.problema_reportado,
							tecnico_item.estado,
							tecnico_item.id_item,
							tecnico_item.id_tecnico,
							item.nombre_item,
							item.id_cliente,
							tecnico.nombre as nombre_tec_recepciono,
							tecnico.apellido_paterno as apellido_paterno_tec_recepciono,
							tecnico.apellido_materno as apellido_materno_tec_recepciono,
							tecnico3.nombre as nombre_tec_encargado,
							tecnico3.apellido_paterno as apellido_paterno_tec_encargado,
							tecnico3.apellido_materno as apellido_materno_tec_encargado");
		$this->db->from('tecnico_item');
		$this->db->join('item', 'item.id_item = tecnico_item.id_item');
		$this->db->join('tecnico as tecnico', 'tecnico.id_tecnico = tecnico_item.id_tecnico');
		$this->db->join('tecnico as tecnico3', 'tecnico3.id_tecnico = tecnico_item.id_tecnico_encargado','left');
		
		
		if (isset($options['filter'])){
			if(isset($options['id_tecnico_item']))
			$this->db->like('id_tecnico_item',$options['id_tecnico_item'],'none');
		
			if(isset($options['fecha_ingreso']))
				$this->db->like('fecha_ingreso',$options['fecha_ingreso'],'none');
				
			if(isset($options['fecha_egreso']))
				$this->db->like('fecha_egreso',$options['fecha_egreso']);

			if(isset($options['estado']))
				$this->db->like('tecnico_item.estado',$options['estado'],'none');

			if(isset($options['id_cliente']))
				$this->db->like('item.id_cliente',$options['id_cliente'],'none');

			if(isset($options['id_tecnico_encargado']))
				$this->db->like('tecnico_item.id_tecnico_encargado',$options['id_tecnico_encargado'],'none');
		}
		else{
			if(isset($options['id_tecnico_item']))
			$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
		
			if(isset($options['fecha_ingreso']))
				$this->db->where('fecha_ingreso',$options['fecha_ingreso']);
				
			if(isset($options['fecha_egreso']))
				$this->db->where('fecha_egreso',$options['fecha_egreso']);

			if(isset($options['estado']))
				$this->db->where('tecnico_item.estado',$options['estado']);
		}

		
		
		// sort
		
		if(isset($options['sortBy']) && isset($options['sortDirection']))
			$this->db->order_by($options['sortBy'],$options['sortDirection']);
		
		
		$query = $this->db->get();
		
		if(isset($options['count'])) return $query->num_rows();
		
		if(isset($options['id_tecnico_item']))
			return $query->row(0);
		
		return $query->result();	
		
	}
	
	
	function addTecnicoItem($options)
	{
		$this->db->insert('tecnico_item',$options);	
		
		return $this->db->insert_id();
		
	}
	
	function updateTecnicoItem($options)
	{
		if(isset($options['id_tecnico_item']))
			$this->db->set('id_tecnico_item',$options['id_tecnico_item']);
		
		if(isset($options['fecha_ingreso']))
			$this->db->set('fecha_ingreso',$options['fecha_ingreso']);
			
		if(isset($options['problema_reportado']))
			$this->db->set('problema_reportado',$options['problema_reportado']);
			
		if(isset($options['estado']))
			$this->db->set('estado',$options['estado']);
		
		if(isset($options['fecha_egreso']))
			$this->db->set('fecha_egreso',$options['fecha_egreso']);

		if(isset($options['fecha_inicio_reparacion']))
			$this->db->set('fecha_inicio_reparacion',$options['fecha_inicio_reparacion']);
			
		if(isset($options['fecha_fin_reparacion']))
			$this->db->set('fecha_fin_reparacion',$options['fecha_fin_reparacion']);			
	
		if(isset($options['id_tecnico_que_entrego']))
			$this->db->set('id_tecnico_que_entrego',$options['id_tecnico_que_entrego']);
		
		if(isset($options['id_item']))
			$this->db->set('id_item',$options['id_item']);
			
		if(isset($options['id_tecnico']))
			$this->db->set('id_tecnico',$options['id_tecnico']);
		
		$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
		
		$this->db->update('tecnico_item');
		
		return $this->db->affected_rows();
	}	
	
	function deleteTecnicoItem($options = null)
	{
		$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
		$this->db->delete('tecnico_item');
		
		return $this->db->affected_rows();
	}
	
}

?>