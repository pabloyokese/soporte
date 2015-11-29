<div class="row">
  <div class="span8">

    <img src="<?php echo base_url();?>assets/images/logo.gif">

  </div>
  <div class="span4 well">
  	<h3>Estadisticas</h3>
  	<p>
  		<b>Total Clientes registrados:</b> <?php echo $num_clientes; ?>
  	</p>
  	
  	<p>
  		<b>Total de Equipos registrados:</b> <?php echo $num_items; ?>
  	</p>
  	
  	<p>
  		<b>Cantidad de Equipos recepcionados:</b> <?php echo $num_items_recepcionados; ?>
  	</p>
  	<p>
  		<b>Cantidad de Equipos recepcionados el dia de hoy:</b> <?php echo $num_recepciones_today; ?>
  	</p>
  	
  	<p>
  		<b>Cantidad de Equipos recepcionados el dia de Ayer:</b> <?php echo $num_recepciones_yesterday; ?>
  	</p>
  	
  	<p>
  		<b>Cantidad de Equipos salidas el dia de Hoy:</b> <?php echo $num_salidas_hoy; ?>
  	</p>
  	
  	<p>
  		<b>Cantidad de Equipos Listos:</b> <?php echo $num_equipos_listos; ?>
  	</p>
  </div>
</div>
