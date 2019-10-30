<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * URI:               http://www.homestaydnn.com/
 * Description:       Contantan management controller which contains messaging, account and at all.
 * Version:           2.0
 * Author:            Sathyaseelan,Vishnu
 **/
class Bulk extends MY_Controller
{
    public $start_count=101;
    public $end_count=10000;

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form', 'email'));
        $this->load->model(array('product_model', 'admin_model', 'cms_model', 'slider_model', 'user_model'));

    }
    public function add_bulk_users(){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "homestaydnn_v3_bulk";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
        for ($i = $this->start_count; $i <= $this->end_count; $i++) {
            $email = 'devaraj' . $i . '@mailinator.com';
            $sql = "INSERT INTO fc_users (`firstname`, `lastname`,`user_name`, `loginUserType`, `phone_no`,`group`,`email`,`password`,`status`,`is_verified`,`id_verified`,`ph_verified`,`is_brand`,`last_login_date`,`last_logout_date`,`last_login_ip`,`visibility`,`display_lists`,`confirm_password`,`created`,`expired_date`,`dob_date`,`dob_month`,`dob_year`) VALUES ('deva','raj','devaraj','normal','9585850362','User','" . $email . "','a8607fff9001aaf2dbf9fe800d4ca0dc','Active','No','No','No','no','2019-02-11 11:16:02','2019-02-11 11:16:02','192.168.0.61','visibility','Yes','De123456','2019-02-11 11:16:02','2019-02-26','10','6','1994')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

    }

    public function add_bulk_products(){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "homestaydnn_v3_bulk";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        for ($i = $this->start_count; $i <= $this->end_count; $i++) {
            $product_title = 'product title' . $i;
            $seourl = str_replace(' ', '-', $product_title);
            $listings = '{"30":"1","31":"9","52":"20"}';
            $sql = "INSERT INTO fc_product (`user_id`,`product_title`, `seourl`,`price`, `description`, `max_quantity`,`shipping_type`,`taxable_type`,`ship_immediate`,`status`,`currency`,`home_type`,`room_type`,`accommodates`,`listings`,`space`,`guest_access`,`interact_guest`,`neighbor_overview`,`other_thingnote`,`house_rules`,`calendar_checked`,`minimum_stay`,`security_deposit`,`instant_pay`,`request_to_book`,`cancellation_policy`,`cancel_percentage`,`cancel_description`,`host_status`,`user_status`) VALUES ('2','" . $product_title . "','" . $seourl . "','100','description content','1','Shippable','Taxable','false','Publish','USD','36','55','1','" . $listings . "','sapce content','guest access content','interact guest content','neighbor overview content','other thingnote content','house rules content','always','1','10','Yes','Yes','Flexible','12','cancel description content','0','Inactive')";


            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;

                $schedule = "INSERT INTO schedule (`id`)VALUES ('" . $last_id . "')";
                if ($conn->query($schedule) === TRUE) {
                    echo "New Schedule created successfully<br>";
                }

                $rental_photos = "INSERT INTO fc_rental_photos (`product_id`,`product_image`,`status`) VALUES ('" . $last_id . "','1549890623.png','Active')";
                if ($conn->query($rental_photos) === TRUE) {
                    echo "New rental_photos created successfully<br>";
                }

                $addres = "INSERT INTO fc_product_address_new (`productId`, `address`,`city`,`state` ,`country`,`lang`,`lat`) VALUES ('" . $last_id . "','coimbatore','Coimbatore','Tamil Nadu','India','76.95583343505860000','11.01683998107910200')";

                if ($conn->query($addres) === TRUE) {
                    echo "New Address created successfully<br>";
                }
                echo "New record created successfully<br>";

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    public function add_bulk_experiance(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "homestaydnn_v3_bulk";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        for ($i = $this->start_count; $i <= $this->end_count; $i++) {
            $product_title = 'experience title' . $i;

            $listings = '{"30":"1","31":"9","52":"20"}';
            $sql = "INSERT INTO fc_experiences (`added_date`,`language_list`,`group_size`,`total_hours`,`kit_content`,`date_count`,`type_id`,`user_id`,`exp_type`,`organization`,`organization_des`,`exp_tagline`,`experience_title`, `what_we_do`,`price`,`status`,`currency`,`location`,`location_description`,`about_host`,`guest_requirement`,`note_to_guest`,`security_deposit`,`cancel_policy`,`cancel_percentage`,`cancel_policy_des`,`host_status`) VALUES ('2019-02-11 15:46:24','1','4','4','1','1','28','2','2','organization','organization desc','tag','" . $product_title . "','what_we_do','100','1','USD','coimbatore','location_description content','about_host content','guest_requirement content','note_to_guest content','10','Flexible','12','cancel description content','0')";


            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;

                $addres = "INSERT INTO fc_experience_address (`experience_id`, `address`,`city`,`state` ,`country`,`lang`,`lat`,`status`) VALUES ('" . $last_id . "','coimbatore','Coimbatore','Tamil Nadu','India','76.95583343505860000','11.01683998107910200','0')";

                if ($conn->query($addres) === TRUE) {
                    echo "New Address created successfully<br>";
                } else {
                    echo "Error: " . $addres . "<br>" . $conn->error;
                }
                $experience_photos = "INSERT INTO fc_experience_photos (`product_id`, `product_image`,`status`) VALUES ('" . $last_id . "','154988024120190105035537.png','Active')";

                if ($conn->query($experience_photos) === TRUE) {
                    echo "New experience_photos created successfully<br>";
                } else {
                    echo "Error: " . $experience_photos . "<br>" . $conn->error;
                }
                $dates = "INSERT INTO fc_experience_dates (`experience_id`, `from_date`,`to_date`,`currency` ,`price`,`status`,`created_at`) VALUES ('" . $last_id . "','2019-02-28','2019-02-28','USD','50.00','0','2019-02-26 15:46:50')";

                if ($conn->query($dates) === TRUE) {
                    $date_last_id = $conn->insert_id;
                    echo "New dates created successfully<br>";
                } else {
                    echo "Error: " . $dates . "<br>" . $conn->error;
                }

                $times = "INSERT INTO fc_experience_time_sheet (`exp_dates_id`,`experience_id`, `schedule_date`,`start_time`,`end_time` ,`title`,`description`,`status`,`created_at`) VALUES ('" . $date_last_id . "','" . $last_id . "','2019-02-28','19:00:00','23:00:00','" . $product_title . "','desc','1','2019-02-26 15:46:50')";

                if ($conn->query($times) === TRUE) {
                    echo "New time created successfully<br>";
                } else {
                    echo "Error: " . $times . "<br>" . $conn->error;
                }


                echo "New record created successfully<br>";

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }
    }

    public function add_bulk_products_book(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "homestaydnn_v3_bulk";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        for ($i = 1; $i <= 300; $i++) {
            $val = 10 * $i + 8;
            $val = 1500000 + $val;
            $bookingno = "EN" . $val;
            $rentalsenquiry = "INSERT INTO fc_rentalsenquiry (`user_id`,`prd_id`, `checkin`,`checkout`, `NoofGuest`, `renter_id`,`numofdates`,`subTotal`,`serviceFee`,`totalAmt`,`booking_status`,`dateAdded`,`approval`,`Bookingno`,`cancelled`,`currencycode`,`currencyPerUnitSeller`,`user_currencycode`,`unitPerCurrencyUser`,`secDeposit`,`walletAmount`,`cancel_percentage`,`choosed_option`,`currency_cron_id`) VALUES ('3','" . $i . "','2019-02-26 00:00:00','2019-02-27 00:00:00','1','2','1','100','10.00','122.00','Booked','2019-02-26 06:02:13','Accept','" . $bookingno . "','No','USD','1.00','USD','1.00','12.00','0.00','12','instant_pay','3962')";

            if ($conn->query($rentalsenquiry) === TRUE) {
                $enq_last_id = $conn->insert_id;

                $med_msg_send = "INSERT INTO fc_med_message (`productId`,`bookingNo`,`senderId`,`receiverId`,`subject`,`message`,`currencycode`,`status`,`point`) VALUES ('" . $i . "','" . $bookingno . "','3','2','booking','instant_pay','USD','Accept','0')";

                if ($conn->query($med_msg_send) === TRUE) {

                    echo "New med_msg_send created successfully<br>";
                } else {
                    echo "Error: " . $med_msg_send . "<br>" . $conn->error;
                }

                $med_msg_recieve = "INSERT INTO fc_med_message (`productId`,`bookingNo`,`senderId`,`receiverId`,`subject`,`message`,`currencycode`,`status`,`point`) VALUES ('" . $i . "','" . $bookingno . "','2','3','booking','instant_pay','USD','Accept','1')";

                if ($conn->query($med_msg_recieve) === TRUE) {

                    echo "New med_msg_recieve created successfully<br>";
                } else {
                    echo "Error: " . $med_msg_recieve . "<br>" . $conn->error;
                }

                $commission_tracking = "INSERT INTO fc_commission_tracking (`host_email`,`booking_no`,`total_amount`,`subtotal`,`guest_fee`,`host_fee`,`disputer_id`,`cancel_percentage`,`paid_canel_status`,`payable_amount`,`paid_status`,`dateAdded`) VALUES ('devaraj1@mailinator.com','" . $bookingno . "','122.00','100','10.00','0.00','0','12','0','112.00','0','2019-02-26 18:03:14')";
                if ($conn->query($commission_tracking) === TRUE) {

                    echo "New commission_tracking created successfully<br>";
                } else {
                    echo "Error: " . $commission_tracking . "<br>" . $conn->error;
                }

                $payment = "INSERT INTO fc_payment (`created`,`modified`,`user_id`,`sell_id`,`product_id`,`price`,`is_coupon_used`,`indtotal`,`sumtotal`,`total`,`status`,`payment_type`,`EnquiryId`,`currency_code`,`is_wallet_used`) VALUES ('2019-02-26 18:03:13','2019-02-26 18:03:14','3','2','" . $i . "','122','No','100.00','122.00','122','Paid','Credit Cart','" . $enq_last_id . "','USD','0')";
                if ($conn->query($payment) === TRUE) {

                    echo "New payment created successfully<br>";
                } else {
                    echo "Error: " . $payment . "<br>" . $conn->error;
                }

                $dates = array('2019-02-26 00:00:00');
                $end = '2019-02-27 00:00:00';
                while (end($dates) < $end) {
                    $dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
                }

                $dateMinus1 = count($dates) - 1;
                $j = 1;
                foreach ($dates as $date) {
                    if ($j <= $dateMinus1) {
                        $payment = "INSERT INTO bookings (`id_item`,`the_date`,`id_state`,`PropId`,`price`) VALUES ('1','" . $date . "','1','" . $i . "','0.00')";
                        if ($conn->query($payment) === TRUE) {

                            echo "New payment created successfully<br>";
                        } else {
                            echo "Error: " . $payment . "<br>" . $conn->error;
                        }
                    }
                    $j++;

                }

                $bookings_sql = "SELECT * FROM bookings WHERE PropId = '" . $i . "'";
                $DateArr = $conn->query($bookings_sql);

                $schedulesql = "SELECT * FROM schedule WHERE id = '" . $i . "'";
                $schedule_DateArr = $conn->query($schedulesql);

                while ($row = $schedule_DateArr->fetch_assoc()) {
                    $data_is = $row["data"];
                }
                $dateDispalyRowCount = 0;
                $dateArrVAl = '';
                $price = '';
                $data_old = json_decode($data_is, true);

                if ($DateArr->num_rows > 0) {
                    $dateArrVAl .= '{';
                    while ($dateDispalyRow = $DateArr->fetch_assoc()) {

                        if ($dateDispalyRowCount == 0) {
                            $dateArrVAl .= '"' . $dateDispalyRow['the_date'] . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"booked"}';
                        } else {
                            $dateArrVAl .= ',"' . $dateDispalyRow['the_date'] . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"booked"}';
                        }
                        $dateDispalyRowCount = $dateDispalyRowCount + 1;
                    }
                    $dateArrVAl .= '}';
                }

                if (count($data_old) > 0) {
                    $decoded = json_decode($dateArrVAl, true);
                    $dateArrVAl = array_merge($decoded, $data_old);
                    $dateArrVAl = json_encode($dateArrVAl);
                }


                $payment_sql = "UPDATE `schedule` SET `id` = '" . $i . "',`data` = '" . $dateArrVAl . "' WHERE `id` = '" . $i . "'";

                if ($conn->query($payment_sql) === TRUE) {
                    echo "Updated Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }

                echo "New rentalsenquiry created successfully-----------<br>";
            } else {
                echo "Error: " . $rentalsenquiry . "<br>" . $conn->error;
            }
        }
    }

    public function add_bulk_experience_book(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "homestaydnn_v3_bulk";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        for ($i = 1; $i <= 500; $i++) {
            $val = 10 * $i + 8;
            $val = 1500000 + $val;
            $bookingno = "XP" . $val;
            $rentalsenquiry = "INSERT INTO fc_experience_enquiry (`user_id`,`prd_id`, `checkin`,`checkout`, `NoofGuest`, `renter_id`,`numofdates`,`subTotal`,`serviceFee`,`totalAmt`,`booking_status`,`dateAdded`,`approval`,`Bookingno`,`cancelled`,`currencycode`,`currencyPerUnitSeller`,`user_currencycode`,`unitPerCurrencyUser`,`secDeposit`,`walletAmount`,`exp_cancel_percentage`,`currency_cron_id`,`date_id`) VALUES ('3','" . $i . "','2019-02-12 00:00:00','2019-02-13 00:00:00','1','2','1','100.00','10.00','120.00','Booked','2019-02-12 06:02:13','Accept','" . $bookingno . "','No','USD','1.00','USD','1.00','12.00','0.00','12','3962','" . $i . "')";

            if ($conn->query($rentalsenquiry) === TRUE) {
                $enq_last_id = $conn->insert_id;
                $med_msg_send = "INSERT INTO fc_experience_med_message (`productId`,`bookingNo`,`senderId`,`receiverId`,`subject`,`message`,`status`,`point`) VALUES ('" . $i . "','" . $bookingno . "','3','2','booking','instant_pay','Accept','0')";

                if ($conn->query($med_msg_send) === TRUE) {

                    echo "New med_msg_send created successfully<br>";
                } else {
                    echo "Error: " . $med_msg_send . "<br>" . $conn->error;
                }

                $med_msg_recieve = "INSERT INTO fc_experience_med_message (`productId`,`bookingNo`,`senderId`,`receiverId`,`subject`,`message`,`status`,`point`) VALUES ('" . $i . "','" . $bookingno . "','2','3','booking','instant_pay','Accept','1')";

                if ($conn->query($med_msg_recieve) === TRUE) {

                    echo "New med_msg_recieve created successfully<br>";
                } else {
                    echo "Error: " . $med_msg_recieve . "<br>" . $conn->error;
                }

                $payment = "INSERT INTO fc_experience_booking_payment (`created`,`modified`,`user_id`,`sell_id`,`product_id`,`price`,`is_coupon_used`,`indtotal`,`sumtotal`,`total`,`status`,`payment_type`,`EnquiryId`,`currency_code`,`is_wallet_used`) VALUES ('2019-02-12 18:03:13','2019-02-13 18:03:14','3','2','" . $i . "','120','No','50.00','120.00','120','Paid','Credit Cart','" . $enq_last_id . "','USD','0')";
                if ($conn->query($payment) === TRUE) {

                    echo "New payment created successfully<br>";
                } else {
                    echo "Error: " . $payment . "<br>" . $conn->error;
                }

                $commission_tracking = "INSERT INTO fc_experience_commission_tracking (`host_email`,`booking_no`,`total_amount`,`subtotal`,`guest_fee`,`host_fee`,`disputer_id`,`exp_cancel_percentage`,`paid_canel_status`,`payable_amount`,`paid_status`,`dateAdded`) VALUES ('devaraj1@mailinator.com','" . $bookingno . "','120.00','100','10.00','0.00','0','12','0','110.00','0','2019-02-12 18:03:14')";
                if ($conn->query($commission_tracking) === TRUE) {

                    echo "New commission_tracking created successfully<br>";
                } else {
                    echo "Error: " . $commission_tracking . "<br>" . $conn->error;
                }

            } else {
                echo "Error: " . $rentalsenquiry . "<br>" . $conn->error;
            }
        }
    }

}