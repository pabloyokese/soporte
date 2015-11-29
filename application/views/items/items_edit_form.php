<?php echo form_open('items/edit/'.$items->id_item);?>
<fieldset>
<legend>Modificar Item</legend>

	<label>Nombre Item</label><?php echo form_input('nombre_item',set_value('nombre_item',$items->nombre_item));?><?php echo form_error('nombre_item')?><br>
	
	<label>Modelo</label><?php echo form_input('modelo',set_value('modelo',$items->modelo));?>
	<?php echo form_error('modelo')?><br>
	
	<label>Serie</label><?php echo form_input('serie',set_value('serie',$items->serie));?>
	<?php echo form_error('serie')?><br>
	
	<label>Nombre Cliente</label>
	<select name="id_cliente" class="chzn-select" data-placeholder="Seleciona un nombre...">
	<option value=""></option>
	<?php foreach ($clientes as $cliente):?>					
	<?php if($cliente->id_cliente==$items->id_cliente):?>
		<option value="<?php echo $cliente->id_cliente;?>" <?php echo set_select('id_cliente', $cliente->id_cliente, TRUE); ?> ><?php echo $cliente->nombre_contacto ." ".$cliente->apellido_paterno_contacto." ".$cliente->apellido_materno_contacto;?></option>
	<?php else:?>
		<option value="<?php echo $cliente->id_cliente;?>" <?php echo set_select('id_cliente', $cliente->id_cliente, FALSE); ?> ><?php echo $cliente->nombre_contacto ." ".$cliente->apellido_paterno_contacto." ".$cliente->apellido_materno_contacto;?></option>
	<?php endif;?>	
	<?php endforeach;?>
	</select>
	<?php echo form_error('id_cliente')?>
	
	<label>Garantia</label>
	<select name="garantia">
		<?php if($items->garantia=='si'):?>
		<option>Si</option>
		<option>No</option>
		<?php endif;?>
		<?php if($items->garantia=='no'):?>
		<option>No</option>
		<option>Si</option>
		<?php endif;?>
	</select>

</fieldset>

<a class="btn btn-primary" href="<?php echo base_url();?>items/index"><i class="icon-arrow-left icon-white"></i> Volver</a>
<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
<?php echo form_close();?>
