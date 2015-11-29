<table class='table table-bordered table-striped'>
	<tr>
		<th>Id</th>
		<th>Nombre Producto</th>
		<th>Modelo</th>
		<th>Serie</th>
		<th>Estado</th>
		<th>Nombre cliente</th>
		<th>Garantia</th>
		<th>Ver Detalle</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	
	<?php if(isset($items) && is_array($items) && count($items)>0):?>
		
		<?php foreach ($items as $item):?>
		<tr>
		<td><?php echo $item->id_item;?></td>
		<td><?php echo $item->nombre_item;?></td>
		<td><?php echo $item->modelo;?></td>
		<td><?php echo $item->serie;?></td>
		<td><?php echo ($item->estado=='recepcionado')? "<a class='btn btn-success btn-mini'>Recepcionado</a>":"<a class='btn btn-warning btn-mini'>No recepcionado</a>";?></td>
		<td><?php echo $item->nombre_contacto.' '.$item->apellido_paterno_contacto.' '.$item->apellido_materno_contacto;?></td>
		<td><?php echo $item->garantia; ?></td>
		<td><a class="btn btn-mini" href="<?php echo base_url();?>detalles_item/index/<?php echo $item->id_item; ?>"><i class="icon-eye-open"></i> Detalle</a></td>

		<td><a class="btn btn-mini" href="<?php echo base_url();?>items/edit/<?php echo $item->id_item; ?>"><i class="icon-pencil"></i> Edit</a></td>
		<td><a class="btn btn-mini" onclick="confirmarEliminarItem(<?php echo $item->id_item; ?>)" href="#"><i class="icon-trash"></i> Delete</a></td>
	</tr>
		<?php endforeach;?>
		<?php else:?>
	<tr>
		<td colspan="8">Actualmente no hay Items.</td>
	</tr>
		<?php endif;?>
	</table>	