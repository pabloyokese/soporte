<!DOCTYPE html>
<html lang="en">
	<?php $this -> load -> view('templates/header');?>
	<body>
		<?php
		$data['tecnico']=$tecnico;
		?>
		<?php $this -> load -> view('templates/menu_main',$data);?>

		<div class="container">
			<div class="row-fluid">
				<div class="span12">
					<?php $this -> load -> view($contenido);?>
				</div>
			</div>
			
		</div>
		<!-- /container -->
		<?php $this -> load -> view('templates/footer');?>
	</body>
</html>