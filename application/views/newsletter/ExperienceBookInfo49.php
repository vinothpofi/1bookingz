<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body>
<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td>
<table class="devicewidth" border="0" cellspacing="0" cellpadding="0" width="600" align="center">
<tbody>
<tr>
<td align="left"><img src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="logo" width="130" /></td>
</tr>
<tr>
<td class="editable" align="center" valign="middle">GREAT NEWS! YOU HAVE A BOOKING REQUEST FROM <?php echo $TRAVELLERNAME; ?>.</td>
</tr>
<tr>
<td align="center" valign="top"><?php echo $travellername; ?> would like to experience at (<?php echo $productname;?>) from <?php echo $checkindate; ?> through <?php echo $checkoutdate; ?></td>
</tr>
<tr>
<td align="center">Based on your rate of <?php echo $currencySymbol.' '.$price; ?> per person along with&nbsp;Homestay fees, your potential payout for this booking is <?php echo $currencySymbol.' '.$totalprice; ?>.</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td align="center" valign="top">
<p>Booking Request</p>
<table border="0" cellspacing="1" cellpadding="5" width="600" bgcolor="#EAEAEA">
<tbody>
<tr>
<th width="75">Time</th><th width="75">Date</th>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Start Date</td>
<td bgcolor="#FFFFFF"><?php echo $checkindate; ?></td>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">End Date</td>
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
<td align="left" valign="middle"><?php echo $travellername; ?>'s booking request will confirm automatically.&nbsp;Please have a note on it. You can contact guest by your inbox for further communicatin.</td>
</tr>
<tr>
<td align="left" valign="middle">We appreciate your responce as quickly as possible so your guest can begin to plan their experience!</td>
</tr>
<tr>
<td align="center" valign="middle"><a href="#">(Remember: Not responding to this booking will result in your listing being ranked lower.)</a></td>
</tr>
<tr>
<th align="center" valign="middle">If you need help or have any questions, please visit&nbsp;<a href="#"><span class="__cf_email__">[email&nbsp;protected]</span></a></th>
</tr>
<tr>
<td align="left" valign="middle">
<p style="margin-top: 20px;">Thanks!</p>
<p>The HomestayDnn Team</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></body></html>