<h2>Adicionar Detalle de Item</h1>
<?php echo form_open('detalles_item/add/'.$id_item)?>
<fieldset>
	<legend><span></span>Datos de Detalle de Item</legend>
	
	<label>Nombre detalle</label>
	<?php echo form_input('nombre_detalle',set_value('nombre_detalle'));?>
	<?php echo form_error('nombre_detalle')?><br>
	
	<label>Descripcion</label>
	<?php echo form_textarea('descripcion',set_value('descripcion'));?>
	<?php echo form_error('descripcion')?><br>
	
	<label>Serie</label>
	<?php echo form_input('serie',set_value('serie'));?>
	<?php echo form_error('serie')?><br>
	
	<?php echo form_hidden('id_item',set_value('id_item',$id_item));?><br>
	
	<a class="btn btn-primary" href="<?php echo base_url();?>detalles_item/index/"><i class="icon-arrow-left icon-white"></i> Volver</a>
	
	<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
</fieldset>
<?php echo form_close();?>


