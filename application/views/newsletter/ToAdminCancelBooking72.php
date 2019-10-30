<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div style="margin: 30px auto; max-width: 65%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.5; font-size: 18px;"><img style="width: 120px;" src="<?php echo  base_url(); ?>images/logo/<?php echo $logo; ?>" alt="" />
<h1 style="font-size: 20px;"><span>Hi <strong>Admin</strong></span><strong><label>,</label></strong></h1>
<div style="margin-bottom: 10px; color: #484848; font-size: 16px;">The <strong>Host <?php echo $host_name ; ?></strong> is Cancelled Guest's <strong>($guest_name; ; ?> </strong>Property Reservation.The Reason is we have mentioned below..</div>
<div class="p ">
<div class="btn btn-primary space1" style="margin-bottom: 10px; color: #484848; font-size: 16px;"><strong>Property </strong>: <?php echo $prd_title; ?>&nbsp;&nbsp;</div>
<div class="btn btn-primary space1" style="margin-bottom: 10px; color: #484848; font-size: 16px;"><strong>Reason</strong>: <?php echo $reason; ?>&nbsp;&nbsp;</div>
<div class="btn btn-primary space1" style="margin-bottom: 10px; color: #484848; font-size: 16px;"><strong>Booking No</strong>: <?php echo $booking_no; ?> &nbsp;&nbsp;</div>
</div>
<div class="smallHorizontal" style="width: 70px; height: 1px; background-color: #cacaca; margin: 15px 0;">&nbsp;</div>
<p style="color: #484848; font-size: 14px;">Thanks for your patience!</p>
<p style="color: #484848; font-size: 14px;">The <?php echo  $email_title; ?> Team</p>
</div></body></html>