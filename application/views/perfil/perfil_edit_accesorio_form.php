<h2>Modificar Detalle de Item</h1>
<?php echo form_open('perfil/editAccesorio/'.$accesorios->id_accesorio);?>
<fieldset>
	<legend><span></span>Datos Accesorio</legend>
	
	<label>Nombre detalle</label>
	<?php echo form_input('nombre_accesorio',set_value('nombre_accesorio',$accesorios->nombre_accesorio));?>
	<?php echo form_error('nombre_accesorio')?><br>
	
	<label>Descripcion</label>
	<?php echo form_textarea('descripcion',set_value('descripcion',$accesorios->descripcion));?>
	<?php echo form_error('descripcion')?><br>
	
	<label>Serie</label>
	<?php echo form_input('serie',set_value('serie',$accesorios->serie));?>
	<?php echo form_error('serie')?><br>
	

	
<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $accesorios->id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>	
	<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
</fieldset>
<?php echo form_close();?>


