<?php
$data = '';
$title = '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' User Details</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	<th>S.No</th>
        <th>First Name</th>       
        <th>Last Name</th>      
        <th>login UserType</th>  
        <th>Email-ID</th>
		<th>User Created On</th>
		<th>Last Login Date</th>
		<th>Last Login IP</th>
		<th>Status</th>

    </tr>';
    $sno = 1;
foreach ($users_detail as $myrow) 
{
	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
        <td style="text-align:left">' . ucfirst($myrow[firstname]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[lastname]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[loginUserType]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[created]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[last_login_date]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[last_login_ip]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[status]) . '</td>        
    </tr>';
	$sno = $sno + 1;
}

$XML .= '</table>';
echo $XML;
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Guest_list_" . date('m-d-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$data";
?>
