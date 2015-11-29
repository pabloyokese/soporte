<?php
class Accesorio_model extends CI_Model {

	public function getAccesorios($options = array()) {
		$this -> db -> select('	accesorio.id_accesorio,
							accesorio.nombre_accesorio,
							accesorio.descripcion,
							accesorio.descripcion,
							accesorio.serie,
							accesorio.id_tecnico_item ');

		$this -> db -> from('accesorio');
		$this -> db -> join('tecnico_item', 'accesorio.id_tecnico_item = tecnico_item.id_tecnico_item');

		if (isset($options['id_tecnico_item']))
			$this -> db -> where('accesorio.id_tecnico_item', $options['id_tecnico_item']);
		
		if (isset($options['id_accesorio']))
			$this -> db -> where('accesorio.id_accesorio', $options['id_accesorio']);

		$query = $this -> db -> get();

		if (isset($options['id_accesorio']))
			return $query -> row(0);

		return $query -> result();

	}

	public function addAccesorio($options = array()) {

		$this -> db -> insert('accesorio', $options);
		return $this -> db -> insert_id();
	}

	public function updateAccesorio($options = array()) {
		if (isset($options['nombre_accesorio']))
			$this -> db -> set('nombre_accesorio', $options['nombre_accesorio']);

		if (isset($options['descripcion']))
			$this -> db -> set('descripcion', $options['descripcion']);

		if (isset($options['serie']))
			$this -> db -> set('serie', $options['serie']);

		$this -> db -> where('id_accesorio', $options['id_accesorio']);

		$this -> db -> update('accesorio');

		return $this -> db -> affected_rows();
	}

	public function deleteAccesorio($options = array()) {
		if (isset($options['id_accesorio']))
			$this -> db -> where('id_accesorio', $options['id_accesorio']);

		if (isset($options['id_tecnico_item']))
			$this -> db -> where('id_tecnico_item', $options['id_tecnico_item']);

		$this -> db -> delete('accesorio');

		return $this -> db -> affected_rows();
	}

}
?>