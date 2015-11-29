<?php echo form_open('recepcion/add');?>

<fieldset>
<legend>Recepcionar un Producto</legend>

<table class='table'>
	<tr>
		<td>Fecha de Ingreso</td>
		<td><?php echo form_input('fecha_ingreso',set_value('fecha_ingreso',$fecha));?><?php echo form_error('fecha_ingreso');?></td>
	</tr>
	<tr>
		<td>Nombre cliente</td>
		<td>
			<select id="id_cliente" name="id_cliente" class="chzn-select" style="width:350px;" data-placeholder="Seleciona un Cliente..">
			</select>
			<?php echo form_error('id_cliente');?>
			<a class="btn" data-toggle="modal" href="#myModal" >Add</a>
			<div id="result"></div>
		</td>
	</tr>
	<tr>
		<td>Seleciona un Producto</td>
		<td><select id="id_item" name="id_item" class="chzn-select" style="width:350px;" data-placeholder="Seleciona un Producto..">
		</select>
		<a class="btn" data-toggle="modal" href="#myModal2" >Add</a>
		<?php echo form_error('id_item');?>
		<div id="result2"></div>
		</td>
	</tr>
	<tr>
		<td>Problema reportado</td>
		<td>
			<label>Problema reportado</label>
			<?php echo form_textarea('problema_reportado',set_value('problema_reportado'));?>
			<?php echo form_error('problema_reportado');?>
		</td>
	</tr>	
	<tr>
		<td><a class="btn btn-primary" href="<?php echo base_url();?>recepcion/index"><i class="icon-arrow-left icon-white"></i> Volver</a></td>
		<td><?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?></td>
	</tr>
</table>
</fieldset>

<?php echo form_close();?>

<?php $this->load->view('clientes/clientes_add_form_ajax');?>
<?php $this->load->view('items/items_add_form_ajax');?>





