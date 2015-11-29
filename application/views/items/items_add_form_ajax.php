<div  class="modal hide fade" id="myModal2">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">
			×
		</button>
		<h3><h2>Adicionar Cliente</h2></h3>
	</div>
	<div class="modal-body">
		<p>
			<?php echo form_open('items/add', array('name' => 'items_add_form_ajax', 'id' => 'items_add_form_ajax', 'class' => 'cmxform'));?>

			<fieldset>
				<legend>
					Adicionar un Item
				</legend>
				<br>
				<label>Nombre cliente</label>
				<div id="nombre_cliente"></div>
				<br>
				<label>Nombre Item</label>
				<?php echo form_input(array('name' => 'nombre_item', 'id' => 'nombre_item', ' class' => 'required', 'title' => 'el campo es requerido.'), set_value('nombre_item'));?>
				<?php echo form_error('nombre_item');?>

				<label>Modelo</label>
				<?php echo form_input(array('name' => 'modelo', 'id' => 'modelo'), set_value('modelo'));?>
				<?php echo form_error('modelo');?>

				<label>Serie</label>
				<?php echo form_input(array('name' => 'serie', 'id' => 'serie'), set_value('serie'));?>
				<?php echo form_error('serie');?>
				
				<label>Garantia</label>
				<select name="garantia" id="garantia" class="required" title="El campo es requerido">
					<option value=""></option>
					<option value="si">Si</option>
					<option value="no">No</option>
				</select>
				<?php echo form_error('garantia');?>
				
			</fieldset>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input value="Agregar" type="submit" class="btn btn-primary"  />
	</div>
</div>
<?php echo form_close();?>

