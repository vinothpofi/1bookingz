<?php
$this->load->view('admin/templates/header.php');
?>
<?php  echo $map['js']; ?>

<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Rental</h6>
                        <div id="widget_tab">
              				<ul>
               					 <li><a href="#tab1" class="active_tab">Rental General Information</a></li>
                                  <!--<li><a href="#tab2">Category</a></li>-->
                                  <li><a href="#tab3">Images</a></li>
                                  <li><a href="#tab4">Amenities</a></li>
                                  <li><a href="#tab5">Address & Availability Information</a></li>
                                  <li><a href="#tab6">Listing</a></li>
                                  <li><a href="#tab7">Detailed description</a></li>
                                  <li><a href="#tab8">SEO</a></li>
             				 </ul>
            			</div>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addproduct_form');
						echo form_open('admin',$attributes) ;
/*						$optionsArr = unserialize($product_details->row()->option);
						if (is_array($optionsArr) && count($optionsArr)>0){
							$options = 'available';
							$attNameArr = $optionsArr['attribute_name'];
							$attValArr = $optionsArr['attribute_val'];
							$attWeightArr = $optionsArr['attribute_weight'];
							$attPriceArr = $optionsArr['attribute_price'];
						}else {
*/							$options = '';
//						}
						$list_names = $product_details->row()->list_name;
						$list_names_arr = explode(',', $list_names);
						$list_values = $product_details->row()->list_value;
						$list_values_arr = explode(',', $list_values);
						$imgArr = explode(',', $product_details->row()->image);
					?>
                    
                     <div id="tab1">
						<ul>
	 						<li>
                <div class="form_grid_12">
                  <label class="field_title" for="user_id">Rental Owner Name <span class="req">*</span></label>
                  <div class="form_input">
                  <?php 
				  if(!empty($userdetails)){ 
				  	foreach($userdetails->result() as $user_details){
				  
				  
				  ?>
                 
                  <?php if($user_details->id==$product_details->row()->OwnerId){echo ucfirst($user_details->firstname).' '.ucfirst($user_details->lastname);} 
				  
				  
				  }}?>
                    
                    
                  </div>
                </div>
              </li>	
							<li>
							<div class="form_grid_12">
							<label class="field_title" for="product_name">Title </label>
							<div class="form_input">
								<?php 
								if ($product_details->row()->product_title != ''){
									echo $product_details->row()->product_title;
								}else {
									echo 'Not available';
								}
								?>
							</div>
							</div>
							</li>
						<!--<li>
                <div class="form_grid_12">
                  <label class="field_title" for="product_title">Rentals Title <span class="req">*</span></label>
                  <div class="form_input">
                   <?php 
								if ($product_details->row()->product_title != ''){
									echo $product_details->row()->product_title;
								}else {
									echo 'Not available';
								}
								?>
                  </div>
                </div>
              </li>-->
                        	
	 						<li>
								<div class="form_grid_12">
								<label class="field_title" for="description">Summary</label>
								<div class="form_input">
								<?php 
								if ($product_details->row()->description != ''){
									echo $product_details->row()->description;
								}else {
									echo 'Not available';
								}
								?>
								</div>
								</div>
							</li>

	 						<!--<li>
								<div class="form_grid_12">
								<label class="field_title" for="description">Excerpt</label>
								<div class="form_input">
								<?php 
								if ($product_details->row()->excerpt != ''){
									echo $product_details->row()->excerpt;
								}else {
									echo 'Not available';
								}
								?>
								</div>
								</div>
							</li>-->
                            
                            <li>
								<div class="form_grid_12">
								<label class="field_title" for="price">Price per night</label>
								<div class="form_input">
								<?php 
								if ($product_details->row()->price != ''){
									echo $product_details->row()->price."  ".$product_details->row()->currency;
								}else {
									echo 'Not available';
								}
								?>
								</div>
								</div>
							</li>
                            
                            <li>
								<div class="form_grid_12">
								<label class="field_title" for="price">Price per Week</label>
								<div class="form_input">
								<?php 
								if ($product_details->row()->price_perweek != ''){
									echo $product_details->row()->price_perweek."  ".$product_details->row()->currency;
								}else {
									echo 'Not available';
								}
								?>
								</div>
								</div>
							</li>
                            
                            <li>
								<div class="form_grid_12">
								<label class="field_title" for="price">Price per Month</label>
								<div class="form_input">
								<?php 
								if ($product_details->row()->price_permonth != ''){
									echo $product_details->row()->price_permonth."  ".$product_details->row()->currency;
								}else {
									echo 'Not available';
								}
								?>
								</div>
								</div>
							</li>
                            
                            
                            
                            
            <!--  <li>
                <div class="form_grid_12">
                  <label class="field_title" for="property_name">Property Name</label>
                  <div class="form_input">
                    <?php echo trim(stripslashes($product_details->row()->property_name));?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="holding_no">Plot or Holding Number</label>
                  <div class="form_input">
                   <?php echo trim(stripslashes($product_details->row()->holding_no));?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="no_of_star">Number of Stars (1-5 in number)<span class="req">*</span></label>
                  <div class="form_input">
                   <?php echo trim(stripslashes($product_details->row()->no_of_star));?>
                  </div>
                </div>
              </li>
              -->
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status </label>
									<div class="form_input">
										<?php 
										if ($product_details->row()->status != ''){
											echo $product_details->row()->status;
										}else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
								</li>
							</ul>
                     </div>
                   
                      <div id="tab3">
									<ul>
									
                                         <li>
                <div class="widget_content">
                                        <table class="display display_tbl" id="image_tbl">
                    <thead>
                      <tr>
                        <th class="center"> Sno </th>
                        <th> Image </th>
                        <th> Position </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
							if (count($imgArr)>0){
								$i=0;$j=1;
								$this->session->set_userdata(array('product_image_'.$product_details->row()->id => $product_details->row()->image));
								foreach ($imgDetail->result() as $img){
									if ($img != ''){
							?>
                      <tr id="img_<?php echo $i ?>">
                        <td class="center tr_select "><input type="hidden" name="imaged[]" value="<?php echo $img->product_image; ?>"/>
                          <?php echo $j;?> </td>
                        <td class="center"><img src="<?php if(strpos($img->product_image, 's3.amazonaws.com') > 1)echo $img->product_image;else echo base_url()."server/php/rental/".$img->product_image; ?>"  height="80px" width="80px" /> </td>
                        <td class="center"><span>
                         <?php echo $i; ?>
                          </span> </td>
                        
                      </tr>
                      <?php 
							$j++;
									}
									$i++;
								}
							}
							?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="center"> Sno </th>
                        <th> Image </th>
                        <th> Position </th>
                      </tr>
                    </tfoot>
                  </table></div></li>
								
                           <li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
								</li>     
                      </ul>          
                      </div>
                       <div id="tab4">
              <?php  
                         $list_name = $product_details->row()->list_name;						  
						 $facility = (explode(",", $list_name));  
						   
				         ?> 
              <ul>
              <h3>COMMON FACILITY</h3>
              
               <?php  
					    foreach($getCommonFacilityDetails as $details) : if($current_col == "0")echo "<tr>";?>
                         <li>
                         <input type="checkbox" class="checkbox_check" disabled="disabled" name="list_name[]" id="mostcommon"   <?php if(in_array($details['list_value'],$facility)) { ?> checked="checked" <?php } ?>value="<?php echo $details['list_value']; ?>"/><span><?php echo $details['list_value']; ?></span></li>
                        <?php 
                       
                        endforeach;                       
                         ?>                    
                         </li>
                       
                    
                        <h3>Extras</h3>
                        <p>Additional amenities your listing may offer. </p>
                        <?php
					    
					    foreach($getExtraFacilityDetails as $details) : if($current_col == "0")echo "<tr>";?>
                        <li><input type="checkbox" class="checkbox_check" disabled="disabled" name="list_name[]" <?php if(in_array($details['list_value'],$facility)) { ?> checked="checked" <?php } ?> value="<?php echo $details['list_value']; ?>"/><span><?php echo $details['list_value']; ?> </span></li>
                     
                        <?php 
                       
                        endforeach;
                       
                         ?> 
                         
                       <h3>Special Features</h3>
                        
                        <p>Features of your listing for guests with specific needs.</p>
                      <?php  
                        // $list_name = $listDetail->row()->list_name;						  
						 //$facility = (explode(",", $list_name));  
						   
				         ?> 
                    
                        
                      <?php
					   
					    foreach($getSpecialFeatureFacilityDetails as $details) : if($current_col == "0")echo "<tr>";?>
                        
                        
                       <li><input type="checkbox" class="checkbox_check" disabled="disabled" name="list_name[]"  <?php if(in_array($details['list_value'],$facility)) { ?> checked="checked" <?php } ?>
                         value="<?php echo $details['list_value']; ?>"/><span><?php echo $details['list_value']; ?></span></li>
                        <?php 
                       
                        endforeach;
                       
                         ?>   
                       
                         
                      
                      
                       <h3>Home Safety</h3>
                                            
                      <?php  
                        // $list_name = $listDetail->row()->list_name;						  
						 //$facility = (explode(",", $list_name));  
						   
				         ?> 
                    
                        
                      <?php
					   
					    foreach($getHomeSafetyFacilityDetails as $details) : if($current_col == "0")echo "<tr>";?>
                        
                        
                       <li><input type="checkbox" class="checkbox_check" disabled="disabled" name="list_name[]"  <?php if(in_array($details['list_value'],$facility)) { ?> checked="checked" <?php } ?>
                         value="<?php echo $details['list_value']; ?>"/><span><?php echo $details['list_value']; ?></span></li>
                        <?php 
                       
                        endforeach;
                       
                         ?>
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                         
                         
                         
                         
                         
                            
              <li>
                  <div class="form_grid_12">
                    
                    <div class="form_input" ><a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a> </div> </div>
                      </li>
            </ul>
          </div>
                     
 <div id="tab5">
 
 
                               <ul>
                      <li>
                <div class="form_grid_12">
                  <label class="field_title" for="country">Country:</label>
                  <div class="form_input">
                    
                      <?php echo ucfirst($product_details->row()->CountryName);?>
                  
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="state">State:</label>
                  <div class="form_input" id="listCountryCnt">
                    
                      <?php echo ucfirst($product_details->row()->StateName);?>
                    
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="city">City:</label>
                  <div class="form_input" id="listStateCnt">
                   
                      <?php echo ucfirst($product_details->row()->cityname);?>
                    
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="post_code">ZIP CODE :</label>
                  <div class="form_input">
                    <?php echo trim(stripslashes($product_details->row()->post_code));?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="address">Apt, Suite, Bldg.(optional)</label>
                  <div class="form_input">
                    <?php 
					if ($product_details->row()->apt!=''){
							echo trim(stripslashes($product_details->row()->apt));
					}else {
							echo 'Not available';
					}
					?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="address">Address</label>
                  <div class="form_input">
                    <?php echo trim(stripslashes($product_details->row()->address));?>
                  </div>
                </div>
              </li>
               
              
              
             
             
              <h4>Available Information </h4>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="datefrom">Availabe From: </label>
                  <div class="form_input"> <?php /*?>$product_details->row()->datefrom;<?php */?> 
                    <?php echo $product_details->row()->DATEFROM; ?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="dateto">Available To: </label>
                  <div class="form_input">
                   <?php echo $product_details->row()->DateTo;?>
                  </div>
                </div>
              </li>
              
			          <li><div class="form_grid_12">
				<div class="form_input">
					<a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
				</div>
			</div></li></ul>
                      </div>
                      <div id="tab6">
                      <ul>
                      <h4>Listing Info:</h4>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Home Type</label>
                  <div class="form_input">
                  <?php echo ucfirst($product_details->row()->home_type);?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="order_email">Room Type </label>
                  <div class="form_input">
                  <?php echo ucfirst($product_details->row()->room_type); ?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="invoice_template">Accommodates</label>
                  <div class="form_input">
               <?php echo $product_details->row()->accommodates;?>
                  </div>
                </div>
              </li>
               <h4>Rooms and beds:</h4>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Bedrooms</label>
                  <div class="form_input">
                    <?php echo $product_details->row()->bedrooms;?>
                    
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Beds</label>
                  <div class="form_input">
                   <?php echo $product_details->row()->beds;?>
                  </div>
                </div>
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Bed type</label>
                  <div class="form_input">
                 <?php echo ucfirst($product_details->row()->bed_type);?>
                  </div>
                </div>
              </li>
               <li>
                <div class="form_grid_12">
                  <label class="field_title" for="confirm_email">Bathrooms</label>
                  <div class="form_input">
                   <?php echo $product_details->row()->bathrooms;?>
                   
                  </div>
                </div>
              </li>
            </ul>
			          <ul><li><div class="form_grid_12">
				<div class="form_input">
					<a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
				</div>
			</div></li></ul>
                      </div>
                      <div id="tab7">
            <ul>
            <h3>Details</h3><p>A description of your space displayed on your public listing page. </p>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="space">The Space</label>
                  <div class="form_input">
                                
                                 <?php 
								if ($product_details->row()->space != ''){
									echo $product_details->row()->space;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  

                  </div>
                
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="guest_access">Guest Access</label>
                  <div class="form_input">
                                 
                                 <?php 
								if ($product_details->row()->guest_access != ''){
									echo $product_details->row()->guest_access;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  

                  </div>
                
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="interact_guest">Interaction with Guests</label>
                  <div class="form_input">
                                 
                                 <?php 
								if ($product_details->row()->interact_guest != ''){
									echo $product_details->row()->interact_guest;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  

                  </div>
                
              </li>
              <h3>The Neighborhood</h3><p>A description of your neighborhood displayed on your public listing page. </p>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="neighbor_overview">Overview</label>
                  <div class="form_input">
                                 
                                 <?php 
								if ($product_details->row()->neighbor_overview != ''){
									echo $product_details->row()->neighbor_overview;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  

                  </div>
                
              </li>
              
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="neighbor_around">Getting around</label>
                  <div class="form_input">
                                 
                                 <?php 
								if ($product_details->row()->neighbor_around != ''){
									echo $product_details->row()->neighbor_around;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  

                  </div>
               
              </li>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="neighbor_around">Overview</label>
                  <div class="form_input">
                                
                                 <?php 
								if ($product_details->row()->neighbor_around != ''){
									echo $product_details->row()->neighbor_around;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  
                  </div>
               
              </li>
              <h3>Extra Details</h3><p>Other information you wish to share on your public listing page. </p>
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="other_thingnote">Other Things to Note</label>
                  <div class="form_input">
                                 <?php 
								if ($product_details->row()->other_thingnote != ''){
									echo $product_details->row()->other_thingnote;
								}else {
									echo 'Not available';
								}
								?>
                    </div>  
                  </div>
               
              </li>
              
              <li>
                <div class="form_grid_12">
                  <label class="field_title" for="house_rules">House Rules</label>
                  <div class="form_input">
                  <?php 
								if ($product_details->row()->house_rules != ''){
									echo $product_details->row()->house_rules;
								}else {
									echo 'Not available';
								}
								?>
                                 
                    </div>  
                  </div>
               
              </li>
              
              
            </ul>
            <ul>
              <li>
                <div class="form_grid_12">
                  <div class="form_input" style="margin:0px;width:100%;">
                    <a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
                      
                      
                      
                      
                      
                      <!--<div id="tab7">
                      <ul>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_title">Meta Title</label>
                    <div class="form_input">
                      <?php 
								if ($product_details->row()->pakageName != ''){
									echo $product_details->row()->pakageName;
								}else {
									echo 'Free Membership';
								}
								?>
                    </div>
                  </div>
                </li>


              </ul>
			          <ul><li><div class="form_grid_12">
				<div class="form_input">
					<a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
				</div>
			</div></li></ul>
                      </div>-->
                      <div id="tab8">
                      <ul>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_title">Meta Title</label>
                    <div class="form_input">
                      <?php 
								if ($product_details->row()->meta_title != ''){
									echo $product_details->row()->meta_title;
								}else {
									echo 'Not available';
								}
								?>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_tag">Meta Keyword</label>
                    <div class="form_input">
                      <?php 
								if ($product_details->row()->meta_keyword != ''){
									echo $product_details->row()->meta_keyword;
								}else {
									echo 'Not available';
								}
								?>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form_grid_12">
                    <label class="field_title" for="meta_description">Meta Description</label>
                    <div class="form_input">
                      <?php 
								if ($product_details->row()->meta_description != ''){
									echo $product_details->row()->meta_description;
								}else {
									echo 'Not available';
								}
								?>
                    </div>
                  </div>
                </li>
              </ul>
			          <ul><li><div class="form_grid_12">
				<div class="form_input">
					<a href="admin/product/display_product_list" class="tipLeft" title="Go to rental list"><span class="badge_style b_done">Back</span></a>
				</div>
			</div></li></ul>
                      </div>
            
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