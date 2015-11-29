<!DOCTYPE html>
<html lang="en">
	<?php $this->load->view('templates/header');?>
	<body>
		<?php $this->load->view('templates/menu');?>

		<div class="container">
			<?php $this->load->view($contenido);?>
		</div>
		<!-- /container -->
		<?php $this->load->view('templates/footer');?>
	</body>
</html>