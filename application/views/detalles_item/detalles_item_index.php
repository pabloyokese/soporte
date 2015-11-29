<h2>Detalles </h2>
<p>
	<b>Nombre Item: </b><?php echo $item->nombre_item;?> <br>
	<b>Modelo: </b><?php echo $item->modelo;?> <br>
	<b>Serie: </b><?php echo $item->serie;?> <br>
	<b>Pertecenece a: </b><?php echo $item->nombre_contacto.' '.$item->apellido_paterno_contacto.' '.$item->apellido_materno_contacto;?> <br>
</p>


<p>
<a class="btn btn-primary" href="<?php echo base_url();?>detalles_item/add/<?php echo $id_item; ?>"><i class="icon-plus icon-white"></i> Add</a>
<a class="btn btn-primary" href="<?php echo base_url();?>items/index"><i class="icon-arrow-left icon-white"></i> Volver</a>
</p>

<?php if ($this->session->flashdata('flashError')):?>
<div class="flashError">
	<?php echo $this->session->flashdata('flashError');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirm')):?>
<div class="flashConfirm">
	<?php echo $this->session->flashdata('flashConfirm');?>
</div>
<?php endif;?>


<table class='table table-bordered table-striped'>
	
	<tr>
		<th>Id</th>
		<th>Nombre</th>
		<th>Descripcion</th>
		<th>Serie</th>
		<th></th>
		<th></th>
	</tr>
	
	<?php if(isset($detalle_items) && is_array($detalle_items) && count($detalle_items)>0):?>
		
		<?php foreach ($detalle_items as $detalle_item):?>
		<tr>
		<td><?php echo $detalle_item->id_detalle_item;?></td>
		<td><?php echo $detalle_item->nombre_detalle;?></td>
		<td><?php echo $detalle_item->descripcion;?></td>
		<td><?php echo $detalle_item->serie;?></td>

		<td><a class="btn btn-success btn-mini"  href="<?php echo base_url();?>detalles_item/edit/<?php echo $detalle_item->id_item.'/'.$detalle_item->id_detalle_item; ?>"><i class="icon-pencil icon-white"></i> Edit</a></td>
		<td><a class="btn btn-success btn-mini" onclick="confirmarEliminarDetalleItem(<?php echo $detalle_item->id_item;?>,<?php echo $detalle_item->id_detalle_item;?>)"  href="#"><i class="icon-trash icon-white"></i> Delete</a></td>
	</tr>
		<?php endforeach;?>
		<?php else:?>
	<tr>
		<td colspan="6">Este producto no tiene detalles.</td>
	</tr>
		<?php endif;?>
	</table>	



