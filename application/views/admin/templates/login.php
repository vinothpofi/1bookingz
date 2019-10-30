<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width"/>
	<base href="<?php echo base_url(); ?>">
	<title><?php echo $title; ?></title>
	<!-- css -->
	<link href="<?php echo base_url(); ?>css/admin/reset.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/admin/typography.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/admin/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/admin/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/admin/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/admin/gradient.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>css/admin/developer.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>css/admin/admin-responsive.css"/>
	<!-- Jquery scripts -->
	<script src="<?php echo base_url(); ?>js/admin/jquery-1.7.1.min.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/jquery-ui-1.8.18.custom.min.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/chosen.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/uniform.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/jquery.tagsinput.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/jquery.cleditor.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/jquery.jBreadCrumb.1.1.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/accordion.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/autogrow.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/duallist.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/input-limiter.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/inputmask.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/iphone-style-checkbox.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/raty.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/stepy.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/vaidation.jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/jquery.collapse.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/bootstrap-dropdown.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/bootstrap-colorpicker.js"></script>
	<script src="<?php echo base_url(); ?>js/admin/jquery.tipsy.js"></script>

	<script type="text/javascript">
		function hideErrDiv(arg) {
			document.getElementById(arg).style.display = 'none';
		}
	</script>

	<script>
		/*Function for forget password*/
		window.addEventListener('load',
			function () {
				if (localStorage.chkbx && localStorage.chkbx != '') {
					$('#remember_me_chk').attr('checked', 'checked');
					$('#admin_name_id').val(localStorage.usrname);
					$('#admin_password_id').val(localStorage.pass);
				}
				else {
					$('#remember_me_chk').removeAttr('checked');
					$('#admin_name_id').val('');
					$('#admin_password_id').val('');
				}

				$('#remember_me_chk').click(function () {
					if ($('#remember_me_chk').is(':checked')) {
						/*save uname and password in local storage*/
						localStorage.usrname = $('#admin_name_id').val();
						localStorage.pass = $('#admin_password_id').val();
						localStorage.chkbx = $('#remember_me_chk').val();
					}
					else {
						localStorage.usrname = '';
						localStorage.pass = '';
						localStorage.chkbx = '';
					}
				});

			}, false);
	</script>
</head>

<body id="theme-default" class="full_block">
<div id="login_page"
	 style='background:url("images/logo/<?php echo $this->config->item('background_image');?>") repeat scroll 0 0 / cover rgba(0, 0, 0, 0)'>
	<div class="login_container">
		<div class="login_header blue_lgel">
			<ul class="login_branding">
				<li>
					<div class="logo_small">
						<img src="images/logo/<?php echo $this->config->item('logo_image');?>">
					</div>
					<span></span>
				</li>
			</ul>
		</div>
		<?php
		if (validation_errors() != '') {
			?>
			<div id="validationErr">
				<script>setTimeout("hideErrDiv('validationErr')", 10000);</script>
				<p><?php echo validation_errors(); ?></p>
			</div>
		<?php }
		if ($flash_data != '') { ?>
			<div class="errorContainer" id="<?php echo $flash_data_type; ?>">
				<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 10000);</script>
				<p><span><?php echo $flash_data; ?></span></p>
			</div>
		<?php }
		$form_attr = array('id'=>'admin_form');
		echo form_open('admin/adminlogin/admin_login',$form_attr);
		if (!$this->data['demoserverChk']) { ?>
			<div class="login_form">
				<ul>
					<li class="login_user tipBot" title="Please enter your username">
						<?php
						echo form_label('Username:', 'Username');
						$adminnameattr = array(
							'name' => 'admin_name',
							'id' => 'admin_name_id',
							'class' => 'login-scroll',
							'style' => 'border: 1px solid #b9b2b2;',
							'autocomplete' => 'off'
						);
						echo form_input($adminnameattr);
						?>
					</li>
					<p style="color: #ffc21f;margin-left: 18px;" id="uname_err"></p>
					<li class="login_pass tipTop" title="Please enter your password">
						<?php
						echo form_label('Password:', 'Password');
						$adminpwsattr = array(
							'name' => 'admin_password',
							'id' => 'admin_password_id',
							'class' => 'login-scroll',
							'style' => 'border: 1px solid #b9b2b2;',
							'autocomplete' => 'off'
						);
						echo form_password($adminpwsattr);
						?>
					</li>
					<p style="color: #ffc21f;margin-left: 18px;" id="pwd_err"></p>
				</ul>
			</div>

			<ul class="login_opt_link">
				<li class="remember_me tipBot" title="Select to remember your password upto one day">
					<?php
					$rememberattr = array(
						'name' => 'remember',
						'id' => 'remember_me_chk',
						'class' => 'rem_me'
					);
					echo form_checkbox($rememberattr);
					?>
					Remember Me
					<!--onclick="setInLocal()"  -->
				</li>
				<li class="right"><a href="admin/adminlogin/admin_forgot_password_form" class="tipLeft"
									 title="Click to reset a new password">Forgot Password?</a></li>
			</ul>
			<center>
				<?php
				$rememberattr = array(
					'value' => 'Login',
					'class' => 'log-butt'
				);
				echo form_submit($rememberattr);
				?>
			
			</center>
			<?php
		} else { ?>
			<div class="login_form">
				<h3 class="blue_d">Admin Login</h3>
				<ul>
					<li class="login_user tipBot" title="Please enter your username">
						<?php
						$admnnmeattr = array(
							'name' => 'admin_name'
						);
						echo form_input($admnnmeattr);
						?>
					</li>
					<li class="login_pass tipTop" title="Please enter your password">
						<?php
						$admnpswattr = array(
							'name' => 'admin_password'
						);
						echo form_password($admnpswattr);
						?>
					</li>
				</ul>
			</div>
			<?php
			$admnpswattr = array(
				'value' => 'Login',
				'class' => 'login_btn blue_lgel'
			);
			echo form_submit($admnpswattr);

			?>

			<ul class="login_opt_link">
				<li class="remember_me right tipBot" title="Select to remember your password upto one day">
					<?php
					$adminrmbrattr = array(
						'name' => 'remember',
						'value' => 'checked',
						'class' => 'rem_me'
					);
					echo form_checkbox($adminrmbrattr);
					?>
					Remember Me
				</li>
			</ul>
			<span style="background-color: rgb(255, 255, 255); float: left; text-align: center;">Due to security reasons site main configuration like payment settings, configuration settings is disabled in demo login</span>
		<?php }
		echo form_close(); ?>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
	$("#admin_form").submit(function(e) {
    $('#uname_err').html('');
		$('#pwd_err').html('');
		var admin_name = $('#admin_name_id').val();
		var admin_password = $('#admin_password_id').val();
		if(admin_name == ''){
			$('#uname_err').html('Please Enter Username');return false;
			e.preventDefault();
		} else if(admin_password == '') {
			$('#pwd_err').html('Please Enter Password');return false;
			e.preventDefault();
		}else {
			$('#admin_form').submit();
		}
});
</script>