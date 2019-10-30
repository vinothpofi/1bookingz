<?php


$title = '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Representative Details</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';
$XML .= '<table border="1">
	<tr>
    	<th>No</th>
        <th>Login Name</th>       
        <th>Email-ID</th>       
        <th>Rep Code</th>
		<th>Last Login Date</th>
		<th>Last Logout Date</th>
		<th>Last Login IP</th>
		<th>Status</th>
		<th>Host</th>

        

    </tr>';

foreach ($rep_detail as $myrow) 
{
	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
        <td style="text-align:left">' . ucfirst($myrow[admin_name]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[admin_rep_code]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[last_login_date]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[last_logout_date]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[last_login_ip]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[status]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[host_count]) . '</td>
        
    </tr>';
	$sno = $sno + 1;
}

$XML .= '</table>';
echo $XML;

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Representative_list_" . date('m-d-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
