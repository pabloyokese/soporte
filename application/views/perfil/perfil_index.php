<h2>Perfil recepción</h2>
<p>
	<a class="btn btn-primary" href="<?php echo base_url();?>recepcion"><i class="icon-arrow-left icon-white"></i> Volver</a>
	<a class="btn btn-primary"target="_blank" href="<?php echo base_url();?>perfil/imprimirPerfil/<?php echo $tecnico_item -> id_tecnico_item;?>"><i class="icon-print icon-white"></i> Print </a>
</p>

<table>
	<tr>
		<td><b>Id de recepción:</b></td>
		<td><?php echo $tecnico_item -> id_tecnico_item;?></td>
	</tr>
	<tr>
		<td><b>Nombre del Equipo:</b></td>
		<td><?php echo $tecnico_item -> nombre_item;?></td>
	</tr>
	<tr>
		<td><b>Cliente:</b></td>
		<td><?php echo $item -> nombre_contacto . ' ' . $item -> apellido_paterno_contacto . ' ' . $item -> apellido_materno_contacto;?></td>
	</tr>
	<tr>
		<td><b>Estado:</b></td>
		<td>
		<?php
		/* 
		if($tecnico_item->estado == 0){
			echo "Recepcionado";
		}
		if($tecnico_item->estado == 1){
			echo "Diagnostico realizado";
		}
		if($tecnico_item->estado == 2){
			echo "Reparacion Aceptada";
		}
		if($tecnico_item->estado == 3){
			echo "Reparacion Cancelada";
		}
		if($tecnico_item->estado == 4){
			echo "En reparacion";
		} 
		if($tecnico_item->estado == 5){
			echo "Listo";
		}
		if($tecnico_item->estado == 6){
			echo "Entregado";
		} 
		*/
		?>
		<input type='hidden' id='id_tecnico_item' value='<?php echo $tecnico_item->id_tecnico_item; ?>' />
		<!-- esto es nuevo -->
		<select name="estado" id="estado" >			
		<?php if($tecnico_item -> estado == '0'):?>
			<option value="0" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Recepcionado</option>	
		<?php endif;?>
		<?php if($tecnico_item -> estado == '1'):?>
			<option value="1" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Diagnostico realizado</option>
			<option value="2">Reparacion Aceptada</option>
			<option value="3">Reparacion Cancelada</option>
		<?php endif;?>
		<?php if($tecnico_item -> estado == '2'):?>
			<option value="2" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Reparacion Aceptada</option>
			<option value="4">En reparacion</option>
		<?php endif;?>
		<?php if($tecnico_item -> estado == '3'):?>
			<option value="3" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Reparacion Cancelada</option>
			<option value="6">Entregado</option>
		<?php endif;?>
		<?php if($tecnico_item -> estado == '4'):?>
			<option value="4" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >En reparacion</option>
			<option value="5">Listo</option>
		<?php endif;?>
		<?php if($tecnico_item -> estado == '5'):?>
			<option value="5" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Listo</option>
			<option value="6">Entregado</option>
		<?php endif;?>
		<?php if($tecnico_item -> estado == '6'):?>
			<option value="6" <?php echo set_select('tipo_problema', $tecnico_item -> estado, TRUE); ?> >Entregado</option>
		<?php endif;?>
		</select>
		<div id="result"></div>
		<!--comentarios de nuevo -->
		</td>
	</tr>
	<tr>
		<td><b>Garantia:</b></td>
		<td><?php echo $item -> garantia;?></td>
	</tr>
	<tr>
		<td><b>Fecha de Ingreso:</b></td>
		<td><?php echo $tecnico_item -> fecha_ingreso;?></td>
	</tr>
	<tr>
		<td><b>Fecha de Salida:</b></td>
		<td><?php echo $tecnico_item -> fecha_egreso;?></td>
	</tr>
	<tr>
		<td><b>Fecha de Inicio de reparación:</b></td>
		<td><?php echo $tecnico_item -> fecha_inicio_reparacion;?></td>
	</tr>
	<tr>
		<td><b>Fecha de Fin de reparación:</b></td>
		<td><?php echo $tecnico_item -> fecha_fin_reparacion;?></td>
	</tr>
	<tr>
		<td><b>Tecnico Encargado:</b></td>
		<td><?php echo $tecnico_item -> nombre_tec_recepciono .' '.$tecnico_item -> apellido_paterno_tec_recepciono .' '.$tecnico_item -> apellido_materno_tec_recepciono;?></td>
	</tr>
</table>

<p>
	<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
	<h4><b>Falla comunicada: </b></h4>
	<table class='table table-bordered '>
		<tr>
			<td><?php echo $tecnico_item -> problema_reportado;?></td>
		</tr>
	</table>
	</div>
</p>

<p>
	<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
		<h4>Accesorios</h4>
		<table class='table table-bordered table-striped'>
			<tr>
				<th>Id</th>
				<th>Nombre Accesorio</th>
				<th>Descripcion</th>
				<th></th>
				<th></th>
			</tr>
			<?php if(isset($accesorios) && is_array($accesorios) && count($accesorios)>0):
			?>
			<?php foreach ($accesorios as $accesorio):
			?>
			<tr>
				<td><?php echo $accesorio -> id_accesorio;?></td>
				<td><?php echo $accesorio -> nombre_accesorio;?></td>
				<td><?php echo $accesorio -> descripcion;?></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/editAccesorio/<?php echo $accesorio -> id_accesorio;?>"> <i class="icon-pencil"></i> Edit</a></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/deleteAccesorio/<?php echo $accesorio -> id_accesorio;?>"> <i class="icon-trash"></i> Delete</a></td>
			</tr>
			<?php endforeach;?>
			<?php else:?>
			<tr>
				<td colspan="5">Actualmente este item no tiene accesorios.</td>
			</tr>
			<?php endif;?>
		</table>
		<a class="btn btn-primary " href="<?php echo base_url();?>perfil/addAccesorio/<?php echo $tecnico_item -> id_tecnico_item;?>"><i class="icon-plus icon-white"></i> Add</a>
	</div>
</p>
<?php if ($this->session->flashdata('flashErrorAccesorio')):
?>
<div class="flashError">
	<?php echo $this -> session -> flashdata('flashErrorAccesorio');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirmAccesorio')):
?>
<div class="flashConfirm">
	<?php echo $this -> session -> flashdata('flashConfirmAccesorio');?>
</div>
<?php endif;?>

<p>
	<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
		<h4>Diagnostico</h4>
		<table class='table table-bordered table-striped'>
			<tr>
				<th>Id</th>
				<th>Descripcion del Problema</th>
				<th>Tipo de Diagnostico</th>
				<th></th>
				<th></th>
			</tr>
			<?php if(isset($diagnosticos) && is_array($diagnosticos) && count($diagnosticos)>0):
			?>

			<?php foreach ($diagnosticos as $diagnostico):
			?>
			<tr>
				<td><?php echo $diagnostico -> id_diagnostico;?></td>
				<td><?php echo $diagnostico -> problema_encontrado;?></td>
				<td><?php echo $diagnostico -> tipo_problema;?></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/editDiagnostico/<?php echo $diagnostico -> id_diagnostico;?>"><i class="icon-pencil"></i> Edit</a></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/deleteDiagnostico/<?php echo $diagnostico -> id_diagnostico;?>"><i class="icon-trash"></i> Delete</a></td>
			</tr>
			<?php endforeach;?>
			<?php else:?>
			<tr>
				<td colspan="5">Actualmente no hay un diagnostico.</td>
			</tr>
			<?php endif;?>
		</table>
		<a class="btn btn-primary " name="diagnostico" href="<?php echo base_url();?>perfil/addDiagnostico/<?php echo $tecnico_item -> id_tecnico_item;?>"><i class="icon-plus icon-white"></i> Add</a>
	</div>
</p>
<?php if ($this->session->flashdata('flashErrorDiagnostico')):
?>
<div class="flashError">
	<?php echo $this -> session -> flashdata('flashErrorDiagnostico');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirmDiagnostico')):
?>
<div class="flashConfirm">
	<?php echo $this -> session -> flashdata('flashConfirmDiagnostico');?>
</div>
<?php endif;?>

<p>
	<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
		<h4>Solución</h4>
		<table class='table table-bordered table-striped' >
			<tr>
				<th>Id</th>
				<th>Solución</th>
				<th></th>
				<th></th>
			</tr>
			<?php if(isset($reparaciones) && is_array($reparaciones) && count($reparaciones)>0):
			?>

			<?php foreach ($reparaciones as $reparacion):
			?>
			<tr>
				<td><?php echo $reparacion -> id_reparacion;?></td>
				<td><?php echo $reparacion -> solucion;?></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/editReparacion/<?php echo $reparacion -> id_reparacion;?>"><i class="icon-pencil"></i> Edit</a></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/deleteReparacion/<?php echo $reparacion -> id_reparacion;?>"><i class="icon-trash"></i> Delete</a></td>
			</tr>
			<?php endforeach;?>
			<?php else:?>
			<tr>
				<td colspan="4">Actualmente no hay una Solucion.</td>
			</tr>
			<?php endif;?>
		</table>
		<a class="btn btn-primary" href="<?php echo base_url();?>perfil/addReparacion/<?php echo $tecnico_item -> id_tecnico_item;?>"><i class="icon-plus icon-white"></i> Add</a>
	</div>
</p>
<?php if ($this->session->flashdata('flashErrorReparacion')):
?>
<div class="flashError">
	<?php echo $this -> session -> flashdata('flashErrorReparacion');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirmReparacion')):
?>
<div class="flashConfirm">
	<?php echo $this -> session -> flashdata('flashConfirmReparacion');?>
</div>
<?php endif;?>

<p >
	<div style="border: 1px solid #DDD; padding: 10px; border-radius:10px ">
		<h4>Piezas cambiadas</h4>
		<table class='table table-bordered table-striped' >
			<tr>
				<th>Id</th>
				<th>Pieza</th>
				<th></th>
				<th></th>
			</tr>
			<?php if(isset($items_cambiados) && is_array($items_cambiados) && count($items_cambiados)>0):
			?>

			<?php foreach ($items_cambiados as $item_cambiado):
			?>
			<tr>
				<td><?php echo $item_cambiado -> id_item_cambiado;?></td>
				<td><?php echo $item_cambiado -> nombre_item_cambiado;?></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/editItemCambiado/<?php echo $item_cambiado -> id_item_cambiado;?>"><i class="icon-pencil"></i> Edit</a></td>
				<td><a class="btn btn-mini" href="<?php echo base_url();?>perfil/deleteItemCambiado/<?php echo $item_cambiado -> id_item_cambiado;?>"><i class="icon-trash"></i> Delete</a></td>
			</tr>
			<?php endforeach;?>
			<?php else:?>
			<tr>
				<td colspan="4">Actualmente no hay ninguna pieza cambiada.</td>
			</tr>
			<?php endif;?>
		</table>
		<a class="btn btn-primary" href="<?php echo base_url();?>perfil/addItemCambiado/<?php echo $tecnico_item -> id_tecnico_item;?>"><i class="icon-plus icon-white"></i> Add</a>
	</div>
</p>
<?php if ($this->session->flashdata('flashErrorItemCambiado')):
?>
<div class="flashError">
	<?php echo $this -> session -> flashdata('flashErrorItemCambiado');?>
</div>
<?php endif;?>

<?php if ($this->session->flashdata('flashConfirmItemCambiado')):
?>
<div class="flashConfirm">
	<?php echo $this -> session -> flashdata('flashConfirmItemCambiado');?>
</div>
<?php endif;?>