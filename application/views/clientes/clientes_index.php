<h2>Lista de Clientes</h2>
 
<p>
<a class="btn btn-primary" href="<?php echo base_url();?>clientes/add"><i class="icon-plus icon-white"></i> Add </a>
<a class="btn btn-primary"target="_blank" href="<?php echo base_url();?>clientes/imprimir"><i class="icon-print icon-white"></i> Print </a>
<a class="btn btn-primary" href="<?php echo base_url();?>panel"><i class="icon-arrow-left icon-white"></i> Volver</a>
</p>
<p>
<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
<h3>Filtrar la Lista </h3>
<?php echo form_open('clientes/index')?>
	<?php 
		$nombre_contacto = ($this->input->post('nombre_contacto')) ? $_POST['nombre_contacto'] : '' ;
		$apellido_paterno_contacto = ($this->input->post('apellido_paterno_contacto')) ? $_POST['apellido_paterno_contacto'] : '' ;
		$apellido_materno_contacto = ($this->input->post('apellido_materno_contacto')) ? $_POST['apellido_materno_contacto'] : '' ;
	?>
	<table>
		<tr>
			<td>Nombre</td>
			<td><?php echo form_input('nombre_contacto',set_value('nombre_contacto',$nombre_contacto)); ?></td>
		</tr>
		<tr>
			<td>Apellido Paterno</td>
			<td><?php echo form_input('apellido_paterno_contacto',set_value('apellido_paterno_contacto',$apellido_paterno_contacto)); ?></td>
		</tr>
		<tr>
			<td>Apellido Materno</td>
			<td><?php echo form_input('apellido_materno_contacto',set_value('apellido_materno_contacto',$apellido_materno_contacto)); ?></td>
		</tr>
	</table>

	<br><?php echo form_submit(array('class'=>"btn"),'Filtrar');?> 
	<a href="<?php echo base_url().'clientes/index'; ?>" class='btn'>Reiniciar Filtro</a>
<?php echo form_close();?>
</div>
</p>
<p>
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
		<th>Nombre</th>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Email</th>
		<th>Telefono</th>
		<th>Movil</th>
		<th>Direccion</th>
		<th>Nombre Empresa</th>
		<th>Telefono Empresa</th>
		<th>Movil Empresa</th>
		<th>Direccion Empresa</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	
	<tbody>
	<?php if(isset($clientes) && is_array($clientes) && count($clientes)>0):?>
		
		<?php foreach ($clientes as $cliente):?>
		<tr>
		<td><?php echo $cliente->id_cliente;?></td>
		<td><?php echo $cliente->nombre_contacto;?></td>
		<td><?php echo $cliente->apellido_paterno_contacto;?></td>
		<td><?php echo $cliente->apellido_materno_contacto;?></td>
		<td><?php echo $cliente->email_contacto;?></td>
		<td><?php echo $cliente->telefono_contacto;?></td>
		<td><?php echo $cliente->movil_contacto;?></td>
		<td><?php echo $cliente->direccion_contacto;?></td>
		<td><?php echo $cliente->nombre_empresa;?></td>
		<td><?php echo $cliente->telefono_empresa;?></td>
		<td><?php echo $cliente->movil_empresa;?></td>
		<td><?php echo $cliente->direccion_empresa;?></td>
		<td><a class="btn btn-mini" href="<?php echo base_url();?>clientes/edit/<?php echo $cliente->id_cliente; ?>"><i class="icon-pencil"></i> Edit</a></td>
		<td><a class="btn btn-mini" id="borrar_cliente" href="#" onclick="confirmarEliminarCliente(<?php echo $cliente->id_cliente; ?>)"><i class="icon-trash"></i> Delete</a></td>
	</tr>
		<?php endforeach;?>
		<?php else:?>
	<tr>
		<td colspan="3">Actualmente no hay clientes.</td>
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