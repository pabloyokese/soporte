<h2>Editar Diagnostico </h2>
<?php echo form_open('perfil/editDiagnostico/'.$diagnosticos->id_diagnostico);?>
<label>Diagnostico</label>
<?php echo form_textarea('problema_encontrado',set_value('problema_encontrado',$diagnosticos->problema_encontrado))?>
<?php echo form_error('problema_encontrado')?>
<br>

	<label>Tipo de Problema</label>
	<select name="tipo_problema" class="chzn-select" data-placeholder="Seleciona un tipo de problema...">
	<option value=""></option>					
	<?php if($diagnosticos -> tipo_problema == 'hardware'):?>
		<option value="hardware" <?php echo set_select('tipo_problema', $diagnosticos -> tipo_problema, TRUE); ?> >Hardware</option>
		<option value="software">Software</option>
		<option value="software&hardware" >Sofware y Hardware</option>
	<?php endif;?>
	<?php if($diagnosticos -> tipo_problema == 'software'):?>
		<option value="hardware"  >Hardware</option>
		<option value="software" <?php echo set_select('tipo_problema', $diagnosticos -> tipo_problema, TRUE); ?> >Software</option>
		<option value="software&hardware" >Sofware y Hardware</option>
	<?php endif;?>
	<?php if($diagnosticos -> tipo_problema == 'software&hardware'):?>
		<option value="hardware"  >Hardware</option>
		<option value="software"  >Software</option>
		<option value="software&hardware" <?php echo set_select('tipo_problema', $diagnosticos -> tipo_problema, TRUE); ?> >Sofware y Hardware</option>
	<?php endif;?>	
	</select>
	<?php echo form_error('tipo_problema');?>
<br>
<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $diagnosticos->id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>	
<?php echo form_submit(array('class' => 'btn btn-primary'),'Guardar');?>
<?php echo form_close();?>

