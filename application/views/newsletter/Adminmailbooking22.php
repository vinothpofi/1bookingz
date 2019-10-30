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
<td align="left"><img style="margin: 15px 5px 0; padding: 10px; border: none;" src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="<?php echo $meta_title; ?>" width="130" /></td>
</tr>
<tr>
<td class="editable" style="color: #ffffff; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px 20px; background-color: #a61d55;" align="center" valign="middle">Hi Admin</td>
</tr>
<tr>
<td style="color: #000; padding: 10px 20px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center">We're excited to tell you that <?php echo $first_name; ?> <?php echo $last_name; ?> just booked <?php echo $rental_name; ?> with <?php echo $renter_fname; ?> <?php echo $renter_lname; ?></td>
</tr>
<tr>
<td style="color: #000; padding: 10px 10px; font-weight: bold; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center" valign="top">Itinerary</td>
</tr>
<tr>
<td align="center" valign="middle">
<div style="background-color: #a61d55; display: table; border-radius: 5px; color: #ffffff; font-family: Open Sans, Arial, sans-serif; font-size: 13px; text-transform: uppercase; font-weight: bold; padding: 7px 12px; text-align: center; text-decoration: none; width: 140px; margin: auto;"><a style="color: #ffffff; text-decoration: none;" href="<?php echo base_url(); ?>/rental/<?php echo $prd_id; ?>"><img src="<?php echo $rental_image; ?>" alt="" width="300" /> <?php echo $rental_name; ?></a></div>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr style="padding: 10px; float: left;">
<td align="center" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="600" bgcolor="#EAEAEA">
<tbody style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;">
<tr>
<th width="75">Time</th> <th width="75">Date</th>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Arrive</td>
<td bgcolor="#FFFFFF"><?php echo $checkin; ?></td>
</tr>
<tr align="center">
<td bgcolor="#FFFFFF">Depart</td>
<td bgcolor="#FFFFFF"><?php echo $checkout; ?></td>
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
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr style="padding: 10px; float: left;">
<td align="center" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="600">
<tbody style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;">
<tr>
<th align="left">Guest</th>
</tr>
<tr bgcolor="#EAEAEA">
<td width="150px"><img src="<?php echo $user_image; ?>" alt="" width="161px" /></td>
<td>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tbody>
<tr>
<td style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; padding: 5px 0px;"><?php echo $first_name; ?> <?php echo $last_name; ?></td>
</tr>
<tr>
<td style="font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; padding: 5px 0px;"><?php echo $ph_no; ?></td>
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
</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td style="color: #4f595b; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px; line-height: 20px; padding: 0px 20px;" width="300px" align="left" valign="top">
<table style="width: 100%; font-size: 13px;">
<tbody>
<tr>
<td style="border-bottom: 1px solid #bbb;"><?php echo $currency_symbol; ?> <?php echo $currency_price; ?>*<?php echo $days; ?> Night</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 5px 0px;">
<p><?php echo $currency_symbol; ?><?php echo $currency_amount; ?> <?php echo $currency_type; ?></p>
</td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb;">Security Deposit</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 5px 0px;"><?php echo $currency_symbol; ?><?php echo $securityDeposite; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb;">Service Fee</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 5px 0px;"><?php echo $currency_symbol; ?><?php echo $currency_serviceFee; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">Total</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $currency_symbol; ?><?php echo $currency_netamount; ?> <?php echo $currency_type; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
<tr>
<td style="padding: 0px 20px; color: #444444; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="left" valign="middle">
<p>Thanks!</p>
<p>The HomeStayDNN Team</p>
</td>
</tr>
<tr>
<td height="30">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></body></html>