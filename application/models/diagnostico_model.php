<?php
    /**
     * 
     */
    class Diagnostico_model extends CI_Model {
        
        public function getDiagnosticos($options = array())
		{
			if(isset($options['id_diagnostico']))
			$this->db->where('id_diagnostico',$options['id_diagnostico']);
			
			if(isset($options['id_tecnico_item']))
			$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
			
			if(isset($options['problema_encontrado']))
			$this->db->where('problema_encontrado',$options['problema_encontrado']);
			
			if(isset($options['tipo_problema']))
			$this->db->where('tipo_problema',$options['tipo_problema']);
			
			$query = $this->db->get('diagnostico');
		
			if(isset($options['id_diagnostico']))
				return $query->row(0);
			
			//if(isset($options['id_tecnico_item']))
			//	return $query->row(0);
			
			return $query->result();
		}
		
		public function addDiagnostico($options = array())
		{
			$this->db->insert('diagnostico',$options);
			return $this->db->insert_id();
		}
		
		public function updateDiagnostico($options){
				
			if(isset($options['id_diagnostico']))
			$this->db->set('id_diagnostico',$options['id_diagnostico']);
			
			if(isset($options['problema_encontrado']))
				$this->db->set('problema_encontrado',$options['problema_encontrado']);
			
			if(isset($options['tipo_problema']))
				$this->db->set('tipo_problema',$options['tipo_problema']);
			
			$this->db->where('id_diagnostico',$options['id_diagnostico']);
			
			$this->db->update('diagnostico');
			
			return $this->db->affected_rows();
		}
		public function deleteDiagnostico($options)
		{
			if(isset($options['id_diagnostico']))
			$this->db->where('id_diagnostico',$options['id_diagnostico']);
			
			if(isset($options['id_tecnico_item']))
			$this->db->where('id_tecnico_item',$options['id_tecnico_item']);
			
			$this->db->delete('diagnostico');
		
			return $this->db->affected_rows();
		}
    }
    
?>