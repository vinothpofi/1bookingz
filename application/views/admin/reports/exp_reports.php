<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Experience_list_" . date('m-d-Y') . ".xls");
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
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Experience List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	
        <th>Experience Name</th>       
        <th>Total Orders</th>       
        <th>Paid Orders</th>
            <th>Pending Orders</th>
         <th>Cancelled Orders</th>
		
		
        

    </tr>';
$sno = 1;
foreach ($getCustomerDetails as $row) 
{
    $name = $row['experience_title'] != '' ? $row['experience_title'] :  'Not listed yet';
	
	$XML .= '<tr>
    	
        <td style="text-align:left">' . ucfirst($name) . '</td>
        <td style="text-align:left">' . ucfirst($row['total_order']) . '</td>
        <td style="text-align:left">' . ucfirst($row['booked_pro_count']) . '</td>
        <td style="text-align:left">' . ucfirst($row['pending_pro_count']) . '</td>
        <td style="text-align:left">' . ucfirst($row['cacelled_pro_count']) . '</td> 
      
        
    </tr>';
	$sno = $sno + 1;

}
$XML .= '</table>';
echo $XML;