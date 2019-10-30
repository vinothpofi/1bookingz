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
						</div>
					</div>

					<div class="widget_content">
						<table class="display display_tbl" id="">
							<thead>
							<tr>

								<th class="tip_top" title="Click to sort">S.no</th>
								<th class="tip_top" title="Click to sort">Top Menu Name</th>
								<th class="tip_top" title="Click to sort">Last updated On</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($top_menu->num_rows() > 0)
							{
								foreach ($top_menu->result() as $key=>$row)
								{
									?>
									<tr>
                                        <td class="center">
                                            <?php echo  ++$key; ?>
                                        </td>

										<td class="center">
											<?php echo $row->top_menu_name; ?>
										</td>
										<td class="center">
											<?php echo date('d-m-Y H:i:a',strtotime($row->top_menu_updated_on)); ?>
										</td>

                                        <td class="center">
                                            <span>
													<a class="action-icons c-edit"
                                                       href="admin/cms/edit_top_menu_form/<?php echo $row->top_menu_id; ?>"
                                                       title="Edit">Edit
													</a>
												</span>
                                        </td>

									</tr>
									<?php
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
                                <th>S.no</th>
                                <th>Top Menu Name</th>
                                <th>Last updated On</th>
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