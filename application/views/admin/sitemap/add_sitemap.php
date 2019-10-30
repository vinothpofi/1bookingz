<?php
$this->load->view('admin/templates/header.php');
?>
<!--Script files-->
<script src="js/jquery.validate.js"></script>
<script>$(document).ready(function(){$("#addbanner_form").validate(); });</script>

<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading;?></h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addsitemap_form', 'method' => 'post',  'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/sitemap/insertsitemap',$attributes)
					?>                    
					<ul>
						<li>
							<div class="form_grid_12 form_chsfile">
								<?php
									$commonlbl = array(
									        'class' => 'field_title'  
									);
									echo form_label('Sitemap File<span class="req">*</span>','banner_image',$commonlbl);
								?>								
								<div class="form_input">
									<?php
										$sitemapattr = array(
											'name' 	   => 'sitemap_file',
											'id'   	   => 'sitemap_file',
											'tabindex' => '2',
											'type'	   => 'file',
											'class'    => 'required large tipTop',
											'title'    => 'Please upload Sitemap',
											'accept'   => 'xml'
										);
										echo form_upload($sitemapattr);
									?>
									<span class="input_instruction red mrgn_top">To create a sitemap for below link and upload the sitemap.xml file.<br><a href="https://xmlsitemapgenerator.org/" target="_blank">https://xmlsitemapgenerator.org/</a>
									</span>
								</div>
							</div>
						</li>
								
						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										$sbmtattr = array(
											'tabindex' => '5',
											'type'	   => 'submit',
											'class'    => 'btn_small btn_blue',
											'value'	   => 'submit'
										);
										echo form_submit($sbmtattr);
									?>
								</div>
							</div>
						</li>
					</ul>              
                <?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>
<!--Script for form validation-->
<script type="text/javascript">
$('#addsitemap_form').validate();
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>