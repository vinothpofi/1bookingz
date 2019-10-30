<div id="content">

		<div class="grid_container">

			<div class="grid_12">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon list"></span>

						<h6>Change Password</h6>

					</div>

					<div class="widget_content">

					<?php 

						$attributes = array('class' => 'form_container left_label', 'id' => 'regitstraion_form');

						echo form_open('admin/adminlogin/change_admin_password',$attributes) 

					?>

	 						<ul>

								<li>

								<div class="form_grid_12">

									<?php

									$currpswdlbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('Current Password<span class="req">*</span>','Current Password',$currpswdlbl);

									?>

									<div class="form_input">

										<?php

										$currpswd = array(

											'name' 	       => 'password',

											'id'   	   	   => 'password',

											'tabindex' 	   => '1',

											'class'    	   => 'required large tipTop',

											'autocomplete' => FALSE,

											'title'        => 'Please enter the current password'

										);

										echo form_password($currpswd);

										?>										

									</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<?php

									$newpswdlbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('New Password<span class="req">*</span>','newpassword',$newpswdlbl);

									?>

									<div class="form_input">

										<?php

										$newpswd = array(

											'name' 	       => 'new_password',

											'id'   	       => 'new_password',

											'tabindex'     => '2',

											'class'    	   => 'required large tipTop',

											'autocomplete' => FALSE,

											'title'        => 'Please enter a new password'

										);

										echo form_password($newpswd);

										?>

									</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<?php

									$newpswdlbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('Retype Password<span class="req">*</span>','confirm_password',$newpswdlbl);

									?>

									<div class="form_input">

										<?php

										$repswd = array(

											'name' 	       => 'confirm_password',

											'id'   	       => 'confirm_password',

											'tabindex'     => '3',

											'class'        => 'required large tipTop',

											'autocomplete' => FALSE,

											'title'        => 'Please re-enter your new password again'

										);

										echo form_password($repswd);

										?>

									</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<div class="form_input">

										<?php
										if($site_status_val == 1){
										$pswdsbt = array(

											'value' 	   => 'Change',

											'class'    => 'btn_small btn_blue'

										);

										echo form_submit($pswdsbt);
										}elseif($site_status_val == 2){
										?>
										<button type="button" class="btn_small btn_blue" onclick="alert('Cannot Submit on Demo Mode')">Change</button>
                                    	<?php } ?>
									</div>

								</div>

								</li>

							</ul>

						<?php form_close(); ?>

					</div>

				</div>

			</div>

		</div>

		<span class="clear"></span>

	</div>

</div>