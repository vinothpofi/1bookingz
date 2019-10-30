<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Location</h6>
                        <div id="widget_tab">
              				<ul>
               					 <li><a href="#tab1" class="active_tab">Content</a></li>
               					 <li><a href="#tab2">SEO</a></li>
             				 </ul>
            			</div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');
						echo form_open('admin/location/insertEditLocation',$attributes) 
					?> 		
                    	<div id="tab1">
	 						<ul>
                                <li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Country Name <span class="req">*</span>','location_name', $commonclass);	
									?>
									<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'name',
									            'id'	    => 'name',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the country name'
									    ]);
									?>									<div id="suggesstion-box" class="cntry_box" ><span id="no_country"> </span></div>
									<span id="name_valid" style="color:#f00;display:none;">Only Characters are allowed!
									</span>
									</div>
								</div>
								</li>

                                <li>
								<div class="form_grid_12">
									<?php
										echo form_label('Country Code','iso_code2', $commonclass);	
									?>
									<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'country_code',
									            'id'	    => 'country_code',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',																								'disabled'    => 'disabled',
									            'title'  	=> 'Please enter the iso_code2'
									    ]);
									?>
									</div>
								</div>
								</li>

                                <li>
								<div class="form_grid_12">
									<?php
										echo form_label('Country Mobile Code ','iso_code3', $commonclass);	
									?>
									<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'country_mobile_code',
									            'id'	    => 'country_mobile_code',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop',
									            'tabindex'	=> '1',																								'disabled'    => 'disabled',
									            'title'  	=> 'Please enter the iso_code3'
									    ]);
									?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<?php
									 echo form_label('Language','language_code', $commonclass);	
									?>
									<div class="form_input">
									<?php
										$lng=array();
										$lng[''] = '--Select--';
										if($LanguageList->num_rows() > 0)
										{
											foreach($LanguageList->result() as $Row)
											{												
												$lng[$Row->lang_code] = $Row->name;
											}
										}											 

										$lngattr = array(
											    'id'     => 'user_birthdate_2i',
											    'class'  => 'valid tipTop',
											    'title'	 => 'Please select Language'	   
										);

										echo form_dropdown('language_code', $lng, '', $lngattr);

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
								<?php
										echo form_input([
												'type'      => 'hidden',      
									            'name' 	    => 'location_id',
									            'value'	    => ''
									    ]);
								?>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'      => 'submit',      
									            'class' 	=> 'btn_small btn_blue',
									            'tabindex'	=> '4',
									            'value'		=> 'Update'
									    	]);
										?>
									</div>
								</div>
								</li>
							</ul>
                        </div>

                        <div id="tab2">
		              <ul>
		                <li>
		                  <div class="form_grid_12">
		                   <?php
									echo form_label('Meta Title','meta_title', $commonclass);	
							?>
		                    <div class="form_input">
		                    	<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'meta_title',
									            'id'	    => 'meta_title',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the page meta title'
									    ]);
								?>
		                    </div>
		                  </div>
		                </li>

		                <li>
		                  <div class="form_grid_12">
		                    <?php
									echo form_label('Meta Keyword','meta_tag', $commonclass);	
							?>
		                    <div class="form_input">
		                    	<?php
			                    		$keywrdattr = array(
			                    			'name'		=> 'meta_keyword',
			                    			'id' 		=> 'meta_keyword',
			                    			'tabindex'  => '2',
			                    			'class' 	=> 'large tipTop',
			                    			'rows'		=> '2',
			                    			'title' 	=> 'Please enter the page meta keyword'
			                    		);
			                    		echo form_textarea($keywrdattr);
			                    	?>
		                    </div>
		                  </div>
		                </li>

		                <li>
		                  <div class="form_grid_12">
		                    <?php
									echo form_label('Meta Description','meta_description', $commonclass);	
							?>
		                    <div class="form_input">
		                    	<?php
			                    		$descattr = array(
			                    			'name'		=> 'meta_description',
			                    			'id' 		=> 'meta_description',
			                    			'tabindex'  => '3',
			                    			'class' 	=> 'large tipTop',
			                    			'rows'		=> '3',
			                    			'title' 	=> 'Please enter the meta description'
			                    		);
			                    		echo form_textarea($descattr);
			                    ?>
		                    </div>
		                  </div>
		                </li>
		              </ul>
		             <ul><li><div class="form_grid_12">
						<div class="form_input">
							<?php
								echo form_input([
												'type'      => 'submit', 
									            'class'     => 'btn_small btn_blue',
									            'tabindex'	=> '4',
												'value'	    => 'Submit'
								]);
							?>
						</div>
					</div></li></ul>
					</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<!-- script to validate form inputs -->
<script type="text/javascript">
	$('#commentForm').validate();	
</script><script type="text/javascript">  $('#name').keyup(function()      {        $('#country_code').val('');        $('#country_mobile_code').val('');                var aj = this.value;        if(aj==''){          return;        }               $.ajax({          type: 'get',          url: 'admin/location/array_search_country',          data: {searched_country: aj},          success: function(response){            myContent=response;                        result=$(myContent).text();                        if($.trim(result)==''){                          $("#suggesstion-box").show();              $("#suggesstion-box").text("No country found!");              return false;            }            // alert(response);            $("#suggesstion-box").show();            $("#suggesstion-box").html(response);            $("#name").css("background","#FFF");          }        });      });	  	function selectCountry(val) { 	$("#name").val(val);	$("#suggesstion-box").hide();	var searched_country_name=val;	$.ajax({			  type: 'get',			  url: 'admin/location/add_searched_country',			  data: {searched_country_name: searched_country_name},			 			  success: function(response){				//alert(response);				id_numbers = response.split('||');			   var Country_code=id_numbers[0];			   var Country_name=id_numbers[1];			   var currency_symbol=id_numbers[2];			   var currency_code=id_numbers[3];			   var dial_code='+'+id_numbers[4];			   $('#country_code').val(Country_code);			   $('#country_mobile_code').val(dial_code);			   			  }			}); 	}$('#name').bind('keyup blur',function(){     var node = $(this);    node.val(node.val().replace(/[^a-z]/g,'') ); });</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
