
<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<div>
						    <h3>Dear Admin</h3>
						    <p>We are sorry! Your last transaction was cancelled.</p>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>	
