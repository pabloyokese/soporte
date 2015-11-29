<h2>Modificar Pieza a cambiar</h1>
<?php echo form_open('perfil/editItemCambiado/'.$item_cambiado->id_item_cambiado)?>
<fieldset>
	<legend><span></span>Datos de pieza a cambiar</legend>
	
	<label>Nombre Pieza</label>
	<?php echo form_input('nombre_item_cambiado',set_value('nombre_item_cambiado',$item_cambiado->nombre_item_cambiado));?>
	<?php echo form_error('nombre_item_cambiado')?><br>
	
	<label>Detalle</label>
	<?php echo form_textarea('detalle',set_value('detalle',$item_cambiado->detalle));?>
	<?php echo form_error('detalle')?><br>
	
	<label>Serie</label>
	<?php echo form_input('serie',set_value('serie',$item_cambiado->serie));?>
	<?php echo form_error('serie')?><br>
	
	<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $item_cambiado->id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>
	<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
</fieldset>
<?php echo form_close();?>


