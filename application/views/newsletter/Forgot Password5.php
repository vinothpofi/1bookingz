<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div class="container" style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table border="0" width="100%">
<tbody>
<tr>
<td>
<table border="0" width="100%">
<tbody>
<tr>
<td><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="<?php echo $meta_title; ?>" width="110" /></a></td>
</tr>
<tr>
<td valign="top">
<table border="0" bgcolor="#FFFFFF">
<tbody>
<tr>
<td colspan="2">
<!--<h3>Here's Your New Password</h3>-->
<p style="margin-bottom: 10px;">You recently requested to reset your password</p>
</td>
</tr>
<tr>
<td valign="top" colspan="2">
<p><strong>Here's Your New Password :</strong> <?php echo $pwd; ?></p>
<p>You can login using above password and change your password immediately.</p>
<p>&nbsp;</p>
<p>Thanks,</p>
<div class="p "><!--<span>Sent with&nbsp;</span>--><span><!--from--> <?php echo $email_title; ?> Team<!--HQ--></span></div>
<p>&nbsp;</p>
</td>

</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div></body></html>