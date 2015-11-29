<h2>Adicionar Cliente</h1>

<?php echo form_open('clientes/add',array('class'=>'form-horizontal'))?>
<div class="row-fluid">

	<div class="span6">
		<fieldset>
			<legend><span></span>Datos de Contacto</legend>

			<div class='control-group'>
				<label class='control-label'>Nombre</label>
				<div class='controls'>
				<?php echo form_input('nombre_contacto',set_value('nombre_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('nombre_contacto')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Apellido Paterno</label>
				<div class='controls'>
				<?php echo form_input('apellido_paterno_contacto',set_value('apellido_paterno_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('apellido_paterno_contacto')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Apellido Materno</label>
				<div class='controls'>
				<?php echo form_input('apellido_materno_contacto',set_value('apellido_paterno_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('apellido_paterno_contacto')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Email</label>
				<div class='controls'>
				<?php echo form_input('email_contacto',set_value('email_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('email_contacto')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Telefono</label>
				<div class='controls'>
				<?php echo form_input('telefono_contacto',set_value('telefono_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('telefono_contacto')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Movil</label>
				<div class='controls'>
				<?php echo form_input('movil_contacto',set_value('movil_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('movil_contacto')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Direccion</label>
				<div class='controls'>
				<?php echo form_input('direccion_contacto',set_value('direccion_contacto'));?>
				<p class='help-block'>
				<?php echo form_error('direccion_contacto')?>
				</p>
				</div>
			</div>
			
		</fieldset>
	</div>

	<div class="span6">
	<fieldset>
		<legend><span></span>Datos de Empresa</legend>
			<div class='control-group'>
				<label class='control-label'>Nombre</label>
				<div class='controls'>
				<?php echo form_input('nombre_empresa',set_value('nombre_empresa'));?>
				<p class='help-block'>
				<?php echo form_error('nombre_empresa')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Telefono</label>
				<div class='controls'>
				<?php echo form_input('telefono_empresa',set_value('telefono_empresa'));?>
				<p class='help-block'>
				<?php echo form_error('telefono_empresa')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Movil</label>
				<div class='controls'>
				<?php echo form_input('movil_empresa',set_value('movil_empresa'));?>
				<p class='help-block'>
				<?php echo form_error('movil_empresa')?>
				</p>
				</div>
			</div>

			<div class='control-group'>
				<label class='control-label'>Direccion</label>
				<div class='controls'>
				<?php echo form_input('direccion_empresa',set_value('direccion_empresa'));?>
				<p class='help-block'>
				<?php echo form_error('direccion_empresa')?>
				</p>
				</div>
			</div>

	</fieldset>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class='form-actions'>
		<a class="btn btn-primary" href="<?php echo base_url();?>clientes/index"><i class="icon-arrow-left icon-white"></i> Volver</a>
		<?php echo form_submit(array('class' => 'btn btn-primary '),'Guardar');?>
		</div>
	</div>
</div>
<?php echo form_close();?>
