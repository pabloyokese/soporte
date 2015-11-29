<?php echo form_open('recepcion/edit/'.$tecnico_item->id_tecnico_item);?>
<fieldset>
<legend>Modificar Recepción</legend>
<table class='table'>
	<tr>
		<td>Fecha de Ingreso</td>
		<td><?php echo form_input('fecha_ingreso',set_value('fecha_ingreso',$tecnico_item->fecha_ingreso));?>
			<?php echo form_error('fecha_ingreso');?>
		</td>
	</tr>
	<tr>
		<td>Estado</td>
		<td>
			<select name="estado" class="chzn-select" data-placeholder="Seleciona un tipo de estado...">
			<option value=""></option>					
			<?php if($tecnico_item -> estado == '0'):?>
				<option value="0" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Recepcionado</option>	
			<?php endif;?>
			<?php if($tecnico_item -> estado == '1'):?>
				<option value="1" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Diagnostico realizado</option>
				<option value="2">Reparacion Aceptada</option>
				<option value="3">Reparacion Cancelada</option>
			<?php endif;?>
			<?php if($tecnico_item -> estado == '2'):?>
				<option value="2" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Reparacion Aceptada</option>
				<option value="4">En reparacion</option>
			<?php endif;?>
			<?php if($tecnico_item -> estado == '3'):?>
				<option value="3" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Reparacion Cancelada</option>
				<option value="6">Entregado</option>
			<?php endif;?>
			<?php if($tecnico_item -> estado == '4'):?>
				<option value="4" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >En reparacion</option>
				<option value="5">Listo</option>
			<?php endif;?>
			<?php if($tecnico_item -> estado == '5'):?>
				<option value="5" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Listo</option>
				<option value="6">Entregado</option>
			<?php endif;?>
			<?php if($tecnico_item -> estado == '6'):?>
				<option value="6" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Entregado</option>
			<?php endif;?>
			</select>
			<?php echo form_error('estado');?>
		</td>
	</tr>
	<tr>
		<td>Problema reportado</td>
		<td>
			<?php echo form_textarea(array('name'=>'problema_reportado','rows'=>'10'),set_value('problema_reportado',$tecnico_item->problema_reportado));?>
			<?php echo form_error('problema_reportado');?>
		</td>
	</tr>

</table>

<?php
/*
	<label>Nombre Item</label>
	<select name="id_item" class="chzn-select" data-placeholder="Seleciona un nombre...">
	<option value=""></option>
	<?php foreach ($items as $item):?>					
	<?php if($item->id_item == $tecnico_item->id_item):?>
		<option value="<?php echo $item->id_item;?>" <?php echo set_select('id_item', $item->id_item, TRUE); ?> ><?php echo $item->nombre_item;?></option>
	<?php else:?>
		<option value="<?php echo $item->id_item;?>" <?php echo set_select('id_item', $item->id_item, FALSE); ?> ><?php echo $item->nombre_item;?></option>
	<?php endif;?>	
	<?php endforeach;?>
	</select>
	<?php echo form_error('id_item');?> 
 * 
 */
?>
	
</fieldset>
<a class="btn btn-primary" href="<?php echo base_url();?>recepcion/index"><i class="icon-arrow-left icon-white"></i> Volver</a>
<?php echo form_submit(array('class' => 'btn btn-primary'),'Enviar');?>
<?php echo form_close();?>
