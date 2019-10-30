<?php
$this->load->view('site/includes/header');
?>
<section style="background-size:cover;background: url('<?= base_url(); ?>images/background.jpg');">
	<div class="container Text-white">
		<div class="row">
			<h2><?php if ($this->lang->line('Contact Us') != '') {
					echo stripslashes($this->lang->line('Contact Us'));
				} else echo "Contact Us"; ?></h2>
			<div class="col-md-6 backgr">
				Sorry Page is not available
			</div>
			
		</div>
	</div>
</section>
<?php
$this->load->view('site/includes/footer');
?>