<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to user management
 * @author Teamtweaks
 *
 */
class Experience_commission extends MY_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('experience_commission_model');
		if ($this->checkPrivileges('Commission', $this->privStatus) == FALSE) {
			redirect('admin');
		}
	}

	/**
	 *
	 * This function loads the commisions list page
	 */
	public function index()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} 
		else {
			redirect('admin/experience_commission/display_commission_tracking_lists');
		}
	}

	/**
	 *
	 * This function loads the commisions list page
	 */
	public function display_commission_tracking_lists()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} 
		else {
			
			$this->data['heading'] = 'Experience Commission Tracking Lists';
			$this->data['datefrom'] = $this->input->post('datefrom');
           $this->data['dateto'] = $this->input->post('dateto');
			$this->load->view('admin/experience_commission/display_tracking_lists', $this->data);
		}
	}
	public function display_commission_tracking_lists_datatables()
	{
		

		$requestData= $_REQUEST;
           
            $columns = array(
            // datatable column index  => database column name
                
                1 =>'email'
            );
                    
            $this->data['heading'] = 'Experience Commission Tracking Lists';

          //  $sellerDetails = $this->experience_commission_model->get_all_details(USERS,array('is_experienced'=>'1','status'=>'Active'),array(array('field'=>'id','type'=>"DESC")));

        //,'status'=>'Active'
             $this->db->select('*');
            $this->db->from(USERS);
            $this->db->where(array('is_experienced'=>'1'));
            $sellerDetails = $this->db->get();

          
            $totalData = $sellerDetails->num_rows();
            $totalFiltered = $totalData;
// $rep_code = 20;
        //`status` = 'Active' AND
              $condition = " `is_experienced` = '1'";
            if( !empty($requestData['search']['value']) ) {   
                $condition.=" AND ( email LIKE '".$requestData['search']['value']."%') ";    
                
            }

            $this->db->select('*');
            $this->db->from(USERS);
            $this->db->where($condition);
            $sellerDetails = $this->db->get();


            $totalFiltered = $sellerDetails->num_rows();
            $order_is =" ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."";
            $limit_is = "".$requestData['start']." ,".$requestData['length']."   ";
        //echo $limit_is;
             $this->db->select('*');
            $this->db->from(USERS);
            $this->db->where($condition);
            $this->db->order_by($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir']);
            $this->db->limit($requestData['length'],$requestData['start']);
            $sellerDetails = $this->db->get();
			
			
			//print_r($sellerDetails->result());
			//exit;

			foreach ($sellerDetails->result() as $seller)
			{
				$sellerEmail = $seller->email;
                $this->data['SellerEmail']=$sellerEmail;
				/* paypal email */
				$this->data['paypalData'][$sellerEmail] = $seller->paypal_email;
				 if($this->input->post('datefrom') != '' && $this->input->post('dateto') != '')
                {
                     $from_date = date("Y-m-d", strtotime( $this->input->post('datefrom')));
                     $to_date = date("Y-m-d", strtotime( $this->input->post('dateto')));
	                 $from_date =  $from_date.' 00:00:00';
                     $to_date = $to_date.' 23:59:59';
                     $rental_booking_details[$sellerEmail] = $this->experience_commission_model->get_all_commission_tracking_with_date($sellerEmail,$from_date,$to_date);
                }
                else
                {
				$rental_booking_details[$sellerEmail] = $this->experience_commission_model->get_all_commission_tracking($sellerEmail);
				}
				 $this->data['from_date_res'] = $from_date;
                $this->data['to_date_res'] = $to_date;
				$this->data['trackingDetails'][$sellerEmail]['rowsCount'] = 0;
				$this->data['trackingDetails'][$sellerEmail]['guest_fee'] = 0;
				$this->data['trackingDetails'][$sellerEmail]['total_amount'] = 0;
				$this->data['trackingDetails'][$sellerEmail]['host_fee'] = 0;
				$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = 0;
				$this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] = 0;

				if (count($rental_booking_details[$sellerEmail]) != 0)
				{
					foreach ($rental_booking_details[$sellerEmail] as $rentals)
					{
						//$totlessDays = $this->config->item('cancel_hide_days_experience');
						//$minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
						/* HERE CONFUSION OCCURED. WHY WE NEED TO ADD CANCELLATION DAYS HERE. SO I TRIED WITHOUT CANCELLATION DAYS BELOW*/
						$minus_checkin = strtotime($rentals['checkin']);//Added by nagoor
						
						$checkinBeforeDay = date('Y-m-d', $minus_checkin);
						$current_date = date('Y-m-d');
					
						if ($rentals['currency_cron_id']==0) { $currencyCronId=''; } else { $currencyCronId = $rentals['currency_cron_id'];}
						if ($checkinBeforeDay <= $current_date)
						{
							//echo $rentals['booking_no'].'|'.$minus_checkin.'|'.$checkinBeforeDay.'|'.$current_date.'<br>';
							$this->data['trackingDetails'][$sellerEmail]['rowsCount'] = $this->data['trackingDetails'][$sellerEmail]['rowsCount'] + 1;

							$this->data['trackingDetails'][$sellerEmail]['checkin'] .= $rentals['checkin'] . ",";
							$this->data['trackingDetails'][$sellerEmail]['bookinNo_pay'] .= $rentals['booking_no'] . ",";
							$this->data['trackingDetails'][$sellerEmail]['id'] = $rentals['id'];
							$this->data['trackingDetails'][$sellerEmail]['renter_id'] = $rentals['renter_id'];
							//echo $sellerEmail.'|'.$rentals['currencycode'].' != '.$this->data['admin_currency_code'].'<br>';
							if ($rentals['user_currencycode'] != $this->data['admin_currency_code'])
							{
								$currencyPerUnitSeller = $rentals['currencyPerUnitSeller'];
								$rentals['total_amount'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['total_amount'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $rentals['total_amount']);
								$rentals['booking_walletUse'] =  currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['booking_walletUse'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $rentals['booking_walletUse']);
								$rentals['guest_fee'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['guest_fee'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $rentals['guest_fee']);
								$rentals['host_fee'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['host_fee'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $rentals['host_fee']);
								$rentals['payable_amount'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['payable_amount'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $rentals['payable_amount']);
								$rentals['paid_cancel_amount'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['paid_cancel_amount'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $rentals['paid_cancel_amount']);

							} 
							else
							{

								$rentals['total_amount'] = $rentals['total_amount'];
								$rentals['guest_fee'] = $rentals['guest_fee'];
								$rentals['host_fee'] = $rentals['host_fee'];
								$rentals['payable_amount'] = $rentals['payable_amount'];
								$rentals['booking_walletUse'] = $rentals['booking_walletUse'];
								$rentals['paid_cancel_amount'] = $rentals['paid_cancel_amount'];


							}

							$this->data['trackingDetails'][$sellerEmail]['total_amount'] = $this->data['trackingDetails'][$sellerEmail]['total_amount'] + $rentals['total_amount'];

							$this->data['trackingDetails'][$sellerEmail]['guest_fee'] = $this->data['trackingDetails'][$sellerEmail]['guest_fee'] + $rentals['guest_fee'];

							$this->data['trackingDetails'][$sellerEmail]['host_fee'] = $this->data['trackingDetails'][$sellerEmail]['host_fee'] + $rentals['host_fee'];

							$cancel_amount_percen = $rentals['subtotal'] / 100 * $rentals['exp_cancel_percentage'];
							$cancel_amount=$rentals['subtotal']-$cancel_amount_percen;//317.7
							$cancel_amountBf=$cancel_amount+$rentals['secDeposit'];//417.7
							if ($rentals['user_currencycode'] != $this->data['admin_currency_code'])
							{
								$cancel_amount = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $cancel_amountBf,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $cancel_amountBf);
							}
							else
							{
								$cancel_amount = $cancel_amountBf;
							}

							
							/**to show AmountTohost if the experience is cancelled**/

							if ($rentals['cancelled'] == 'Yes' && $rentals['dis_status'] == 'Accept')
							{
								$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'] - $rentals['paid_cancel_amount'];
							} 
							else
							{
								$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'];
							}

							//echo $sellerEmail.'=='.$cancel_amount.'<br>';
							/**to show cancelAmount if the experience is cancelled**/
							if ($rentals['cancelled'] == 'Yes' && $rentals['dis_status'] == 'Accept') 
							{
								$this->data['trackingDetails'][$sellerEmail]['exp_cancel_percentage'] += $cancel_amount;
							}
							else
							{
								$this->data['trackingDetails'][$sellerEmail]['exp_cancel_percentage'] += '0.00';
							}

						}
					}
				}




				$this->data['trackingDetails'][$sellerEmail]['Bookingno'] = $rentals['Bookingno'];

				$paidAmountQry = $this->experience_commission_model->get_paid_details($sellerEmail);
				//print_r($paidAmountQry)	;echo '<hr>'.count($paidAmountQry); exit;
				$this->data['trackingDetails'][$sellerEmail]['paid'] = 0;
				$paidAmount = 0;

				if (count($paidAmountQry) != 0)
				{
					foreach ($paidAmountQry as $rental_paid)
					{
						$admin_currencyCode = $this->data['admin_currency_code'];
						if ($rental_paid['currency_cron_id']==0) { $currencyCronId=''; } else { $currencyCronId = $rental_paid['currency_cron_id'];}
						/* NAGOOR START */ 
						$totlessDays = $this->config->item('cancel_hide_days_property');
                        $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
                        $checkinBeforeDay = date('Y-m-d', $minus_checkin);
                        $current_date = date('Y-m-d');
						//echo $rentals['Bookingno'].'|'.$checkinBeforeDay.'|'.$current_date.'<br>';
                        //if ($checkinBeforeDay <= $current_date) {
							/* NAGOOR END */
							$currencyPerUnitSeller_one = $rental_paid['currencyPerUnitSeller'];	
						
						  /** Start - Convert Cancel Amount **/
							
							$cancel_amountBf = $rental_paid['payable_amount']-$rental_paid['paid_cancel_amount'];
						   
							if ($rental_paid['user_currencycode'] != $admin_currencyCode) {
								
									$cancel_amount = currency_conversion($rental_paid['user_currencycode'], $admin_currencyCode, $cancel_amountBf,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller_one, $cancel_amountBf);
							   
							} else {

									$cancel_amount = $cancel_amountBf;
							}
							/** End - Convert Cancel Amount **/
							
							
							  /** Start - Convert payable Amount **/
							$payableDb = $rental_paid['payable_amount'];
							//echo $payableDb.'|'.$rental_paid['user_currencycode'].'|'.$admin_currencyCode.'<br>';
							if ($rental_paid['user_currencycode'] != $admin_currencyCode) {
								$payable = currency_conversion($rental_paid['user_currencycode'], $admin_currencyCode, $payableDb,$currencyCronId);
								//echo $payable.'<br>';
								//customised_currency_conversion($currencyPerUnitSeller_one, $payableDb);
							} else {
								$payable = $payableDb;
								//echo 'else'.$payable.'<br>';
							}
							
							/** End - Convert payable Amount **/
						
						 if ($rental_paid['cancelled'] == 'Yes') {
								$re_paid = $cancel_amount;
							} else {
								$re_paid = $payable;
							}
							$paidAmount = $paidAmount + $re_paid;
						}
					}
					$this->data['trackingDetails'][$sellerEmail]['paid'] = $paidAmount;
				//}
			}

			$i = 1;
			$data=array();
			foreach ($this->data['trackingDetails'] as $key => $value) {
				$details = $value;
				$nestedData=array();
				 $renter_dat_is = $details['renter_id'];
               if ($details['renter_id'] != '') {
                    $email_data_is = '<td class=" ">"'.$key.'"&nbsp;&nbsp;<br><a style="color: red;" href="admin/experience_bookingpayment/display_receivable/'.$renter_dat_is.'">View</a></td>';
                }else{

               $email_data_is = '<td class=" ">"'.$key.'"&nbsp;&nbsp;</td>';
                }

                if($from_date_res == '') {
                    $from_date_res_data='<a title="Click to view details" class="tip_top" href="admin/experience_commission/display_product_list/'.$renter_dat_is.'"><span class="badge_style">Experiences&nbsp;</span></a>';
                  } else{
                        $from_date_res_data = '----';
                  }
                   if($from_date_res == '') {
											  if (number_format($details['payable_amount'] - $value['paid'], 2) > 0.00)
											{
												
												$attributes = array('onsubmit' => 'return checkHostPaypalEmail('.$i.');');
										$paypal_form = form_open('admin/experience_commission/paypal_payment',$attributes);
									
										$paypal_amount = number_format($details['payable_amount'] - $value['paid'], 2);

										$paypal_amount_form = form_input([
											'type'     => 'hidden',
											'value'    => $paypal_amount,
											'name' 	   => 'amount_from_db'
										]);

										$bookingNos= form_input([
											'type'     => 'hidden',
											'value'    => $details['Bookingno'],
											'name' 	   => 'booking_no'
										]);
										
										if ($admin_currency_code != 'USD')
										{
											$paypal_amount = convertCurrency($this->data['admin_currency_code'], 'USD', $paypal_amount);
										}
										$paypal_amount = str_replace(',', '', $paypal_amount);

										$amount_to_pay = form_input([
											'type'     => 'hidden',
											'value'    => $paypal_amount,
											'name' 	   => 'amount_to_pay'
										]);

										$hostEmail= form_input([
											'type'     => 'hidden',
											'value'    => $key,
											'name' 	   => 'hostEmail'
										]);

										$checkinDate = form_input([
											'type'     => 'hidden',
											'value'    => $details['checkin'],
											'name' 	   => 'checkinDate'
										]);

										$bookingNo= form_input([
											'type'     => 'hidden',
											'value'    => $details['bookinNo_pay'],
											'name' 	   => 'bookingNo'
										]);

										// echo form_input([
										//         'type'=>'hidden',
          //                                       'name'=>'hostemail',
          //                                       'value'=>$key
          //                               ]);


										if ($this->data['paypalData'][$key] != '')
										{
											$papleml = $this->data['paypalData'][$key];
										}
										else
										{
											$papleml = "no";
										}


										$hostPayPalEmail = form_input([
											'type'     => 'hidden',
											'id'       => 'hostPayPalEmail'.$i,
											'name' 	   => 'hostPayPalEmail',
											'value'   => $papleml
										]);

										$online_paypal = form_input([
											'type'     => 'submit',
											'class'    => 'p_approve tipLeft btn_small btn_blue ',
											'style'	   => 'border: #cb9b0c 1px solid; font-size: 10px;margin-top:3px;',
											'title'    => 'Pay balance due',
											'value'    => 'online Pay'
										]);
										$details_id = $details["id"];
										$details_id_payable_amount = $details["payable_amount"];
										$value_paid = $value["paid"];
										$resul_minus = $details_id_payable_amount - $value_paid;
					$pay_button = '<span style="" class="action_link"><a style="height: auto;" class="p_approve tipLeft"  href="admin/experience_commission/add_pay_form/'.$details_id.'/'. $resul_minus .'"  title="Pay balance due" style="margin-bottom:2px;">offline Pay</a></span><span class="action_link">'.$paypal_form.$paypal_amount_form.$amount_to_pay.$hostEmail.$checkinDate.$bookingNos.$bookingNo.$hostPayPalEmail.$online_paypal.form_close().'</span>';
											 } 
											 else{
											$pay_button = '----';
										 }
											 } else{
											$pay_button = '----';
										 }


                $nestedData[] = $i;
                $nestedData[] = $email_data_is;
                $nestedData[] = $details['rowsCount'];
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['total_amount'], 2);
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['guest_fee'], 2);
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['exp_cancel_percentage'], 2);
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['guest_fee'] + $details['host_fee'], 2);
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['payable_amount'], 2);
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['paid'], 2);
                $nestedData[] = $admin_currency_symbol . ' ' . number_format($details['payable_amount'] - $value['paid'], 2);
                $nestedData[] = $from_date_res_data;
                $nestedData[] = $pay_button;
                $nestedData[] = $details['rowsCount'];
                $nestedData[] = $details['rowsCount'];
                $data[] = $nestedData;


				$i++;
			}

			 $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

            echo json_encode($json_data);  // send data as json format
	}

	/**
	 *
	 * This function loads the vendor payment page
	 */
	public function add_pay_form()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Add vendor payment';
			$sid = $this->uri->segment(4, 0);
			$hostEmailQry = $this->experience_commission_model->get_commission_track_id($sid);
			$product_id = $hostEmailQry->row()->prd_id;
			$hostEmail = $hostEmailQry->row()->host_email;
			$this->data['hostEmail'] = $hostEmail;

			$rental_booking_details = $this->experience_commission_model->get_unpaid_commission_tracking($hostEmail);
			$payableAmount = 0;
			if (count($rental_booking_details) != 0)
			 {
				foreach ($rental_booking_details as $rentals)
				{
					$totlessDays = $this->config->item('cancel_hide_days_experience');
					$minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
					$checkinBeforeDay = date('Y-m-d', $minus_checkin);
					$current_date = date('Y-m-d');

					if ($checkinBeforeDay <= $current_date)
					{
						if ($rentals['cancelled'] == 'Yes')
						{
							$cancel_amount = $rentals['subtotal'] / 100 * $rentals['exp_cancel_percentage'];
						}
						else
						{
							$cancel_amount = 0;
						}

						$payableAmount = $payableAmount + $rentals['payable_amount'] - $cancel_amount;

					}
				}
			}			

			$paidAmountQry = $this->experience_commission_model->get_paid_details($hostEmail);
			$paidAmount = 0;
			if (count($paidAmountQry) != 0)
			{
				foreach ($paidAmountQry as $rental_paid)
				{

					$paidAmount = $paidAmount + $rental_paid['payable_amount'];
				}
			}

			$this->data['hostEmail'] = $hostEmail;
			$this->data['payableAmount'] = $this->uri->segment(5, 0);

			$this->load->view('admin/experience_commission/add_vendor_payment', $this->data);
		}
	}

	public function display_product_list($email)
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Experience wise payment details';
			$detail_get = $this->experience_commission_model->get_rep_details_commison($email);
			

			$pro_detail = array();

			foreach ($detail_get->result() as $details) {
				$totlessDays = $this->config->item('cancel_hide_days_property');
                $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($details->checkin));
                $checkinBeforeDay = date('Y-m-d', $minus_checkin);
                $current_date = date('Y-m-d');
                /** End - display Tracking deta **/
				if ($checkinBeforeDay <= $current_date) {
					$condition = array('Bookingno' => $details->booking_no, 'booking_status' => 'Booked');
					$details = $this->experience_commission_model->get_all_product_details($condition);

					$pro_detail[] = $details->result();
				}

			}

			$this->data['product'] = $pro_detail;

			$this->load->view('admin/experience_commission/display_experience_list', $this->data);
		}
	}


	public function paypal_payment()

	{

		/*Paypal integration start */
		

		$this->load->library('paypal_class');


		$return_url = base_url() . 'admin/experience_commission/paypal_commission_success';

		$cancel_url = base_url() . 'admin/experience_commission/paypal_commission_cancel';

		$notify_url = base_url() . 'admin/experience_commission/paypal_commission_ipn';

		$item_name = $this->config->item('email_title') . ' Commission Payment';

		$totalAmount = $this->input->post('amount_to_pay');
		
	
		

		$amount_from_db = $this->input->post('amount_from_db');

		$checkInDate = $this->input->post('checkinDate');
		$bookingNo = $this->input->post('bookingNo');
		$booking_no = $this->input->post('booking_no');
		$hostEmail = $this->input->post('hostEmail');

        /**Start - Get unpaid booking numbers Compare with check in dates*/
        $Get_bk_numbers = $this->experience_commission_model->get_unpaid_commission_tracking($hostEmail);
        foreach ($Get_bk_numbers as $rentals_up) {
            $totlessDays = $this->config->item('cancel_hide_days_experience');
            $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals_up['checkin']));
            $checkinBeforeDay = date('Y-m-d', $minus_checkin);
            $current_date_up = date('Y-m-d');
            if($checkinBeforeDay<=$current_date_up){
                $bk_numbers[]=$rentals_up['booking_no'];
            }
        }
        /**End - Get unpaid booking numbers Compare with check in dates*/

        $unpaid_bk_numbers_exp=array_unique($bk_numbers);
        $unpaid_bk_numbers=implode(",", $unpaid_bk_numbers_exp);


		$hostPayPalEmail = $this->input->post('hostPayPalEmail');
		$loginUserId = $this->checkLogin('A');
		$quantity = 1;
		$paypal_settings = unserialize($this->config->item('payment_0'));
		$paypal_settings = unserialize($paypal_settings['settings']);

		if ($paypal_settings['mode'] == 'sandbox') {
			$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   

		} else {
			$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     

		}

		$ctype = ($paypal_settings['mode'] == 'sandbox') ? "USD" : "USD";


		$logo = base_url() . 'images/logo/' . $this->data['logo_img'];

		
		/* To change the currency type for below line >> Sandbox: USD, Live: MYR*/


		$this->paypal_class->add_field('currency_code', 'USD');

		$this->paypal_class->add_field('image_url', $logo);

		/* Business Email - for pay to admin*/


		$this->paypal_class->add_field('business', trim($hostPayPalEmail)); /* Business Email -for pay to host*/


		$this->paypal_class->add_field('return', $return_url); /* Return URL*/


		$this->paypal_class->add_field('cancel_return', $cancel_url); /* Cancel URL*/


		$this->paypal_class->add_field('notify_url', $notify_url); /*Notify url*/


		$this->paypal_class->add_field('custom', $hostEmail . '|' . $amount_from_db ); /*Custom Values*/

		$this->paypal_class->add_field('item_name', $item_name); /*Product Name*/

		$this->paypal_class->add_field('user_id', $loginUserId);

		$this->paypal_class->add_field('quantity', $quantity); /*Quantity*/


		$this->paypal_class->add_field('amount', $totalAmount); /*Price*/


		$this->paypal_class->submit_paypal_post();


	}


	/* paypal commission payment starts */

	function paypal_commission_success()
	{

		/*get the transaction data*/

		$this->data['receiver_email'] = $_REQUEST['receiver_email'];

		$this->data['txn_id'] = $_REQUEST['txn_id'];

		$this->data['payer_email'] = $_REQUEST['payer_email'];		

		$custom_values = explode('|', $_REQUEST['custom']);

		$this->data['hostEmail'] = $custom_values[0];

		$paypal_amount = $custom_values[1];


		$checkin = $custom_values[2];
		$bookingno = $custom_values[3];
		$unpaid_bk_numbers = $custom_values[4];


		$theCheckIn = explode(",", $checkin);
		$thebookingNo = explode(",", $bookingno);
        $unpaidThebookingNo = explode(",", $unpaid_bk_numbers);


		//experience_commission_model

		$sellerEmail = $this->experience_commission_model->get_commission_tracking_list($custom_values[0]);

        if (count($sellerEmail) != 0) 
        {
            foreach ($sellerEmail as $rentals) 
            {
                $arrival_date .= $rentals['arrival_date'] . ',';
            }
        }

        $Get_bk_numbers = $this->experience_commission_model->get_unpaid_commission_tracking($custom_values[0]); 
        foreach ($Get_bk_numbers as $rentals_up) 
        {
            $bk_numbers[]=$rentals_up['booking_no'];
        }

       
        $unpaid_bk_num=array_unique($bk_numbers);
        $unpaidThebookingNo=implode(",", $unpaid_bk_num);

        $theCheckIn = explode(",", $arrival_date); 
		
		$this->data['mc_gross'] = $_REQUEST['mc_gross'];

		$this->data['currency_code'] = $_REQUEST['mc_currency'];

		

		$dataArr = array(

			'host_email' => $this->data['hostEmail'],
			'transaction_id' => $this->data['txn_id'],
			'booking_no' => $unpaid_bk_num,
			'amount' => $paypal_amount,
			'payment_type' => 'ON',
			'status' => 'Paid'

		);

		/*Commission update*/

		$this->experience_commission_model->simple_insert(EXP_COMMISSION_PAID, $dataArr);
        $commission_paid_id=$this->experience_commission_model->get_last_insert_id();


		/** Start - Update payment details if the dates reached and certain booking no **/
		foreach ($theCheckIn as $date) {
			$totlessDays = $this->config->item('cancel_hide_days_experience');
			$minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($date));
			$checkinBeforeDay = date('Y-m-d', $minus_checkin);
			$current_date = date('Y-m-d');

			if ($checkinBeforeDay <= $current_date) {
				foreach ($unpaidThebookingNo as $b_no) {
					$this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status' => 'yes','commission_paid_id'=>$commission_paid_id), array('booking_no' => $b_no));
				}
			}
			}
		/** End - Update payment details if the dates reached and certain booking no **/
		
		/*  Mail notification to host starts */	

		$adminnewstemplateArr = array(

			'news_subject' => 'HomeStay DNN - Commission Payment',

			'logo_image' => $this->config->item('logo_image'),

			'logo' => $this->config->item('logo_image'),

			'news_descrip' => $description,

			'email' => $this->config->item('email'),

			'title' => 'Commission Payment',

			'hostname' => 'Host'

		);


		extract($adminnewstemplateArr);

		$description = '<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#4f595b">

				<tbody>

				<tr>

				<td>

				<table class="devicewidth" style="background-color: #f8f8f8;" border="0" cellspacing="0" cellpadding="0" width="600" align="center">

				<tbody>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td align="left" bgcolor="#4f595b"><img src="' . base_url() . 'images/logo/' . $logo . '" alt="logo" /></td>

				</tr>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td class="editable" style="color: #ffffff; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px 20px; background-color: #a61d55;" align="center" valign="middle">Hi ' . $hostname . ',</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td>&nbsp;</td>

				</tr>

				<tr>

				<th style="color: #000; padding: 0px 20px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center"> Your commission amount(' . $paypal_amount . ' ' . $this->data['currency_code'] . ') is paid by  admin on ' . date('d/m/Y') . '.  </th>

				</tr>

				<tr>

				<td>&nbsp;</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td style="padding: 0px 20px; color: #444444; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="left" valign="middle">

				<p>Thanks!</p>

				<p>The Home<span>StayDnn</span> Team</p>

				</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td align="center" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td height="50" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				</tbody>

				</table>

				</td>

				</tr>

				</tbody>

				</table>';


		$subject = 'From: ' . $this->config->item('email_title') . ' - ';

		$message .= '<!DOCTYPE HTML>

			<html>

			<head>

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<meta name="viewport" content="width=device-width"/>

			<title>' . $news_subject . '</title><body>';

		$message .= $description;


		$message .= '</body>

			</html>';


		$email_values = array('mail_type' => 'html',

			'from_mail_id' => 'sales@laravelecommerce.com',

			'mail_name' => 'HomeStay DNN',

			'to_mail_id' => $this->data['hostEmail'],

			'subject_message' => 'HomeStay DNN - Commission Payment',

			'body_messages' => $message

		);


		$email_send_to_common = $this->experience_commission_model->common_email_send($email_values);
		
		/*  Mail notification to host ends */


		$this->setErrorMessage('success', 'Experience Commission Payment is competed');

		redirect('admin/experience_commission/display_commission_tracking_lists');

		
	}


	function paypal_commission_cancel()
	{

		$this->data['heading'] = "Payment Cancelled";

		$this->load->view('admin/experience_commission/paypal_cancel', $this->data);

	}

		

	/**
	 *
	 *  offline payment starts
	 */
	public function add_vendor_payment_manual()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{			
			$rental_booking_details = $this->experience_commission_model->get_unpaid_commission_tracking($this->input->post('hostEmail'));
			//print_r($rental_booking_details);
			$payableAmount = 0;

			if (count($rental_booking_details) != 0)
			{
				foreach ($rental_booking_details as $rentals)
				{
					/** Start - Update payment details if the dates reached **/
					$totlessDays = $this->config->item('cancel_hide_days_experience');
					$minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
					$checkinBeforeDay = date('Y-m-d', $minus_checkin);
					$current_date = date('Y-m-d');

					if ($checkinBeforeDay <= $current_date)
					{
						$payableAmount = $this->input->post('amount'); /*post amount from commission*/

                        $booking_numbers[]=$rentals['booking_no']; //Booking Numbers for this transaction
						//$this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status' => 'yes','commission_paid_id'=>), array('booking_no' => $rentals['booking_no']));
					}
				}
			}
			//print_r($booking_numbers);
			//exit;
            $makeComma=implode(',',$booking_numbers);
			$dataArr = array(
				'host_email' => $this->input->post('balance_due'),
				'transaction_id' => $this->input->post('transaction_id'),
				'booking_no' =>  $makeComma,
				'amount' => $payableAmount,
				'payment_type' => 'OFF',
				'status' => 'Paid'
			);

			$this->experience_commission_model->simple_insert(EXP_COMMISSION_PAID, $dataArr);
            $getInsertId = $this->experience_commission_model->get_last_insert_id();
            foreach($booking_numbers as $com_up){
                $this->experience_commission_model->update_details(EXP_COMMISSION_TRACKING, array('paid_status' => 'yes','commission_paid_id'=>$getInsertId), array('booking_no' => $com_up));

            }
			redirect('admin/experience_commission/display_commission_tracking_lists');
		}
	}

	


}
