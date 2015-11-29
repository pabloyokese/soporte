<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
			<a class="brand" href="#">Soporte Tecnico</a>
			<div class="btn-group pull-right" >
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <i class="icon-user"></i> <?php echo $tecnico->tipo;?> Conectado: <?php echo $tecnico -> nombre . ' ' . $tecnico -> apellido_paterno . ' ' . $tecnico -> apellido_materno;?>
				<span class="caret"></span> </a>
				<ul class="dropdown-menu">
					<li>
						<?php echo anchor('main/logout', 'logout');?>
					</li>
				</ul>
			</div>
			<div class="nav-collapse">
				<ul class="nav">
					<?php if ($tecnico->tipo == 'Administrador'):?>
						<li>
							<a href="<?php echo base_url();?>panel"> <i class="icon-home icon-white"></i> Home </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>clientes/index"> <i class="icon-user icon-white"></i> Clientes </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>tecnicos/index"> <i class="icon-user icon-white"></i> Tecnicos </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>items/index"> <i class="icon-cog icon-white"></i> Equipos </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>recepcion/index"> <i class="icon-wrench icon-white"></i> Recepción </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>reportes/index"> <i class="icon-wrench icon-white"></i> Reportes </a>
						</li>
					<?php endif ?>	
					<?php if ($tecnico->tipo == 'Tecnico'):?>
						<li>
						<a href="<?php echo base_url();?>panel"> <i class="icon-home icon-white"></i> Home </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>clientes/index"> <i class="icon-user icon-white"></i> Clientes </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>items/index"> <i class="icon-cog icon-white"></i> Equipos </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>recepcion/index"> <i class="icon-wrench icon-white"></i> Recepción </a>
						</li>
					<?php endif ?>
					<?php if ($tecnico->tipo == 'Recepcionista'):?>
						<li>
						<a href="<?php echo base_url();?>panel"> <i class="icon-home icon-white"></i> Home </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>clientes/index"> <i class="icon-user icon-white"></i> Clientes </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>items/index"> <i class="icon-cog icon-white"></i> Equipos </a>
						</li>
						<li>
							<a href="<?php echo base_url();?>recepcion/index"> <i class="icon-wrench icon-white"></i> Recepción </a>
						</li>
					<?php endif ?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>