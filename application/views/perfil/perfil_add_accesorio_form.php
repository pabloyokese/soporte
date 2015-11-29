<h2>Adicionar Accesorio</h1>
<?php echo form_open('')?>
<fieldset>
	<legend><span></span>Datos de Accesorio</legend>
	
	<label>Nombre accesorio</label>
	<?php echo form_input('nombre_accesorio',set_value('nombre_accesorio'));?>
	<?php echo form_error('nombre_accesorio')?><br>
	
	<label>Descripcion</label>
	<?php echo form_textarea('descripcion',set_value('descripcion'));?>
	<?php echo form_error('descripcion')?><br>
	
	<label>Serie</label>
	<?php echo form_input('serie',set_value('serie'));?>
	<?php echo form_error('serie')?><br>
	
	<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>
	<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
</fieldset>
<?php echo form_close();?>


