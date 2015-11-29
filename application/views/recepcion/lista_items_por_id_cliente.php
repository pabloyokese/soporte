<?php if (count($items)==0) :?>
	<option value=""></option>
<?php else:?>
	<option value=""></option>
	<?php foreach($items as $item):?>
		<option value="<?php echo $item->id_item;?>" >
			<?php echo $item->nombre_item;?>
			<?php //echo ($item->estado=='recepcionado')? $item->nombre_item.' ( Este Item ya esta recepcionado )':$item->nombre_item.' ( Disponible para ser recepcionado )';?>
		</option>
	<?php endforeach;?>
<?php endif;?>
<script>
	$("#id_item").trigger("liszt:updated");
</script>
