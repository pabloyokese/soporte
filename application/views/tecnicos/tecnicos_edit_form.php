<h2>Modificar Tecnicos</h2>

<?php echo form_open('tecnicos/edit/'.$tecnico_selected->id_tecnico);?>
<fieldset>

<label>Ci</label>
<?php echo form_input('ci',set_value('ci',$tecnico_selected->ci)); ?>
<?php echo form_error('ci');?>

<label>Nombre</label>
<?php echo form_input('nombre',set_value('nombre',$tecnico_selected->nombre)); ?>
<?php echo form_error('nombre');?>

<label>Apellido Paterno</label>
<?php echo form_input('apellido_paterno',set_value('apellido_paterno',$tecnico_selected->apellido_paterno)); ?>
<?php echo form_error('apellido_paterno');?>

<label>Apellido Materno</label>
<?php echo form_input('apellido_materno',set_value('apellido_materno',$tecnico_selected->apellido_materno)); ?>
<?php echo form_error('apellido_materno');?>

<label>Usuario</label>
<?php echo form_input('usuario',set_value('usuario',$tecnico_selected->usuario)); ?>
<?php echo form_error('usuario');?>

<label>Nuevo Password</label>
<?php echo form_password('password',set_value('password')); ?>
<?php echo form_error('password');?>

<label>Repite tu Nuevo Password</label>
<?php echo form_password('repeat_password',set_value('repeat_password')); ?>
<?php echo form_error('repeat_password');?>

<label>Email</label>
<?php echo form_input('email',set_value('email',$tecnico_selected->email)); ?>
<?php echo form_error('email');?>

<label>Telefono</label>
<?php echo form_input('telefono',set_value('telefono',$tecnico_selected->telefono)); ?>
<?php echo form_error('telefono');?>

<label>Movil</label>
<?php echo form_input('movil',set_value('movil',$tecnico_selected->movil)); ?>
<?php echo form_error('movil');?>

<label>Direccion</label>
<?php echo form_textarea('direccion',set_value('direccion',$tecnico_selected->direccion)); ?>
<?php echo form_error('direccion');?>
<br>
<a class="btn btn-primary" href="<?php echo base_url();?>tecnicos/index"><i class="icon-arrow-left icon-white"></i> Volver</a>
<?php echo form_submit(array('class'=> 'btn btn-primary'),'Guardar');?>

</fieldset>
<?php echo form_close();