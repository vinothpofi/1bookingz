<?php
$this->load->view('admin/templates/header.php');
$id = $this->uri->segment(4);
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_8">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $gateway_details->row()->gateway_name; ?></h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'UTF-8');
						echo form_open('admin/paygateway/insertEditGateway', $attributes);
						$gatewaySettings = unserialize($gateway_details->row()->settings);

						if (!is_array($gatewaySettings))
						{
							$gatewaySettings = array();
						}

						if (isset($gatewaySettings['mode']))
						{
							?>
							<ul>
								<li style="<?php if ($id == '1')
								{
									echo "display:block";
								} 
								else
								{
									echo "display:none";
								} ?>">
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label('Mode <span class="req">*</span>','mode', 
												$commonclass);	
										?>
										<div class="form_input">
											<div class="live_sandbox">
												<?php
													$gatestt = "";
													if ($gatewaySettings['mode'] == 'live')
													{
														$gatestt = checked;
													}

													echo form_input([
														'type'      => 'checkbox',      
											            'name' 	    => 'mode',
											            'id'	    => 'live_sandbox',
											            'class'     => 'live_sandbox',
											            $gatestt    => $gatestt
											        ]);
												?>
											</div>
										</div>
									</div>
								</li>

								<?php foreach ($gatewaySettings as $key => $val)
								{
									if ($key != 'mode')
									{
										if ($key == 'paypal_ipn_url')
										{ ?>
											<li>
												<div class="form_grid_12">
													<?php

														echo form_label(''.ucwords(str_replace('_', ' ', $key)).'<span class="req">*</span>',$key, 
															$commonclass);	
													?>
													<div class="form_input">
														<?php
															echo form_input([
																'type'      => 'text',      
													            'name' 	    => $key,
													            'id'	    => $key,
													            'style' 	=> 'width:295px',
													            'class'     => 'tipTop required',
													            'tabindex'	=> '1',
													            'title'  	=> 'Please enter'.$key,
																'value'	    => $val
													        ]);
														?>
													</div>
												</div>
											</li>

										<?php 
										}
										else
										{ ?>
											<li>
												<div class="form_grid_12">
													<?php

														echo form_label(''.ucwords(str_replace('_', ' ', $key)).'<span class="req">*</span>',$key, 
															$commonclass);	
													?>
													<div class="form_input">
														<?php
															echo form_input([
																'type'      => 'text',      
													            'name' 	    => $key,
													            'id'	    => $key,
													            'style' 	=> 'width:295px',
													            'class'     => 'tipTop required',
													            'tabindex'	=> '1',
													            'title'  	=> 'Please enter'.$key,
																'value'	    => $val
													        ]);
														?>
													</div>
												</div>
											</li>
										<?php }
									}
								} ?>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<?php
												if($site_status_val == 1){
												echo form_input([
													'type'     => 'submit',
											        'value'    => 'Update',
											        'tabindex' => '4',
											        'class'    => 'btn_small btn_blue'
											        ]);	
												}
												elseif($site_status_val == 2)
												{
											?>
											<button type="button" class="btn_small btn_blue" onclick="alert('Cannot Submit on Demo Mode')">Update</button>
										<?php } ?>
										</div>
									</div>
								</li>
							</ul>
						<?php 
						}

						echo form_input([
							'type'     => 'hidden',
							'name'     => 'gateway_id',
							'value'	   => $gateway_details->row()->id
							]);	

						echo form_close(); 
						?>
					</div>
				</div>
			</div>
			<div class="grid_4">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $gateway_details->row()->gateway_name; ?></h6>
					</div>
					<div class="widget_content">
						<ul>

						<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'UTF-8');
						echo form_open('admin/paygateway/insertEditGateway', $attributes);

						if(strtolower(str_replace(' ','_',$gateway_details->row()->gateway_name)) == 'credit_card'){ ?>
							<li>
								<div class="form_grid_12">
									<label class="field_title">Test card Number</label>
									<div class="form_input">
										<label>4111111111111111</label>
									</div>
								</div>
								<div class="form_grid_12">
									<label class="field_title">Test card type</label>
									<div class="form_input">
										<label>Visa</label>
									</div>
								</div>
								<div class="form_grid_12">
									<label class="field_title">Test card cvv</label>
									<div class="form_input">
										<label>123</label>
									</div>
								</div>
							</li>

						<?php }elseif(strtolower(str_replace(' ','_',$gateway_details->row()->gateway_name)) == 'paypal_ipn'){ ?>
							<li>
								<div class="form_grid_12">
									<label class="field_title">Test Account Details</label>
									<div class="form_input">
										<label>kumarkailash075-buyer@gmail.com</label><br>
										<label>mahesh84</label>
									</div>
								</div>
							</li>
						<?php }elseif(strtolower(str_replace(' ','_',$gateway_details->row()->gateway_name)) == 'stripe'){ ?>
							<li>
								<div class="form_grid_12">
									<label class="field_title">Test card Number</label>
									<div class="form_input">
										<label>4242424242424242</label>
									</div>
								</div>
								<div class="form_grid_12">
									<label class="field_title">Test card type</label>
									<div class="form_input">
										<label>Visa</label>
									</div>
								</div>
								<div class="form_grid_12">
									<label class="field_title">Test card cvv</label>
									<div class="form_input">
										<label>123</label>
									</div>
								</div>
							</li>
						<?php } echo form_close();  ?>
						</ul>
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
