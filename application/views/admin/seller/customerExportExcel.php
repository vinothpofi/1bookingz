<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Host_list_" . date('m-d-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('user_model');
?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Host List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	<th>No</th>
        <th>FirstName</th>       
        <th>LastName</th>       
        <th>Group</th>
		<th>Email</th>
		<th>Host Created Date</th>
		<th>Last Login Date</th>
		<th>Last Login IP</th>
		<th>ID Proof Status</th>
		<th>Status</th>
        

    </tr>';
$sno = 1;
foreach ($getCustomerDetails as $myrow) 
{
	if ($row->id_proof_status == '') 
	{
		$id_proof = "Proof Not Sent";
	} 
	else 
	{
		$id_proof = "---";
	}
	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
        <td style="text-align:left">' . ucfirst($myrow[firstname]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[lastname]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[group]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
        <td style="text-align:left">' . ucfirst($myrow[created]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[last_login_date]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[last_login_ip]) . '</td>
		<td style="text-align:left">' . $id_proof . '</td>
        <td style="text-align:left">' . ucfirst($myrow[status]) . '</td>
      
        
    </tr>';
	$sno = $sno + 1;

}
$XML .= '</table>';
echo $XML;


?>
