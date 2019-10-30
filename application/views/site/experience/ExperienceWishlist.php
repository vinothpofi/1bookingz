<div class="col-md-6 contactLeft">
	<h1><?php echo ucfirst($productList->row()->experience_title); ?></h1>
	<h5><?php
		echo ($productList->row()->CityName != "") ? $productList->row()->CityName . ', ' : '';
		echo ($productList->row()->State_name != "") ? $productList->row()->State_name . ', ' : '';
		echo ($productList->row()->Country_name != "") ? $productList->row()->Country_name . '. ' : '';
		?></h5>
	<p class="space"><?php if ($this->lang->line('Create New List') != '') {
			echo stripslashes($this->lang->line('Create New List'));
		} else echo "Create New List"; ?></p>
	<p class="text-danger text-center" id="wishlist_warn"></p>
	<?php
	if ($this->lang->line('Create') != '') {
		$wishListBtn = stripslashes($this->lang->line('Create'));
	} else $wishListBtn = "Create";
	echo form_input('list_name', '', array('id' => 'list_name', 'placeholder' => 'Wishlist category name', 'class' => 'createList'));
	echo form_button('createWL', $wishListBtn, array('onclick' => 'return CreateWishListCat();', 'class' => 'submitBtn'));
	?>
</div>
<div class="col-md-6 contactRight">
	<?php
	echo form_open_multipart('site/experience/AddToWishList');
	echo form_input(array('id' => 'pid', 'name' => 'rental_id', 'type' => 'hidden', 'value' => $productList->row()->id));
	?>
	<div class="detailRight">
		<h5><?php if ($this->lang->line('header_add_list') != '') {
				echo stripslashes($this->lang->line('header_add_list'));
			} else echo "Add to List"; ?></h5>
		<div>
			<p class="text-center text-danger" id="No-Checkbox-checked"></p>
			<ul id="WishListUl">
				<?php
				if (count($WishListCat->result()) > 0) {
					foreach ($WishListCat->result() as $wishlist) {
						$WishRentalsArr = explode(',', $wishlist->product_id);
						?>
						<li><label>
								<span class="checkboxStyle">
									<input type="checkbox" class="messageCheckbox hideTemp" name="wishlist_cat[]"
										  value="<?php echo $wishlist->id; ?>"
										  <?php if (in_array($productList->row()->id, $WishRentalsArr)){ ?>checked="checked" <?php } ?> />
								<i class="fa fa-check"></i>
                                      </span>
                                      <?php echo $wishlist->name; ?>
							</label>
						</li>
					<?php }
				}
				?>
			</ul>
		</div>
		<div class="msgHost">
			<h5><?php if ($this->lang->line('Add Notes') != '') {
					echo stripslashes($this->lang->line('Add Notes'));
				} else echo "Add Notes"; ?></h5>
			<?php
			echo form_hidden('nid', $notesAdded->row()->id, array('id' => 'nid'));
			$notes = "";
			if (count($notesAdded->result()) == 1) {
				$notes = $notesAdded->row()->notes;
			}
			echo form_textarea('add-notes', $notes, array('placeholder' => 'Add notes', 'rows' => 4)); ?>
		</div>
		

		<button type="submit" name="submit" onclick="return validate();" class="submitBtn"><i id="spin" style="display: none;" class="fa fa-spinner fa-spin"></i>Add</button>
	</div>
	<?php echo form_close(); ?>
</div>
</div>
<script type="text/javascript">
	function validate() {
		$('#spin').show();
		var checkedValue = $('.messageCheckbox:checked').val();
		if (!checkedValue) {
			$('#spin').hide();
			$("#No-Checkbox-checked").html("<?php if ($this->lang->line('please_Choose_Wishlist_Name') != '') {
				echo stripslashes($this->lang->line('please_Choose_Wishlist_Name'));
			} else echo "please Choose Wishlist Name";?>");
			return false;
		}
		else {
			$("#No-Checkbox-checked").html("");
			return true;
		}
	}

	function CreateWishListCat() {
		var rental_id = $("#pid").val();
		var list_name = $("#list_name").val();
		if (list_name == "") {
			$("#wishlist_warn").html("<?php if ($this->lang->line('Please_enter_wishlist_category') != '') {
				echo stripslashes($this->lang->line('Please_enter_wishlist_category'));
			} else echo "Please enter wishlist category";?>.");
			return false;
		} else {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>site/rentals/rentalwishlistcategoryAdd',
				data: {"list_name": list_name, "rental_id": rental_id},
				dataType: 'json',
				success: function (json) {
					if (json.result == '0') {
						$('#WishListUl').prepend(json.wlist);
						$("#wishlist_warn").html("");
					}
					if (json.result == '1') {
						$("#wishlist_warn").html("<?php if ($this->lang->line('This_category_already_exists') != '') {
							echo stripslashes($this->lang->line('This_category_already_exists'));
						} else echo "This category already exists";?>.");
					}
					return false;
				}
			});
		}
		return false;
	}
</script>
