<?php

$this->load->view('admin/templates/header.php');

?>

<div id="content">

		<div class="grid_container">

			<div class="grid_12">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon list"></span>

						<h6>View Experience Cancel</h6>

					</div>

					<div class="widget_content">

					<?php 

						$attributes = array('class' => 'form_container left_label');

						echo form_open('admin',$attributes) 

					?>

	 						<ul>

                                <li>
                                    <div class="form_grid_12">
                                        <?php
                                        $commonclass = array('class' => 'field_title');

                                        echo form_label('Booking Number','booking_no', $commonclass);
                                        ?>
                                        <div class="form_input">
                                            <?php echo ucfirst($expdispute_details->row()->booking_no); ?>
                                        </div>
                                    </div>
                                </li>
                                <li>

								<div class="form_grid_12">

									<label class="field_title" for="title">Experience Name</label>

									<div class="form_input">

                                    <?php echo ucfirst($expdispute_details->row()->experience_title);?>

									</div>

								</div>

								</li>

								

                                <li>

								<div class="form_grid_12">

									<label class="field_title" for="description">Dispute Comments</label>

									<div class="form_input">

                                   <?php echo $expdispute_details->row()->message;?>

									</div>

								</div>

								</li>

                                

                               <li>

								<div class="form_grid_12">

									<label class="field_title" for="description">Dispute Email Address</label>

									<div class="form_input">

                                   <?php echo $expdispute_details->row()->email;?>

									</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<label class="field_title" for="description">Host Name</label>

									<div class="form_input">

									<?php if($expdispute_details->row()->med_senderid == $expdispute_details->row()->host_id){

									$host_id = $expdispute_details->row()->med_senderid; 

									}else{

									$host_id = $expdispute_details->row()->med_receiverid;

									} ?>

									<?php $host_details = $this->experience_dispute_model->get_all_details(USERS,array('id'=>$host_id)); ?>

                                   <?php echo $host_details->row()->user_name;?>

									</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<label class="field_title" for="description">User Name</label>

									<div class="form_input">

									

									<?php 

									$expdispute_details->row()->med_senderid;

									//echo $review_details->row()->host_id;

									if($expdispute_details->row()->med_senderid != $expdispute_details->row()->host_id){

									$user_id = $expdispute_details->row()->med_senderid;

									}else{

									$user_id = $expdispute_details->row()->med_receiverid;

									} ?>

									<?php $user_details = $this->experience_dispute_model->get_all_details(USERS,array('id'=>$user_id)); ?>

                                   <?php echo $user_details->row()->user_name;?>

                                  

									</div>

								</div>

								</li>

								<?php if($expdispute_details->row()->status=='Pending') { ?>		

								<li >

                                    <div class="form_grid_12">

                                        <label class="field_title" for="description">Status</label>

								<div class="margin-left">

                                    <?php
                                    $checkin=$expdispute_details->row()->checkin;
                                    $checkout=$expdispute_details->row()->checkin;
    if(strtotime(date('Y-m-d')) < strtotime('Y-m-d',$checkin)) {
                                    ?>
									<a href='<?php echo base_url()."admin/experience_dispute/accept_dispute/".$expdispute_details->row()->id.'/'.$expdispute_details->row()->booking_no;?>'><button type="button" class="btn_small btn_blue" tabindex="4"><span>Accept</span></button></a>

									<a href='<?php echo base_url()."admin/experience_dispute/reject_dispute/".$expdispute_details->row()->id.'/'.$expdispute_details->row()->booking_no;?>'>

									<button type="button" class="btn_small btn_blue" style='background-color: rgb(206, 10, 10);border-color:#771515  ' tabindex="4"><span>Reject</span></button></a>

        <?php }else{

        ?>
        <span class="badge_style" style="background-color: rgb(126, 123, 123);border-color:#771515">Expired</span>

        <?php

    } ?>

								</div>

                                    </div>

								</li>

								<?php  }	 ?>

								 <li>



								<div class="form_grid_12" style="margin-left:340px;">

									<label class="field_title" for="description">Message Conversation </label>	

								</div>

								</li> 

                               <li>

								<?php 

								$booking_no = $this->uri->segment(4);

								$message = $this->experience_dispute_model->get_all_details('fc_experience_med_message',array('bookingNo'=>$booking_no));

								foreach($message->result() as $list){

								if($expdispute_details->row()->host_id == $list->senderId){

								

								?>

								<li>

								<div class="form_grid_12">

									<label class="field_title" for="description"> <?php echo $host_details->row()->user_name;?> (HOST)</label>

									<div class="form_input">

                                   <?php echo $list->message;?>

									</div>

								</div>

								</li>

								<?php }else{ ?>

								<li>

								<div class="form_grid_12">

									<label class="field_title" for="description"><?php echo $user_details->row()->user_name;?> (USER)</label>

									<div class="form_input">

                                   <?php echo $list->message;?>

									</div>

								</div>

								</li>

							

								<?php } } ?>

								<li>

								<div class="form_grid_12">

									<div class="form_input">

										<a href="admin/experience_dispute/display_experience_dispute_list" class="tipLeft" title="Go to Experience Dispute list"><span class="badge_style b_done">Back</span></a>

									</div>

								</div>

							</li>

							</ul>

						</form>

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