<?php
$this->load->view('site/includes/header');
?>
<style>
	.backgr {
		background: rgba(49, 48, 48, 0.8);
		padding: 15px;
		border-radius: 4px;
		margin-bottom: 24px;
	}
	.Text-white{
		color: #ffffff !important;
	}
	/*only for this page*/
	footer{
		margin-top: 0px;
	}
</style>
<section style="background-size:cover;background: url('<?= base_url(); ?>images/background.jpg');">
	<div class="container Text-white">
		<div class="row">
			<h2><?php if ($this->lang->line('Contact Us') != '') {
					echo stripslashes($this->lang->line('Contact Us'));
				} else echo "Contact Us"; ?></h2>
			<div class="col-md-6 backgr">
				<?php
				echo form_open('site/cms/contactus', array('id' => 'form'));
				?>
				<div class="form-group">
					<label for="name"><?php if ($this->lang->line('Your Name') != '') {
							echo stripslashes($this->lang->line('Your Name'));
						} else echo "Your Name"; ?>:</label>
					<input type="text" placeholder="<?php if ($this->lang->line('Your Name') != '') {
						echo stripslashes($this->lang->line('Your Name'));
					} else echo "Your Name"; ?>" value="<?= ($loginCheck == '')?'':$userDetails->row()->user_name; ?>" class="form-control" name="name" id="name">
				</div>
				<div style="display:none;color:yellow;" id="name_required"><?php if ($this->lang->line('Full name required') != '') {
				echo stripslashes($this->lang->line('Full name required'));
			} else echo "Full name required";?></div>
				<div class="form-group">
					<label for="pwd"><?php if ($this->lang->line('Email') != '') {
							echo stripslashes($this->lang->line('Email'));
						} else echo "Email"; ?>:</label>
					<input type="email" placeholder="<?php if ($this->lang->line('Your@yourcompany.com') != '') {
						echo stripslashes($this->lang->line('Your@yourcompany.com'));
					} else echo "Your@yourcompany.com"; ?>" value="<?= ($loginCheck == '')?'':$userDetails->row()->email; ?>" class="form-control" id="contact_email" name="email">
				</div>
				<div style="display:none;color:yellow;" id="email_required"><?php if ($this->lang->line('Email required') != '') {
				echo stripslashes($this->lang->line('Email required'));
			   } else echo "Email required";?></div>
			   <div style="display:none;color:yellow;" id="valid_email_required"><?php if ($this->lang->line('valid_Email') != '') {
				echo stripslashes($this->lang->line('valid_Email'));
			   } else echo "Valid Email required";?></div>
			
				<div class="form-group">
					<label for="pwd"><?php if ($this->lang->line('Subject') != '') {
							echo stripslashes($this->lang->line('Subject'));
						} else echo "Subject"; ?>:</label>
					<input type="text" placeholder="<?php if ($this->lang->line('General Enquiry') != '') {
						echo stripslashes($this->lang->line('General Enquiry'));
					} else echo "General Enquiry"; ?>" value="" class="form-control" id="subject" name="subject">
				</div>
				<div style="display:none;color:yellow;" id="subject_required"><?php if ($this->lang->line('Subject required') != '') {
				echo stripslashes($this->lang->line('Subject required'));
			} else echo "Subject required";?></div>
			
				<div class="form-group">
					<label for="pwd"><?php if ($this->lang->line('Message') != '') {
							echo stripslashes($this->lang->line('Message'));
						} else echo "Message"; ?>:</label>
					<textarea placeholder="<?php if ($this->lang->line('Message') != '') {
						echo stripslashes($this->lang->line('Message'));
					} else echo "Message"; ?>" class="form-control cometchat_textarea" rows="5" id="msg" name="msg"></textarea>
				</div>
				<div style="display:none;color:yellow;" id="message_required"><?php if ($this->lang->line('Message required') != '') {
				echo stripslashes($this->lang->line('Message required'));
			} else echo "Message required";?></div>
			
				<div class="text-right clear">
					<input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d'); ?>">

					<input class="submitBtn" value="<?php if ($this->lang->line('Send') != '') {
							   echo stripslashes($this->lang->line('Send'));
						   } else echo "Send"; ?>" type="button" onclick="checkval();">
				</div><br><br>
				<?php
				echo form_close();
				?>
			</div>

			<div class="col-md-6 backgr">
				<div class="address-section">
					<div class="address-contained">
                        <div class="form-group">
                            <label for="pwd">Contact With Us</label>
                           <?php echo $this->config->item('contact_us_address'); ?>
                        </div>
						<!--<p>
							<?php /*echo $cmscontactus->row()->description; */?>
						</p>-->
					</div>
					<?php /*?> <div class="map-frame">
  <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3971.8742511119563!2d100.3114405!3d5.436062499999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sHunza+Tower%2CGurney+Paragon%2C+Jalan+Kelawai%2C10250%2C+Penang.!5e0!3m2!1sen!2sin!4v1417184761768" width="500" height="200" frameborder="0" style="border:0"></iframe>
  </div> */ ?>
					<ul class="social-side">
						<li><a href="<?php echo $this->config->item('facebook_link'); ?>" target="_blank"></a></li>
						<li><a class="g1" href="<?php echo $this->config->item('twitter_link'); ?>"
							   target="_blank"></a></li>
						<li><a class="g2" href="<?php echo $this->config->item('googleplus_link'); ?>"
							   target="_blank"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
$this->load->view('site/includes/footer');
?>
<script type="text/javascript">
	function checkval() { 
		var name = $('#name').val(); 
		var email = $('#contact_email').val();
		var subject = $('#subject').val();
		var date = $('#date').val();
		var msg = $('#msg').val();
		if (name == '') { 
			$('#name_required').show();

			/* boot_alert('<?php if ($this->lang->line('Full name required') != '') {
				echo stripslashes($this->lang->line('Full name required'));
			} else echo "Full name required";?>'); */
		} else {
			
			$('#name_required').hide();

		}

		if (email == '') {
			$('#email_required').show();
			
		} else {

			$('#email_required').hide();
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
  {
  	$('#valid_email_required').hide();
   
  }
  else
  {
  	
  	$('#valid_email_required').show();
    	
        return false;
  }
		}

 


		if (subject == '') {
			$('#subject_required').show();
			
		} else {
			$('#subject_required').hide();
		}



		if (msg == '') {
			$('#message_required').show();
			return false;
			/* boot_alert('<?php if ($this->lang->line('Message required') != '') {
				echo stripslashes($this->lang->line('Message required'));
			} else echo "Message required";?>'); */
		} else {
			$('#message_required').hide();
			
		}
		if (msg != '' && subject != '' && name != '' && email != '') {
			 $('.loading').show();
			$("#form").submit();
		}

	}

 
	/*$(function(){
	 
		$('.cometchat_textarea').keyup(function()
		{

			//re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
			re = /[.com @0-9^$]/gi;
			//re = /^([^com])[@0-9]$/gi;
			var isSplChar = re.test(yourInput);
			if(isSplChar)
			{
				//var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
				var no_spl_char = yourInput.replace(/[.com @0-9^$]/gi, '');
				//no_spl_char = yourInput.replace(/.com/gi,""); 
				$(this).val(no_spl_char);
			}
			//no_spl_char = yourInput.replace(/.com/gi,""); 
			//$(this).val(no_spl_char);
		});
	 
	}); */
 
 /*
     String.prototype.repeat = function(num){
      return new Array(num + 1).join(this);
    }

    var filter = ['ass', 'words'];

    $('.post').text(function(i, txt){

      // iterate over all words
      for(var i=0; i<filter.length; i++){

        // Create a regular expression and make it global
        var pattern = new RegExp('\\b' + filter[i] + '\\b', 'g');

        // Create a new string filled with '*'
        var replacement = '*'.repeat(filter[i].length);

        txt = txt.replace(pattern, replacement);
      }

      // returning txt will set the new text value for the current element
      return txt;
    });
 */

</script>
