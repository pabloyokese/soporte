<h2>Agregar Diagnostico </h2>
<?php echo form_open('');?>
<label>Diagnostico</label>
<?php echo form_textarea('problema_encontrado',set_value('problema_encontrado'))?>
<?php echo form_error('problema_encontrado')?>
<br>
<label>Tipo de Problema</label>
	<select name="tipo_problema" class="chzn-select" data-placeholder="Seleciona un tipo de problema...">
		<option value="" ></option>
		<option value="hardware" >Hardware</option>
		<option value="software">Software</option>
		<option value="software&hardware" >Sofware y Hardware</option>
	</select>
	<?php echo form_error('tipo_problema');?>
<br>
<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>
<?php echo form_submit(array('class' => 'btn btn-primary'),'Guardar');?>
<?php echo form_close();?>

