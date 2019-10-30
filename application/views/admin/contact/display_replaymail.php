<?php

$this->load->view('admin/templates/header.php');

extract($privileges);

?>

<div id="content">

		<div class="grid_container">

			<div class="grid_12">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon list"></span>

						<h6>Edit Contact</h6>

					</div>

					<div class="widget_content">

					<?php 

						$attributes = array('class' => 'form_container left_label', 'id' => 'editcontact_form', 'enctype' => 'multipart/form-data','accept-charset'=>'UTF-8');

						echo form_open_multipart('admin/contact_us/replaymail1',$attributes);

					?>

                    	<div id="tab1">

	 						<ul>				

								<li>

								  <div class="form_grid_12">

								  	<?php

										$commonclass = array('class' => 'field_title');



										echo form_label('Email <span class="req">*</span>','email', $commonclass);	

									?>

									<div class="form_input">

										<?php

											echo form_input([

												'type'      => 'text',      

									            'name' 	    => 'replayemail',

									            'id'	    => 'replayemail',

									            'tabindex' 	=> '1',

									            'class'     => 'cnt-bx',

									            'readonly'	=> 'readonly',

									            'title'  	=> 'Enter the Representative Code',

												'value'	    => $admin_replay->row()->email

									        ]);

										?>

									</div>									

								   </div>

								 </li>

							</ul>



							<ul>

							<li>

								<div class="form_grid_12">

									<?php

										echo form_label('REPLY MESSAGE:<span class="req">*</span>','your-message', $commonclass);	

									?>

									<div class="form_input">

										<?php

											

									        $descattr = array(

											    'name'          => 'your-message',

											    'id'		    => 'your-message',

									            'style'   	    => 'width:295px',

									            'tabindex'      => '5',

									            'cols'		    => '60',

												'rows'	        => '10',
												'required' => 'required',

												'class'		    => 'wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required',

												'aria-required'	=> 'true',

												'aria-invalid'  => 'false'

											);

											echo form_textarea($descattr);

									    ?>

										</br>

										<br><span class="words-left"></span>

									</div>

								</div>

							</li>

							</ul>



							<ul>

							<li>

								<div class="form_grid_12">

									<div class="form_grid_12">

									<div class="form_input">

										<?php

											echo form_input([

												'type'     => 'submit',

												'value'    => 'Submit',

												'class'    => 'btn_small btn_blue'

												 ]);

										?>

									</div>

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



<script>

$('#replayemail').change(function() 

{

    var inputVal = $(this).val();

    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    if(!emailReg.test(inputVal))

    {

        alert("Enter Valid Email Id");

		$("#replayemail").focus();

		$("#replayemail").val('');

    }

});

</script>