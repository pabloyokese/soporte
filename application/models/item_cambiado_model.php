<?php
class Item_cambiado_model extends CI_Model {

	public function getItemsCambiados($options = array()) {
		$this -> db -> select('	item_cambiado.id_item_cambiado,
							item_cambiado.nombre_item_cambiado,
							item_cambiado.detalle,
							item_cambiado.serie,
							item_cambiado.id_tecnico_item ');

		$this -> db -> from('item_cambiado');
		$this -> db -> join('tecnico_item', 'item_cambiado.id_tecnico_item = tecnico_item.id_tecnico_item');

		if (isset($options['id_tecnico_item']))
			$this -> db -> where('item_cambiado.id_tecnico_item', $options['id_tecnico_item']);
		
		if (isset($options['id_item_cambiado']))
			$this -> db -> where('item_cambiado.id_item_cambiado', $options['id_item_cambiado']);

		$query = $this -> db -> get();

		if (isset($options['id_item_cambiado']))
			return $query -> row(0);

		return $query -> result();

	}

	public function addItemCambiado($options = array()) {

		$this -> db -> insert('item_cambiado', $options);
		return $this -> db -> insert_id();
	}


	public function updateItemCambiado($options = array()) {
		if (isset($options['nombre_item_cambiado']))
			$this -> db -> set('nombre_item_cambiado', $options['nombre_item_cambiado']);

		if (isset($options['detalle']))
			$this -> db -> set('detalle', $options['detalle']);

		if (isset($options['serie']))
			$this -> db -> set('serie', $options['serie']);

		$this -> db -> where('id_item_cambiado', $options['id_item_cambiado']);

		$this -> db -> update('item_cambiado');

		return $this -> db -> affected_rows();
	}

	public function deleteItemCambiado($options = array()) {
		if (isset($options['id_item_cambiado']))
			$this -> db -> where('id_item_cambiado', $options['id_item_cambiado']);

		if (isset($options['id_tecnico_item']))
			$this -> db -> where('id_tecnico_item', $options['id_tecnico_item']);

		$this -> db -> delete('item_cambiado');

		return $this -> db -> affected_rows();
	}

}
?>