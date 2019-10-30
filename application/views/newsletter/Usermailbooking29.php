<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body><div style="margin: 30px auto; max-width: 70%; font-family: 'Circular',Helvetica,Arial,sans-serif; color: #484848; line-height: 1.4; font-size: 18px;">
<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td>
<table class="devicewidth" align="left">
<tbody>
<tr>
<td align="left"><img style="margin-bottom: 10px;" src="<?php echo base_url(); ?>images/logo/<?php echo $logo; ?>" alt="<?php echo $meta_title; ?>" width="120" /></td>
</tr>
<tr>
<td class="editable" align="left" valign="middle">
<h1 style="font-size: 20px; text-align: left;">Hi <?php echo $first_name; ?> <?php echo $last_name; ?></h1>
</td>
</tr>
<tr>
<td align="left">
<p style="margin-bottom: 10px; color: #484848; font-size: 16px;">We're excited to tell you that <?php echo $rental_name; ?> is booked now.To make check-in seamless, we have suggest you to continue the conversation with <?php echo $renter_fname; ?> <?php echo $renter_lname; ?></p>
</td>
</tr>
<tr>
<td align="left">
<p style="margin-bottom: 10px; color: #484848; font-size: 16px;">through HomestayDnn message system to confirm their arrival time, ask any questions you may have, and help them figure out how to best get to your listing.</p>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top">
<h1 style="font-size: 20px;">Itinerary</h1>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<div><a href="http://airbnb.zoplay.com/rental/<?php echo $prd_id; ?>"> <img style="display: block; margin-bottom: 10px;" src="<?php echo $rental_image; ?>" alt="" width="300" /> <?php echo $rental_name; ?></a></div>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="left">
<table width="100%" align="left">
<tbody>
<tr>
<td align="left" valign="top">
<table border="0" width="100%">
<tbody>
<tr>
<th align="left">Time</th> <th align="left">Date</th>
</tr>
<tr align="left">
<td bgcolor="#FFFFFF">Arrive</td>
<td bgcolor="#FFFFFF"><?php echo $checkin; ?></td>
</tr>
<tr align="left">
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
<td>&nbsp;</td>
</tr>
<tr>
<td align="left">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td align="left" valign="top">
<table border="0" cellspacing="1" cellpadding="5" width="100%">
<tbody>
<tr>
<th align="left">Your Renter</th>
</tr>
<tr>
<td width="150px"><img src="<?php echo $renter_image; ?>" alt="" width="140px" /></td>
<td>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
<tbody>
<tr>
<td><?php echo $renter_fname; ?> <?php echo $renter_lname; ?></td>
</tr>
<tr>
<td><?php echo $ph_no; ?></td>
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
<td align="left">
<h1 style="font-size: 20px;">Payment</h1>
</td>
</tr>
<tr>
<td>
<p style="margin-bottom: 10px; color: #484848; font-size: 16px;">On the day after the guest checks in, the payout method you supplied will be credited. For details, see your Transaction History.</p>
</td>
</tr>
<tr>
<td align="left">Cancellation Policy</td>
</tr>
<tr>
<td>
<p style="margin-bottom: 10px; color: #484848; font-size: 16px;"><?php echo $cancel_policy_type; ?>: <?php echo $cancel_policy; ?></p>
</td>
</tr>
<tr>
<td align="left" valign="top">
<table>
<tbody>
<tr>
<td style="border-bottom: 1px solid #bbb;">Bookingno: <?php echo $booking_no; ?></td>
</tr>
<tr>
<td align="left" valign="top">
<table>
<tbody>
<tr>
<td style="border-bottom: 1px solid #bbb;"><?php echo $guestCurrencySymbol; ?> <?php echo $guestSingleNight; ?>*<?php echo $days; ?> Night</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">
<p><?php echo $guestCurrencySymbol; ?><?php echo $guestSubTot; ?> <?php echo $currency_type; ?></p>
</td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb;">Service Fee</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $guestCurrencySymbol; ?><?php echo $guestServ_fee_is; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb;">Security Deposit</td>
<td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $guestCurrencySymbol; ?><?php echo $guestSecDep; ?><?php echo $currency_type; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">Total</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;">&nbsp;</td>
<td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><?php echo $guestCurrencySymbol; ?><?php echo $netamount; ?> <?php echo $currency_type; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<div class="smallHorizontal" style="width: 70px; height: 1px; background-color: #cacaca; margin: 15px 0;">&nbsp;</div>
<p style="color: #484848; font-size: 14px;">Thanks for your patience!</p>
<p style="color: #484848; font-size: 14px;">The <?php echo $email_title; ?> Team</p>
</td>
</tr>
<tr>
<td align="left">&nbsp;</td>
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