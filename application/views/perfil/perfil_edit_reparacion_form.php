<h2>Editar Reparacion </h2>
<?php echo form_open('perfil/editReparacion/'.$reparaciones->id_reparacion);?>
<label>Diagnostico</label>
<?php echo form_textarea('solucion',set_value('solucion',$reparaciones->solucion))?>
<?php echo form_error('solucion')?>
<br>
<a class="btn btn-primary" href="<?php echo base_url();?>perfil/index/<?php echo $reparaciones->id_tecnico_item;?>"><i class="icon-arrow-left icon-white"></i> Volver</a>
<?php echo form_submit(array('class' => 'btn btn-primary'),'Guardar');?>
<?php echo form_close();?>