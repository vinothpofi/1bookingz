<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div class="container" style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<div><img style="width: 120px;" src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="" />&nbsp;&nbsp;</div>
<div>
<h1 style="font-size: 20px;"><span>Hi </span><?php echo $username; ?>,</h1>
<p>Welcome to <strong>HomeStayDnn!</strong>. Please <strong>confirm</strong> your email to get started.</p>
<div class="p">
<p class="btn btn-primary space1"><strong>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> : <?php echo $email; ?>&nbsp;&nbsp;</p>
<p class="btn btn-primary space1"><strong>Password</strong> : <?php echo $password; ?>&nbsp;&nbsp;</p>
<p class="btn btn-primary space1"><strong>Rep Code</strong> : <?php echo $repcode; ?>&nbsp;&nbsp;</p>
</div>
<div class="smallHorizontal" style="width: 70px; height: 1px; background-color: #cacaca; margin: 15px 0;">&nbsp;</div>
<p style="color: #484848; font-size: 14px;">Thanks for your patience!</p>
<p style="color: #484848; font-size: 14px;">The <?php echo $email_title; ?> Team</p>
</div>
</div></body></html>