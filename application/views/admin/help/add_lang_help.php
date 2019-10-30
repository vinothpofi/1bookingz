<?php

$this->load->view('admin/templates/header.php');

?>

<script>

function main_page(val1){

$.ajax(

     {

			type: 'POST',

			url:'<?php echo base_url(); ?>admin/help/main_help',

			data:{'id':val1},

			success: function(data) 

			{

			$('#lang_warn').html(data);

			}

	 });

}

</script>

<div id="content">

		<div class="grid_container">

			<div class="grid_12">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon list"></span>

						<h6>Add New page</h6>

					</div>

					<div class="widget_content">

					<?php 

						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');

						echo form_open(ADMIN_PATH.'/help/insert_main_lang',$attributes) 

					?> 		

                    	<div id="tab1">

	 						<ul>

							    <li>

								    <div class="form_grid_12">

									    <?php

											$commonclass = array('class' => 'field_title');



											echo form_label('Type <span class="req">*</span>','location_name', $commonclass);	

										?>

									    <div class="form_input">

										<?php 

											$typ = array(); 

											$typ = array(	

											        'Both'         => 'Both',

											        'Guest'        => 'Guest',

											        'Host'  	   => ' Host'	   

											);											



											$typattr = array(

											        'style'  => ' width:295px; height:30px;',

											        'title'  => 'Please Choose Type'	   

											);



											echo form_dropdown('type', $typ, '', $typattr);

											?>

									    </div>

								    </div>

								</li>

								<li>

								  <div class="form_grid_12">

								  	<?php

										echo form_label('Choose Main Menu <span class="req">*</span>','page_name', $commonclass);	

									?>									

									<div class="form_input">

									<?php 

										$minmen = array(); 

										$minmen[''] = 'Please Choose Main Menu';									

										foreach($cms_details->result() as $page)

										{

											$minmen[$page->id] = $page->name;

										}



										$minmenattr = array(

											        'onchange'  => 'main_page(this.value)',

											        'id'  => 'page_name',

											        'class' => 'required large tipTop',

											        'title'	 => 'Choose the Main page'   

											);



										echo form_dropdown('seourl', $minmen, '', $minmenattr);

									?>

									</div>

								  </div>

								</li>



								 <li>

								  <div class="form_grid_12">

								  	<?php

										echo form_label('Choose Language <span class="req">*</span>','page_name', $commonclass);	

									?>

									<div class="form_input">

									<?php 

										$lngcd = array();



										$lngcd = array(	

											    ''         => 'Please Choose Language'

										);											



										$lngcdattr = array(

											        'id'  	 => 'lang_warn',

											        'class'  => 'required large tipTop',

											        'title'  => 'Choose the Language'	   

										);



										echo form_dropdown('lang_code', $lngcd, '', $lngcdattr);

									?>

									</div>

								  </div>

								</li>



								<li>

								    <div class="form_grid_12">

								    	<?php

										echo form_label('Menu Name <span class="req">*</span>','location_name', $commonclass);	

										?>

									    <div class="form_input">

									    <?php

												echo form_input([

												'type'        => 'text',      

									            'name' 	      => 'help_name',

									            'style'   	  => 'width:295px',

									            'id'          => 'currency_symbol',

												'tabindex'	  => '1',

												'class'		  => 'required tipTop',

												'title'		  => 'Please enter the Page name'

												]);

											?>  

									    </div>

								    </div>

								</li>

								 

                                

								<li>

								<div class="form_grid_12">

									<?php										

										echo form_label('Status <span class="req">*</span>','admin_name', $commonclass);	

								    ?>

									<div class="form_input">

										<div class="active_inactive">

                                        <input type="checkbox" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>

										</div>

									</div>

								</div>

								</li>

								

								<li>

								    <div class="form_grid_12">

									    <div class="form_input">

										   <?php

												echo form_input([

													'type'        => 'submit',      

										            'value' 	  => 'Update',

													'class'		  => 'btn_small btn_blue'

										        ]);

										    ?>

									    </div>

								    </div>

								</li>

							</ul>

                        </div>

                        <?php echo form_close(); ?>

					</div>

				</div>

			</div>

		</div>

		<span class="clear"></span>

	</div>

</div>

<?php 

$this->load->view('admin/templates/footer.php');

?>