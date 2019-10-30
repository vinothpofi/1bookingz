<?php
$this->load->view('site/includes/header');
?>
<div class="manage_items">
	<?php
	$this->load->view('site/includes/listing_head_side');
	?>
	<div class="centeredBlock middle-blk">
		<div class="content">
			<h3>
				<?php if ($this->lang->line('list_your') != '') {
					echo stripslashes($this->lang->line('list_your'));
				} else echo "List Your Space";
				if ($this->lang->line('City,State,Country') != '') {
					$csc= stripslashes($this->lang->line('City,State,Country'));
				} else $csc= "City,State,Country"; ?>
			</h3>
			<?php
			$hidden = array('accommodates' => '1', 'home_type_1' => '1', 'room_type_1' => '1');
			echo form_open('site/product/add_space', array('onsubmit'=>'checkSelect()','id' => 'contact_form'), $hidden); ?>
			<p id="flash_err" style="color:red;text-align: center;display: display;"><?php echo $this->session->flashdata('list_space_err'); ?></p>
			<div class="error-display" id="errordisplay" style="text-align: center; display: none;">
				<p class="text center text-danger" id="danger"></p>
				<p class="text center text-success" id="success"></p>
			</div>
			<div class="form-group">

				<p><?php
			if ($this->lang->line('City') != '') {
				echo stripslashes($this->lang->line('City'));
			} else
				echo "City";
			?> <span class="impt">*</span></p>
				<?php
				$city_data = array('name' => 'address_location', 'id' => 'autocomplete1', 'class' => 'searchInput', 'required' => 'required', 'placeholder' => $csc);
				echo form_input($city_data);
				?>
			</div>
			<?php
			// echo "<pre>";
			// print_r($property_type);
			
			if (count($property_type) > 0) {
				foreach ($property_type as $key => $types) {
					?>
					<div class="form-group">
						<p><?php echo $property_label[$key] ?> <span class="impt">*</span></p>
						<?php
						// echo "<pre>";
						// print_r($types);
						$types =array('0' => 'Select') + $types  ;
					
						echo form_dropdown(str_replace(' ','_',$property_label_seo[$key]), $types);
						?>
					</div>
					<?php
				}
			}
			?>
			<div>
				<input type="hidden" name="latitude" id="latitude">
				<input type="hidden" name="longitude" id="longitude">
				<input type="hidden" name="city" id="city">
				<input type="hidden" name="state" id="state">
				<input type="hidden" name="country" id="country">
				<input type="hidden" name="post_code" id="post_code">
				<input type="hidden" name="street_address" id="route">
			</div>
			<div class="clear text-right btn__center">

			<?php
			if ($this->lang->line('Continue') != '') {
				$continue= stripslashes($this->lang->line('Continue'));
			} else
				$continue= "Continue";
			?>

				<?php
				$listspacesubmit = array('id' => 'list_submit', 'class' => 'submitBtn1');
				echo form_submit('list_submit', "$continue", $listspacesubmit);
				?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<div class="rightBlock">
		<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
			<?php
			if ($this->lang->line('greatsummary') != '') {
				echo stripslashes($this->lang->line('greatsummary'));
			} else
				echo "A great summary";
			?></h2>
		<p>
			<?php
			if ($this->lang->line('Agreattitleisunique') != '') {
				echo stripslashes($this->lang->line('Agreattitleisunique'));
			} else
				echo "A great summary is rich and exciting! It should cover the major features of your space and neighborhood in 250 characters or less.";
			?>
		</p>
		<p><strong>
				<?php
				if ($this->lang->line('example') != '') {
					echo stripslashes($this->lang->line('example'));
				} else
					echo "Example:";
				?>
			</strong>
		<p>
			<?php
			if ($this->lang->line('Ourcooland2') != '') {
				echo stripslashes($this->lang->line('Ourcooland2'));
			} else
				echo "Our Cool And Comfortable One Bedroom Apartment With Exposed Brick Has A True City Feeling!";
			?></p>
		<p>
			<?php
			if ($this->lang->line('Ourcooland3') != '') {
				echo stripslashes($this->lang->line('Ourcooland3'));
			} else
				echo "It Comfortably Fits Two And Is Centrally Located On A Quiet Street,
				Just Two Blocks From Washington Park.";
			?></p>
		<p>
			<?php
			if ($this->lang->line('Ourcooland4') != '') {
				echo stripslashes($this->lang->line('Ourcooland4'));
			} else
				echo "Enjoy A Gourmet Kitchen, Roof Access, And Easy Access To All Major Subway Lines!";
			?></p>
	</div>
	<i class="fa fa-lightbulb-o toggleNotes" aria-hidden="true"></i>
</div>
<!-- script for location auto complete -->
<script type="text/javascript">
	var componentForm = {
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'long_name',
		country: 'long_name',
		postal_code: 'short_name'
	};
	function initialize() {
		autocomplete = new google.maps.places.Autocomplete(
			(document.getElementById('autocomplete1')), {
				types: ['geocode']
			});
		autocomplete.addListener('place_changed', fillInAddress);
	}

	initialize();
</script>
<!-- script to validate list_space form -->
<script type="text/javascript">
setTimeout(function() { $("#flash_err").hide(); }, 3000);

	function checkSelect() {
		$('.loading').show();
		var Room_Type = $('select[name="roomtype"]').val();
		var Property_Type = $('select[name="propertytype"]').val();
		
		var city = $("#autocomplete1").val();
		if (city == null || city == "") {
			$('.loading').hide();
			document.getElementById("errordisplay").style.display = "block";
			document.getElementById("danger").innerHTML = "<?php if ($this->lang->line('exp_fill_all') != '') {
				echo stripslashes($this->lang->line('exp_fill_all'));
			} else echo "Please fill all fields"; ?>";
			setTimeout(function () {
				document.getElementById("danger").innerHTML = "";
				document.getElementById("errordisplay").style.display = "none";
			}, 2000);
			return false;
		}
		else if(Room_Type == '0' || Property_Type == '0'){
				$('.loading').hide();
			document.getElementById("errordisplay").style.display = "block";
			document.getElementById("danger").innerHTML = "<?php if ($this->lang->line('exp_fill_all') != '') {
				echo stripslashes($this->lang->line('exp_fill_all'));
			} else echo "Please fill all fields"; ?>";
			setTimeout(function () {
				document.getElementById("danger").innerHTML = "";
				document.getElementById("errordisplay").style.display = "none";
			}, 2000);
			return false;
		}
		else {
			document.getElementById("danger").innerHTML = "";
			document.getElementById("errordisplay").style.display = "none";
			$('#contact_form').submit();

		}
	}
</script>
