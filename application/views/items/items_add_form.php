<?php echo form_open('items/add',array('class'=>'form-horizontal'));?>

<fieldset>
<legend>Adicionar un Item</legend>
	<div class='control-group'>
		<label class='control-label'>Nombre Item</label>
		<div class='controls'>
			<?php echo form_input(array('name'=>'nombre_item'),set_value('nombre_item'));?>
			<p class='help-block'>
			<?php echo form_error('nombre_item');?>
			</p>
		</div>
	</div>
	<div class='control-group'>
		<label class='control-label'>Modelo</label>
		<div class='controls'>
			<?php echo form_input('modelo',set_value('modelo'));?>
			<p class='help-block'>
			<?php echo form_error('modelo');?>
			</p>
		</div>
	</div>

	<div class='control-group'>
		<label class='control-label'>Serie</label>
		<div class='controls'>
			<?php echo form_input('serie',set_value('serie'));?>
			<p class='help-block'>
			<?php echo form_error('serie');?>
			</p>
		</div>
	</div>

	<div class='control-group'>
		<label class='control-label'>Nombre Cliente</label>
		<div class='controls'>
			<select name="id_cliente" class="chzn-select" data-placeholder="Seleciona un nombre...">
			<option value=""></option>
			<?php foreach ($clientes as $cliente):?>					
			<option value="<?php echo $cliente->id_cliente;?>" ><?php echo $cliente->nombre_contacto ." ".$cliente->apellido_paterno_contacto." ".$cliente->apellido_materno_contacto;?></option>
			<?php endforeach;?>
			</select>
			<p class='help-block'>
			<?php echo form_error('id_cliente');?>
			</p>
		</div>	
	</div>

	<div class='control-group'>
		<label class='control-label'>Garantia</label>
		<div class='controls'>
			<select name="garantia">
				<option value=""></option>
				<option value="si">Si</option>
				<option value="no">No</option>
			</select>
			<p class='help-block'>
			<?php echo form_error('garantia');?>
			</p>
		</div>
	</div>

<div class='form-actions'>
	<a class="btn btn-primary" href="<?php echo base_url();?>items/index"><i class="icon-arrow-left icon-white"></i> Volver</a>
	<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>	
</div>
</fieldset>
<?php echo form_close();?>

