<?php if (count($clientes)==0) :?>
	<option value=""></option>
<?php else:?>
		<option value=""></option>
	<?php foreach ($clientes as $cliente):?>					
	<option value="<?php echo $cliente->id_cliente?>" >
		<?php echo $cliente->nombre_contacto. ' ' .$cliente->apellido_paterno_contacto. ' '.$cliente->apellido_materno_contacto ;?></option>
	<?php endforeach;?>
<?php endif;?>
<script>
	$("#id_cliente").trigger("liszt:updated");
</script>
