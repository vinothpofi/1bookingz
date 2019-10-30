	<?php
		if ($hostDetails->num_rows() > 0) {
			?>
			<select name="product_id[]" multiple id="property">
				<?php
				foreach ($hostDetails->result() as $host) {
					$hostid = $host->id;

					if ($productDetails[$hostid]->num_rows() > 0) {

						?>
						<optgroup
								label="<?php echo $host->firstname . ' ' . $host->lastname; ?>">
							<?php
							//print_r($productDetails[$hostid]->result());exit;
							foreach ($productDetails[$hostid]->result() as $product) {
								if(!in_array($product->id,$cproduct)){
								?>
								<option
										 value="<?php echo $product->id; ?>"><?php echo $product->product_title . ' ' . $product->city . ',' . $product->state; ?></option>
								<?php
							} }
							?>
						</optgroup>
						<?php
					}
				}
				?>
			</select>
			<?php
		} 
		?>
		
<link href="<?php echo base_url(); ?>js/multipleSelect/jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>js/multipleSelect/jquery.multiselect.js"></script>
<script>
    $('#property').multiselect({
        columns: 4,
        placeholder: 'Select Property',
        search: true,
        selectAll: true
    });
</script>