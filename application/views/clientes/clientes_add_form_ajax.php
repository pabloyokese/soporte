<div  class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">
			×
		</button>
		<h3><h2>Adicionar Cliente</h2></h3>
	</div>
	<div class="modal-body">
		<p>
			
		<?php echo form_open('clientes/add',array('name'=>'add_clientes_ajax','id'=>'add_clientes_ajax','class'=>'cmxform'))?>
		<div class="row-fluid">
		
		<div class="span6">	
		<fieldset>
			<legend><span></span>Datos de Contacto</legend>
			
			<table>
				<tr>
					<td><label>Nombre</label></td>
					<td><?php echo form_input(array('name'=>'nombre_contacto','id'=>'nombre_contacto',' class'=>'required','title'=>'el campo es requerido.'),set_value('nombre_contacto'));?><?php echo form_error('nombre_contacto')?><br></td>
				</tr>
				<tr>
					<td><label>Apellido Paterno</label></td>
					<td><?php echo form_input(array('name'=>'apellido_paterno_contacto','id'=>'apellido_paterno_contacto',' class'=>'required','title'=>'el campo es requerido.'),set_value('apellido_paterno_contacto'));?><?php echo form_error('apellido_paterno_contacto')?><br></td>
				</tr>
				<tr>
					<td><label>Apellido Materno</label></td>
					<td><?php echo form_input(array('name'=>'apellido_materno_contacto','id'=>'apellido_materno_contacto',' class'=>'required','title'=>'el campo es requerido.'),set_value('apellido_paterno_contacto'));?><?php echo form_error('apellido_paterno_contacto')?><br></td>
				</tr>
				<tr>
					<td><label>Email</label></td>
					<td><?php echo form_input(array('name'=>'email_contacto','id'=>'email_contacto'),set_value('email_contacto'));?><?php echo form_error('email_contacto')?><br></td>
				</tr>
				<tr>
					<td><label>Telefono</label></td>
					<td><?php echo form_input(array('name'=>'telefono_contacto','id'=>'telefono_contacto'),set_value('telefono_contacto'));?><?php echo form_error('telefono_contacto')?><br></td>
				</tr>
				<tr>
					<td><label>Movil</label></td>
					<td><?php echo form_input(array('name'=>'movil_contacto','id'=>'movil_contacto',' class'=>'required','title'=>'el campo es requerido.'),set_value('movil_contacto'));?><?php echo form_error('movil_contacto')?><br></td>
				</tr>
				<tr>
					<td><label>Direccion</label></td>
					<td><?php echo form_input(array('name'=>'direccion_contacto','id'=>'direccion_contacto'),set_value('direccion_contacto'));?><?php echo form_error('direccion_contacto')?><br></td>
				</tr>
			</table>
		<input name="ajax" value="1" type="hidden" />
		</fieldset>
		</div>
		
			
		<div class="span6">
		<fieldset>
			<legend><span></span>Datos de Empresa</legend>
			<label>Nombre</label><?php echo form_input('nombre_empresa',set_value('nombre_empresa'));?><?php echo form_error('nombre_empresa')?><br>
			<label>Telefono</label><?php echo form_input('telefono_empresa',set_value('telefono_empresa'));?><?php echo form_error('telefono_empresa')?><br>
			<label>Movil</label><?php echo form_input('movil_empresa',set_value('movil_empresa'));?><?php echo form_error('movil_empresa')?><br>
			<label>Direccion</label><?php echo form_input('direccion_empresa',set_value('direccion_empresa'));?><?php echo form_error('direccion_empresa')?><br>
			
		</fieldset>
		</div>
		</div>
		
		
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input value="Agregar" type="submit" class="btn btn-primary"  />
	</div>
	
	</div>
<?php echo form_close();?>

