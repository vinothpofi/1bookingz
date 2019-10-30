<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/cms/change_cms_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('2', $Static_pages))
							{ ?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Publish','<?php echo $subAdminMail; ?>');"
									   class="tipTop"
									   title="Select any checkbox and click here to publish records"><span class="icon accept_co"></span><span class="btn_link">Publish</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Unpublish','<?php echo $subAdminMail; ?>');"
									   class="tipTop"
									   title="Select any checkbox and click here to unpublish records"><span class="icon delete_co"></span><span class="btn_link">Unpublish</span>
									</a>
								</div>
								<?php
							}

							if ($allPrev == '1' || in_array('3', $Static_pages))
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php 
							} ?>
						</div>
					</div>

					<div class="widget_content">
						<table class="display display_tbl" id="cms_tbl">
							<thead>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								</th>
                                <th class="tip_top" title="Click to sort">Top Menu</th>
								<th class="tip_top" title="Click to sort">Page Name</th>
								<th class="tip_top" title="Click to sort">Page Url</th>

								<th class="tip_top" title="Click to sort">View Order</th>
								<th class="tip_top" title="Click to sort">Other Language</th>
								<th class="tip_top" title="Click to sort">Hidden Page</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($cmsList->num_rows() > 0)
							{
								foreach ($cmsList->result() as $row)
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php 
											if ($row->seourl != "privacy-policy" && $row->seourl != "terms-of-service" && $row->seourl != "cancellation-policy") 
											{ 
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row->id,
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'check'
											    ]);	
												
											} ?>
										</td>
                                        <td class="center">
                                            <?php echo $row->top_menu_name; ?>
                                        </td>
										<td class="center">
											<?php echo $row->page_name; ?>
										</td>
										<td class="center">
											<a href="<?php echo base_url() . 'pages/' . $row->seourl; ?>"
											   target="_blank"><?php echo base_url() . 'pages/' . $row->seourl; ?>  
											</a>
										</td>

                                        <td class="center tr_select ">

                                            <?php

                                            echo form_input([

                                                'type'      => 'number',

                                                'id' 	    => 'rep_code',

                                                'onchange'	    	=> 'save_order(this.value,'.$row->id.')',

                                                'onkeypress' 	=> 'check_click(event);',

                                                'value'	    	=> $row->view_order,
                                                'min'=>'0'

                                            ]);

                                            ?>

                                        </td>
										<td class="center">
											<a href="admin/cms/display_other_lang/<?php echo $row->top_menu_id; ?>/<?php echo $row->seourl ?>">view
											</a>
										</td>
										<td class="center">
											<?php
											if ($allPrev == '1' || in_array('2', $Static_pages))
											{
												$mode = ($row->hidden_page == 'Yes') ? 'No' : 'Yes';
												if ($mode == 'No')
												{
													?>
													<a title="Click to hide this page" class="tip_top"
													   href="javascript:confirm_mode('admin/cms/change_cms_mode/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo $row->hidden_page; ?></span>
													</a>
													<?php
												} 
												else
												{
													?>
													<a title="Click to unhide this page" class="tip_top"
													   href="javascript:confirm_mode('admin/cms/change_cms_mode/<?php echo $mode; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo $row->hidden_page; ?></span>
													</a>
													<?php
												}
											} 
											else
											{
												?>
												<span class="badge_style b_done"><?php echo $row->hidden_page; ?>	
												</span>
											<?php 
											} ?>
										</td>
										<td class="center">
											<?php
											if ($row->seourl != "privacy-policy" && $row->seourl != "terms-of-service" && $row->seourl != "cancellation-policy")
											{
												if ($allPrev == '1' || in_array('2', $Static_pages))
												{
													$mode = ($row->status == 'Publish') ? '0' : '1';
													if ($mode == '0')
													{
														?>
														<a title="Click to unpublish" class="tip_top" href="javascript:confirm_status('admin/cms/change_cms_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo $row->status; ?></span>
														</a>
														<?php
													} 
													else
													{
														?>
														<a title="Click to publish" class="tip_top"
														   href="javascript:confirm_status('admin/cms/change_cms_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo $row->status; ?></span>
														</a>
														<?php
													}
												} 
												else
												{
													?>
													<span class="badge_style b_done"><?php echo $row->status; ?>	
													</span>
												<?php 
												}
											} 
											else
											{ ?>
												<span
													style="text-transform: uppercase;"><?php echo $row->status; ?>		
												</span>

											<?php 
											} ?>
										</td>
										<td class="center">
											<?php 
											if ($allPrev == '1' || in_array('2', $Static_pages))
											{ ?>
												<span>
													<a class="action-icons c-edit"
														 href="admin/cms/edit_cms_form/<?php echo $row->id; ?>"
														 title="Edit">Edit
													</a>
												</span>
											<?php 
											} 

											if (($allPrev == '1' || in_array('3', $Static_pages)) && ($row->seourl != "privacy-policy" && $row->seourl != "terms-of-service" && $row->seourl != "cancellation-policy"))
											{ ?>
												<span>
													<a class="action-icons c-delete"
														 href="javascript:confirm_delete('admin/cms/delete_cms/<?php echo $row->id; ?>')" title="Delete">Delete
													</a>
												</span>
											<?php 
											} ?>
										</td>
									</tr>
									<?php
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								</th>
                                <th>Top Menu</th>
								<th>Page Name</th>								
								<th>Page Url</th>
                                <th>View Order</th>
								<th>Other Language</th>
								<th>Hidden Page</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<?php
				echo form_input([
					'type'     => 'hidden',
					'id'       => 'statusMode',
					'name' 	   => 'statusMode'
					 ]);

				echo form_input([
					'type'     => 'hidden',
					'id'       => 'SubAdminEmail',
					'name' 	   => 'SubAdminEmail'
					 ]);

				echo form_close();	
			?>
		</div>
		<span class="clear"></span>
	</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
<script>

    function check_click(evt)

    {

       // evt.preventDefault();

    }



    function save_order(value, id){

        $.ajax({
                type: 'POST',
                url: baseURL+'admin/cms/save_cms_order',
                data:{'value':value,'id':id},
                success: function(data){

                    alert('View order saved successfully');

                }
            });

    }

</script>