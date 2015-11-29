<h2>Lista de Tecnicos</h2>
 
<p>
<a class="btn btn-primary" href="<?php echo base_url();?>tecnicos/add"><i class="icon-plus icon-white"></i> Add </a>
<a class="btn btn-primary"target="_blank" href="<?php echo base_url();?>tecnicos/imprimir"><i class="icon-print icon-white"></i> Print </a>
<a class="btn btn-primary" href="<?php echo base_url();?>panel"><i class="icon-arrow-left icon-white"></i> Volver</a>
</p>
<p>
<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
<h3>Filtrar la Lista </h3>
<?php echo form_open('tecnicos/index')?>
	<?php 
		$ci = ($this->input->post('ci')) ? $_POST['ci'] : '' ;
		$nombre = ($this->input->post('nombre')) ? $_POST['nombre'] : '' ;
		$apellido_paterno = ($this->input->post('apellido_paterno')) ? $_POST['apellido_paterno'] : '' ;
		$apellido_materno = ($this->input->post('apellido_materno')) ? $_POST['apellido_materno'] : '' ;
	?>
	<table>
		<tr>
			<td>Ci</td>
			<td><?php echo form_input('ci',set_value('ci',$ci)); ?></td>
		</tr>
		<tr>
			<td>Nombre</td>
			<td><?php echo form_input('nombre',set_value('nombre',$nombre)); ?></td>
		</tr>
		<tr>
			<td>Apellido Paterno</td>
			<td><?php echo form_input('apellido_paterno',set_value('apellido_paterno',$apellido_paterno)); ?></td>
		</tr>
		<tr>
			<td>Apellido Materno</td>
			<td><?php echo form_input('apellido_materno',set_value('apellido_materno',$apellido_materno)); ?></td>
		</tr>
	</table>

	<br><?php echo form_submit(array('class'=>"btn"),'Filtrar');?> 
	<a href="<?php echo base_url().'tecnicos/index'; ?>" class='btn'>Reiniciar Filtro</a>
<?php echo form_close();?>
</div>
</p>
<p>
<?php if ($this->session->flashdata('flashError')):?>
<div class="flashError">
	Error! <?php echo $this->session->flashdata('flashError');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirm')):?>
<div class="flashConfirm">
	<?php echo $this->session->flashdata('flashConfirm');?>
</div>
<?php endif;?>
</p>

<table class='table table-bordered table-striped'>
	<tr>
		<th>Id</th>
		<th>Ci</th>
		<th>Nombre</th>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Email</th>
		<th>Movil</th>
		<th>Direccion</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	
	<tbody>
	<?php if(isset($tecnicos) && is_array($tecnicos) && count($tecnicos)>0):?>
		
		<?php foreach ($tecnicos as $tecnico):?>
		<tr>
		<td><?php echo $tecnico->id_tecnico;?></td>
		<td><?php echo $tecnico->ci;?></td>
		<td><?php echo $tecnico->nombre;?></td>
		<td><?php echo $tecnico->apellido_paterno;?></td>
		<td><?php echo $tecnico->apellido_materno;?></td>
		<td><?php echo $tecnico->email;?></td>
		<td><?php echo $tecnico->telefono;?></td>
		<td><?php echo $tecnico->direccion;?></td>
		<td><a class="btn btn-mini" href="<?php echo base_url();?>tecnicos/edit/<?php echo $tecnico->id_tecnico; ?>"><i class="icon-pencil"></i> Edit</a></td>
		<td><a class="btn btn-mini" id="borrar_cliente" href="#" onclick="confirmarEliminarTecnico(<?php echo $tecnico->id_tecnico; ?>)"><i class="icon-trash"></i> Delete</a></td>
	</tr>
		<?php endforeach;?>
		<?php else:?>
	<tr>
		<td colspan="10"><?php echo $mensaje = ($this->input->post()) ? 'No hay resultados filtrados, modifica tu busqueda.' : 'Actualmente no hay Tecnicos.' ;?></td>
	</tr>
	</tbody>
		<?php endif;?>
	</table>	
<p>
	<?php if(isset($pagination)):?>
		<div class="pagination">
			<?php echo $pagination;?>
		</div>
	<?php endif;?>
	</p>
