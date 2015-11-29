<h2>Lista de Items</h2>
<p>
<a class="btn btn-primary" href="<?php echo base_url();?>items/add"><i class="icon-plus icon-white"></i> Add</a>
<a class="btn btn-primary" target="_blank" href="<?php echo base_url();?>items/imprimir"><i class="icon-print icon-white"></i> Print</a>
<a class="btn btn-primary" href="<?php echo base_url();?>panel"><i class="icon-arrow-left icon-white"></i> Volver</a>
</p>
<?php if ($this->session->flashdata('flashError')):?>
<div class="flashError">
	<?php echo $this->session->flashdata('flashError');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirm')):?>
<div class="flashConfirm">
	<?php echo $this->session->flashdata('flashConfirm');?>
</div>
<?php endif;?>
<p>
	<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
		<h3>Filtrar por </h3>
		<?php echo form_open();?>
			<?php 
				$nombre_item = ($this->input->post('nombre_item')) ? $_POST['nombre_item'] : '' ;
				$id_cliente2 = ($this->input->post('id_cliente2')) ? $_POST['id_cliente2'] : '' ;
				$estado = ($this->input->post('estado')) ? $_POST['estado'] : '' ;
				$garantia = ($this->input->post('garantia')) ? $_POST['garantia'] : '' ;
			?>
			<table>
				<tr>
					<td>Nombre del Producto</td>	
					<td><?php echo form_input('nombre_item',set_value('nombre_item',$nombre_item));?></td>
				</tr>
				<tr>
					<td>Estado</td>	
					<td>
						<select class="chzn-select" name='estado' data-placeholder="Seleciona un estado..">
							<option value=''>Cualquiera</option>
							<?php if ($estado == '') :?>
								<option value="recepcionado"  >
								Recepcionado
								</option>
								<option value="norecepcionado" >
								No Recepcionado
								</option>
							<?php endif;?>
							<?php if ($estado == 'recepcionado') :?>
								<option value="recepcionado" <?php echo set_select('estado', 'Recepcionado', TRUE); ?> >
								Recepcionado
								</option>
								<option value="norecepcionado" >
								No Recepcionado
								</option>
							<?php endif;?>
							<?php if ($estado == 'norecepcionado') :?>
								<option value="norecepcionado" <?php echo set_select('estado', 'No Recepcionado', TRUE); ?> >
								No Recepcionado
								</option>
								<option value="recepcionado">
								Recepcionado
								</option>
							<?php endif;?>
						</select>	
					</td>
				</tr>
				<tr>
					<td>Garantia</td>	
					<td>
						<select class="chzn-select" name='garantia' data-placeholder="Seleciona un estado..">
							<option value=''>Cualquiera</option>
							<?php if ($garantia == '') :?>
								<option value="si"  >
								Si
								</option>
								<option value="no" >
								No
								</option>
							<?php endif;?>
							<?php if ($garantia == 'si') :?>
								<option value="si" <?php echo set_select('garantia', 'Si', TRUE); ?> >
								Si
								</option>
								<option value="no" >
								No
								</option>
							<?php endif;?>
							<?php if ($garantia == 'no') :?>
								<option value="no" <?php echo set_select('garantia', 'No', TRUE); ?> >
								No
								</option>
								<option value="si">
								Si
								</option>
							<?php endif;?>
						</select>	
					</td>
				</tr>
				<tr>
					<td>Seleciona un cliente</td>
					<td>
						<select name="id_cliente2" class="chzn-select" style="width:350px;" data-placeholder="Seleciona un Cliente.." >
							<option></option>
							<?php foreach ($clientes as $cliente):?>
								<?php if ($cliente->id_cliente == $id_cliente2) :?>
							<option value="<?php echo $cliente->id_cliente; ?>" <?php echo set_select('id_cliente2', $cliente->id_cliente, TRUE); ?> >
								<?php echo $cliente->nombre_contacto .' '. $cliente->apellido_paterno_contacto .' '.$cliente->apellido_materno_contacto;?>
							</option>
								<?php else:?>
							<option value="<?php echo $cliente->id_cliente; ?>" >
								<?php echo $cliente->nombre_contacto .' '. $cliente->apellido_paterno_contacto .' '.$cliente->apellido_materno_contacto;?>
							</option>
								<?php endif;?>
							<?php endforeach;?>
						</select>
					</td>
				</tr>
			</table>
			<?php echo form_submit(array('class'=>'btn'),'Filtrar');?>
			<a href="<?php echo base_url();?>items/index" class="btn">Mostrar todos</a>
		<?php echo form_close();?>
	</div>
</p>

<table class='table table-bordered table-striped'>
	<tr>
		<th>Id</th>
		<th>Nombre Producto</th>
		<th>Modelo</th>
		<th>Serie</th>
		<th>Estado</th>
		<th>Nombre cliente</th>
		<th>Garantia</th>
		<th>Ver Detalle</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	
	<?php if(isset($items) && is_array($items) && count($items)>0):?>
		
		<?php foreach ($items as $item):?>
		<tr>
		<td><?php echo $item->id_item;?></td>
		<td><?php echo $item->nombre_item;?></td>
		<td><?php echo $item->modelo;?></td>
		<td><?php echo $item->serie;?></td>
		<td><?php echo ($item->estado=='recepcionado')? "<a class='btn btn-success btn-mini'>Recepcionado</a>":"<a class='btn btn-warning btn-mini'>No recepcionado</a>";?></td>
		<td><?php echo $item->nombre_contacto.' '.$item->apellido_paterno_contacto.' '.$item->apellido_materno_contacto;?></td>
		<td><?php echo $item->garantia; ?></td>
		<td><a class="btn btn-mini" href="<?php echo base_url();?>detalles_item/index/<?php echo $item->id_item; ?>"><i class="icon-eye-open"></i> Detalle</a></td>

		<td><a class="btn btn-mini" href="<?php echo base_url();?>items/edit/<?php echo $item->id_item; ?>"><i class="icon-pencil"></i> Edit</a></td>
		<td><a class="btn btn-mini" onclick="confirmarEliminarItem(<?php echo $item->id_item; ?>)" href="#"><i class="icon-trash"></i> Delete</a></td>
	</tr>
		<?php endforeach;?>
		<?php else:?>
	<tr>
		<td colspan="8"><?php echo $mensaje = ($this->input->post()) ? 'No hay resultados filtrados, modifica tu busqueda.' : 'Actualmente no hay Items.' ;?></td>
	</tr>
		<?php endif;?>
	</table>



