<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#fff">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="5" cellpadding="5" width="600" align="center">
<tbody>
<tr>
<td align="left"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="logo" width="130" /></td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">Dear <?php echo $hostname; ?>,</td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">Congratulations!!</td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">You have a New Reservation Request from <?php echo $travellername; ?>.</td>
</tr>
<tr>
<td align="center" valign="top"><?php echo $travellername; ?> have booked your Property for the dates <?php echo $checkindate; ?> to&nbsp;<?php echo $checkoutdate; ?></td>
</tr>
<tr>
<td align="center" valign="top">Find the details of your reservations below:</td>
</tr>
<tr>
<td align="center">Based on your price of <?php echo $currencySymbol; ?><?php echo $price; ?> per day, including with CarRental fees, your potential payout for this booking is&nbsp;<?php echo $currencySymbol; ?><?php echo $totalprice; ?>.</td>
</tr>
<tr>
<td align="center" valign="middle">Please Accept/Decline the reservation request by clicking on the buttons below:</td>
</tr>
<tr>
<td align="center" valign="middle">
<div><a href="<?php echo base_url(); ?><?php echo $message_link; ?>">Accept</a> / <a href="<?php echo base_url(); ?><?php echo $message_link; ?>">Decline</a></div>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="5" cellpadding="5" width="100%" align="center">
<tbody>
<tr>
<td align="center" valign="top">
<p>Reservation Request</p>
<table style="margin-bottom: 20px;" border="0" cellspacing="5" cellpadding="5" width="100%" bgcolor="#EAEAEA">
<tbody>
<tr>
<th width="75">Time</th> <th width="75">Date</th>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Arrive</td>
<td bgcolor="#FFFFFF"><?php echo $checkindate; ?></td>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Depart</td>
<td bgcolor="#FFFFFF"><?php echo $checkoutdate; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td align="left" valign="middle">The passenger <?php echo $travellername; ?> will be happy to get a prompt response from you.</td>
</tr>
<tr>
<td align="left" valign="middle">In case of any query or help, please visit: [Email protected]</td>
</tr>
<tr>
<td align="left" valign="middle">
<p>Or</p>
<p>Contact us either through phone or email</p>
<p>Email ID:</p>
<p>Contact Number:</p>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<p>Thanks &amp; Regards!</p>
<p>The Homestay DNN &amp; Team</p>
</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td height="50">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div></body></html>