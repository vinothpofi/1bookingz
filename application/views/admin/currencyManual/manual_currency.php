<?php
$this->load->view('admin/templates/header.php');
?>
<style>
.left_label ul li label.field_title {
    width: 8%;
}
.left_label ul li .form_input {
    margin-left: 8%;
}
.hyperlinkBtn{
    font: bold 13px Arial;
    text-decoration: none !important;
    background-color: #a61d55;
    color: #FFF !important;
    padding: 5px 6px 5px 6px;
    border-top: 1px solid #CCCCCC;
    border-right: 1px solid #333333;
    border-bottom: 1px solid #333333;
    border-left: 1px solid #CCCCCC;
    float: right;
	margin-right:5px;
}
</style>
<?php
$currencyStatus = $manualStatus->manual_currency_status;
if($currencyStatus==0) { $checkedStatus='';} else { $currencyStatus='checked';}
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span><h6><?php echo $heading;?></h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'addslider_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
						echo form_open_multipart($action, $attributes)
						?>
							<ul>
								<!-- <li>
									<a href="<?php echo base_url().'admin/currencyManual/apiCurrencyFun/admin_update';?>" class="hyperlinkBtn"> Go and update from live</a>
								</li> -->
								<li id="dynamicCurrencyDis"><!--<img src="<?php echo base_url().'assets/img/loader.gif';?>" id="loaderImage" style="display:none" />--><?php echo $table;?></li>

								<li>
									<div class="form_grid_12">
											<div class="form_input">
											<?php
											echo form_input([
											'type'     => 'submit',
											'value'    => 'Submit',
											'tabindex' => '9',
											'class'    => 'btn_small btn_blue'
											]);	
											?>
										</div>
									</div>
								</li>
							</ul>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>

<script>
	$('#addslider_form').validate();
</script>

<!--
<script type="text/javascript">
	$('#active_inactive_active').iphoneStyle({
		onChange: function(elem, data) {
			var checkedStatus=data;
			if(checkedStatus==true)
			{
				$.ajax({
					type: "POST",
					async: false,
					url: "<?php echo base_url();?>admin/currencyManual/getPriceDet",
					data: {'manual_currency_status': checkedStatus},
					beforeSend:function(){
						$('#loaderImage').show();
					},
					success: function (msg) {
						$('#loaderImage').hide();
						$('#dynamicCurrencyDis').html(msg);
					}
				});
				
			}
			else
			{
				$('#dynamicCurrencyDis').html('');
			}
			/*
			if(checkedStatus==true)
			{
				
			}*/
		},
		checkedLabel: 'YES',
		uncheckedLabel: 'NO'
	});
</script>
-->
<script>
$(function() {
	$('.data_table').dataTable({   
	"bPaginate": false,
    "bLengthChange": false,
	"bFilter": false,
	"sPaginationType": "full_numbers",
	"iDisplayLength": 0,
	"oLanguage": {"sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",},
	"sDom": '<"table_top"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>'
	});
});
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>

