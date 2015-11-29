<div class="row">
	<div class="span4">&nbsp;</div>
	<div class="span4">
		<?php if ($this->session->flashdata('flashError')):
		?>
		<div class="flashError">
			<?php echo $this -> session -> flashdata('flashError');?>
		</div>
		<?php endif;?>
		<h2>Login </h2>
		<?php echo form_open(base_url() . 'login', array('class' => 'well'));?>
		
		<label>Usuario: </label>
		<?php echo form_input('usuario', set_value('usuario'));?><br>
		<?php echo form_error('usuario')?>
		
		<label>Password: </label>
		<?php echo form_password('password');?><br>
		<?php echo form_error('password');?>
		
		<?php echo form_submit(array('class' => 'btn btn-primary'), 'Entrar');?>
		<?php echo form_close();?>
	</div>
	<div class="span4"></div>
</div>
