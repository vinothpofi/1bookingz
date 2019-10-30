<?php



    /*******************************************************************************

     *                      PHP Paypal IPN Integration Class

     *******************************************************************************

     *      Author:     Micah Carrick

     *      Email:      email@micahcarrick.com

     *      Website:    http://www.micahcarrick.com

     *

     *      File:       paypal.class.php

     *      Version:    1.3.0

     *      Copyright:  (c) 2005 - Micah Carrick

     *                  You are free to use, distribute, and modify this software

     *                  under the terms of the GNU General Public License.  See the

     *                  included license.txt file.

     *

     *******************************************************************************

     *  VERION HISTORY:

     *      v1.3.0 [10.10.2005] - Fixed it so that single quotes are handled the

     *                            right way rather than simple stripping them.  This

     *                            was needed because the user could still put in

     *                            quotes.

     *

     *      v1.2.1 [06.05.2005] - Fixed typo from previous fix :)

     *

     *      v1.2.0 [05.31.2005] - Added the optional ability to remove all quotes

     *                            from the paypal posts.  The IPN will come back

     *                            invalid sometimes when quotes are used in certian

     *                            fields.

     *

     *      v1.1.0 [05.15.2005] - Revised the form output in the submit_paypal_post

     *                            method to allow non-javascript capable browsers

     *                            to provide a means of manual form submission.

     *

     *      v1.0.0 [04.16.2005] - Initial Version

     *

     *******************************************************************************

     *  DESCRIPTION:

     *

     *      NOTE: See www.micahcarrick.com for the most recent version of this class

     *            along with any applicable sample files and other documentaion.

     *

     *      This file provides a neat and simple method to interface with paypal and

     *      The paypal Instant Payment Notification (IPN) interface.  This file is

     *      NOT intended to make the paypal integration "plug 'n' play". It still

     *      requires the developer (that should be you) to understand the paypal

     *      process and know the variables you want/need to pass to paypal to

     *      achieve what you want.

     *

     *      This class handles the submission of an order to paypal aswell as the

     *      processing an Instant Payment Notification.

     *

     *      This code is based on that of the php-toolkit from paypal.  I've taken

     *      the basic principals and put it in to a class so that it is a little

     *      easier--at least for me--to use.  The php-toolkit can be downloaded from

     *      http://sourceforge.net/projects/paypal.

     *

     *      To submit an order to paypal, have your order form POST to a file with:

     *

     *          $p = new paypal_class;

     *          $p->add_field('business', 'somebody@domain.com');

     *          $p->add_field('first_name', $_POST['first_name']);

     *          ... (add all your fields in the same manor)

     *          $p->submit_paypal_post();

     *

     *      To process an IPN, have your IPN processing file contain:

     *

     *          $p = new paypal_class;

     *          if ($p->validate_ipn()) {

     *          ... (IPN is verified.  Details are in the ipn_data() array)

     *          }

     *

     *

     *      In case you are new to paypal, here is some information to help you:

     *

     *      1. Download and read the Merchant User Manual and Integration Guide from

     *         http://www.paypal.com/en_US/pdf/integration_guide.pdf.  This gives

     *         you all the information you need including the fields you can pass to

     *         paypal (using add_field() with this class) aswell as all the fields

     *         that are returned in an IPN post (stored in the ipn_data() array in

     *         this class).  It also diagrams the entire transaction process.

     *

     *      2. Create a "sandbox" account for a buyer and a seller.  This is just

     *         a test account(s) that allow you to test your site from both the

     *         seller and buyer perspective.  The instructions for this is available

     *         at https://developer.paypal.com/ as well as a great forum where you

     *         can ask all your paypal integration questions.  Make sure you follow

     *         all the directions in setting up a sandbox test environment, including

     *         the addition of fake bank accounts and credit cards.

     *

     *******************************************************************************

     */

    class Paypal_class

    {

        var $last_error;

        var $ipn_log;

        var $ipn_log_file;

        var $ipn_response;

        var $ipn_data = array();

        var $fields = array();



        function __construct()

        {

            $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

            $this->last_error = '';

            $this->ipn_log_file = '.ipn_results.log';

            $this->ipn_log = true;

            $this->ipn_response = '';

            $this->add_field('rm', '2');

            $this->add_field('cmd', '_xclick');

        }



        function add_field($field, $value)

        {

            $this->fields["$field"] = $value;

        }



        function submit_paypal_post()

        {

            echo "<html>\n";

            echo "<head><title>Processing Payment...</title></head>\n";

            echo "<body onLoad=\"document.forms['paypal_form'].submit();\">\n";

            echo "<center><h2>Please wait, your order is being processed and you";

            echo " will be redirected to the paypal website.</h2></center>\n";

            echo "<form method=\"post\" name=\"paypal_form\" ";

            echo "action=\"" . $this->paypal_url . "\">\n";

            foreach ($this->fields as $name => $value) {

                echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";

            }

            echo "<center><br/><br/>If you are not automatically redirected to ";

            echo "paypal within 5 seconds...<br/><br/>\n";

            echo "<input type=\"submit\" value=\"Click Here\"></center>\n";

            echo "</form>\n";

            echo "</body></html>\n";

        }



        function validate_ipn()

        {

            $url_parsed = parse_url($this->paypal_url);

            $post_string = '';

            foreach ($_POST as $field => $value) {

                $this->ipn_data["$field"] = $value;

                $post_string .= $field . '=' . urlencode(stripslashes($value)) . '&';

            }

            $post_string .= "cmd=_notify-validate"; // append ipn command

            $fp = fsockopen($url_parsed[host], "80", $err_num, $err_str, 30);

            if (!$fp) {

                $this->last_error = "fsockopen error no. $errnum: $errstr";

                $this->log_ipn_results(false);

                return false;

            } else {

                fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n");

                fputs($fp, "Host: $url_parsed[host]\r\n");

                fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");

                fputs($fp, "Content-length: " . strlen($post_string) . "\r\n");

                fputs($fp, "Connection: close\r\n\r\n");

                fputs($fp, $post_string . "\r\n\r\n");

                while (!feof($fp)) {

                    $this->ipn_response .= fgets($fp, 1024);

                }

                fclose($fp); // close connection

            }

            if (eregi("VERIFIED", $this->ipn_response)) {

                $this->log_ipn_results(true);

                return true;

            } else {

                $this->last_error = 'IPN Validation Failed.';

                $this->log_ipn_results(false);

                return false;

            }

        }



        function log_ipn_results($success)

        {

            if (!$this->ipn_log) return;

            $text = '[' . date('m/d/Y g:i A') . '] - ';

            if ($success) $text .= "SUCCESS!\n"; else $text .= 'FAIL: ' . $this->last_error . "\n";

            $text .= "IPN POST Vars from Paypal:\n";

            foreach ($this->ipn_data as $key => $value) {

                $text .= "$key=$value, ";

            }

            $text .= "\nIPN Response from Paypal Server:\n " . $this->ipn_response;

            $fp = fopen($this->ipn_log_file, 'a');

            fwrite($fp, $text . "\n\n");

            fclose($fp);

        }



        function dump_fields()

        {

            echo "<h3>paypal_class->dump_fields() Output:</h3>";

            echo "<table width=\"95%\" border=\"1\" cellpadding=\"2\" cellspacing=\"0\">

            <tr>

               <td bgcolor=\"black\"><b><font color=\"white\">Field Name</font></b></td>

               <td bgcolor=\"black\"><b><font color=\"white\">Value</font></b></td>

            </tr>";

            ksort($this->fields);

            foreach ($this->fields as $key => $value) {

                echo "<tr><td>$key</td><td>" . urldecode($value) . "&nbsp;</td></tr>";

            }

            echo "</table><br>";

        }

    }





 

