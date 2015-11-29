<h2>Adicionar Pieza a cambiar</h1>
<?php echo form_open('')?>
<fieldset>
	<legend><span></span>Datos de pieza a cambiar</legend>
	
	<label>Nombre Pieza</label>
	<?php echo form_input('nombre_item_cambiado',set_value('nombre_item_cambiado'));?>
	<?php echo form_error('nombre_item_cambiado')?><br>
	
	<label>Detalle</label>
	<?php echo form_textarea('detalle',set_value('detalle'));?>
	<?php echo form_error('detalle')?><br>
	
	<label>Serie</label>
	<?php echo form_input('serie',set_value('serie'));?>
	<?php echo form_error('serie')?><br>
	
	<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>
	<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
</fieldset>
<?php echo form_close();?>


