<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/* override number_format function  starts */

/*-- this for avoiding the round off calculation of currency based amount calculations --*/

/* CURRENCY CONVERTER */


/*  function convertCurrency($from_Currency, $to_Currency, $amount)

{

	$amount = urlencode($amount);

	$from_Currency = urlencode($from_Currency);

	$to_Currency = urlencode($to_Currency);

	$get = file_get_contents("https://finance.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");

	$get = explode("<span class=bld>", $get);

	$get = explode("</span>", $get[1]);

	$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);

	if (($from_Currency == $to_Currency) || ($converted_amount == '')) {

		return $amount;

	} else {

		return number_format($converted_amount, 2);

	}

}

  */


function convertCurrency_old($from_Currency, $to_Currency, $amount)

{

    // 	$amount = urlencode($amount);

    // $from_Currency = urlencode($from_Currency);

    // $to_Currency = urlencode($to_Currency);

    // $html = file_get_contents("http://www.xe.com/currencyconverter/convert/?Amount=$amount&From=$from_Currency&To=$to_Currency");

    // $dom = new DOMDocument;

    // $dom->loadHTML($html);

    // foreach ($dom->getElementsByTagName('span') as $node) {

    // 	 if ($node->hasAttribute('class') && strstr($node->getAttribute('class'), 'uccResultAmount')){

    // 		$convertedAmt=explode(".",$dom->saveHtml($node));

    // 		$repClass=str_replace('<span class="uccResultAmount">','',$convertedAmt[0]);

    // 		$twoGt=str_split($convertedAmt[1],2);

    // 		return $repClass.".".$twoGt[0];


    // 	 }

    // }


    $amount = urlencode($amount);

    $from = urlencode($from_Currency);

    $to = urlencode($to_Currency);

    $get = file_get_contents("https://finance.google.com/bctzjpnsun/converter?a=$amount&from=$from&to=$to");

    $get = explode("<span class=bld>", $get);

    $get = explode("</span>", $get[1]);

    $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);

    return number_format((float)$converted_amount, 2, '.', '');

}


function convertCurrency_Unit($from_Currency, $to_Currency, $amount)

{

    // 	$amount = urlencode($amount);

    // $from_Currency = urlencode($from_Currency);

    // $to_Currency = urlencode($to_Currency);

    // $html = file_get_contents("http://www.xe.com/currencyconverter/convert/?Amount=$amount&From=$from_Currency&To=$to_Currency");

    // $dom = new DOMDocument;

    // $dom->loadHTML($html);

    // foreach ($dom->getElementsByTagName('span') as $node) {

    // 	 if ($node->hasAttribute('class') && strstr($node->getAttribute('class'), 'uccResultAmount')){

    // 		$convertedAmt=explode(".",$dom->saveHtml($node));

    // 		$repClass=str_replace('<span class="uccResultAmount">','',$convertedAmt[0]);

    // 		$twoGt=str_split($convertedAmt[1],2);

    // 		return $repClass.".".$twoGt[0];


    // 	 }

    // }


    $amount = urlencode($amount);

    $from = urlencode($from_Currency);

    $to = urlencode($to_Currency);

    $get = file_get_contents("https://finance.google.com/bctzjpnsun/converter?a=$amount&from=$from&to=$to");

    $get = explode("<span class=bld>", $get);

    $get = explode("</span>", $get[1]);

    $converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);

    return number_format((float)$converted_amount, 2, '.', '');

    //return $converted_amount;

}


function currency_conversion_old($from_Currency, $to_Currency, $amount)

{

    return convertCurrency($from_Currency, $to_Currency, $amount);

    /*Following get failed*/

    /*$url = 'https://free.currencyconverterapi.com/api/v5/convert?q=' . $from_Currency . '_' . $to_Currency . '';

    $result = file_get_contents($url);

    $decoded_result = json_decode($result);

    if (!empty($decoded_result)) {

        foreach ($decoded_result->results as $res) {

            return $amount * $res->val;

        }

    }else{

        return convertCurrency($from_Currency, $to_Currency, $amount);

    }*/

}


function get_multiple_currency_rate($base)

{

    $url = 'https://api.fixer.io/latest?base=' . $base;

    $result = file_get_contents($url);

    $decoded_result = json_decode($result);

    return $decoded_result->rates;

}


function customised_currency_conversion($unitprice, $total_amount)

{

    $amount = round($total_amount / $unitprice);

    return $amount;

}


/*convert to usd*/

function currencyConvertToUSD($id, $amount)

{

    $rate = 0;

    $ci =& get_instance();

    $productCurrencyCode = $ci->db->where('id', $id)->get(PRODUCT)->row()->currency;

    $currencyCode = 'USD';

    $params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

    $rate = number_format(currency_convert($params), 2);

    if ($rate != 0) return $rate; else

        return $amount;

}


function currency_convert($params)

{

    $amount = $params["amount"];

    $currFrom = $params["currFrom"];

    $currInto = $params["currInto"];

    if (trim($amount) == "" || !is_numeric($amount)) {

        return $amount;

    }

    $return = array();

    $ci =& get_instance();

    if (trim($currFrom) == 'USD') {

        $currInto_result = $ci->db->where('currency_type', $currInto)->get(CURRENCY)->row();

        $rate = $amount * $currInto_result->currency_rate;

    } else {

        $currFrom_result = $ci->db->where('currency_type', $currFrom)->get(CURRENCY)->row();

        $from_usd = 0;

        if ($currFrom_result->currency_rate > 0) $from_usd = 1 / $currFrom_result->currency_rate;

        $from_usd_amt = $amount * $from_usd;

        $currInto_result = $ci->db->where('currency_type', $currInto)->get(CURRENCY)->row();

        $rate = $currInto_result->currency_rate * $from_usd_amt;

    }

    return $rate;

}


/*Get past currency details*/

function pastDateCurrency($id, $date, $Productamount)

{

    $ci =& get_instance();

    $currency_date = date('Y-m-d', strtotime($date));

    $today = date("Y-m-d");

    if ($today <= $currency_date) {

        return CurrencyValue($id, $Productamount);

    }

    $productCurrencyCode = $ci->db->where('id', $id)->get(PRODUCT)->row()->currency;

    $currentCurrencyCode = $ci->session->userdata('currency_type');

    $amount = "http://currencies.apps.grandtrunk.net/getrate/$currency_date/$productCurrencyCode/$currentCurrencyCode";

    if (ini_get('allow_url_fopen')) {

        $response = file_get_contents($amount, 'r');

    }

    $current_amount = $Productamount * $response;

    return number_format($current_amount, 2);

}


function CurrencyValue($id, $amount)

{

    $rate = 0;

    $ci =& get_instance();

    $currencyCode = $ci->session->userdata('currency_type');

    $productCurrencyCode = $ci->db->where('id', $id)->get(PRODUCT)->row()->currency;

    if ($currencyCode == '') {

        $newCurrencyCode = $ci->db->where(array('status' => 'Active', 'default_currency' => 'Yes'))->get(CURRENCY)->row()->currency_type;

        $params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $newCurrencyCode);

        $rate = round(currency_convert($params));

        echo $rate;

        if ($rate != 0)

            return $rate;

        else

            return $amount;

    }

    $params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

    $rate = number_format(currency_convert($params), 2);

    if ($rate != 0)

        return $rate;

    else

        return $amount;

}

function changeCurrency($from_Currency, $to_Currency, $amount, $id = "")

{


    $CI =& get_instance();

    $CI->load->model('Currency_model');

    $currFrom_result = $CI->Currency_model->get_currency_cron_data($id);

    // print_r($currFrom_result);exit();

    $json = json_decode($currFrom_result->currency_values);

    foreach ($json->currency_data as $item) {

        if ($item->from == $from_Currency) {

            //echo $item->from.'=='.$from_Currency;

            //exit;

            foreach ($item->rates as $key => $val) {

                if ($key == $to_Currency) {


                    //$val  = substr($val,0,strpos($val,".") + 3);
                    $total = $amount * $val;

                    //return substr($total, 0, strpos($total, ".") + 3);
                    return number_format((float)($total), 2, '.','');

                    //sprintf("%.2f", ($amount * $val));

                    //return number_format((float)($amount * $val), 2, '.','');

                }

            }

        }

    }

}

function convertCurrency($from_Currency, $to_Currency, $amount, $id = "")

{    /*echo $from_Currency; echo "----"; echo $to_Currency; echo "----"; echo $amount; die();*/

    $CI =& get_instance();

    $CI->load->model('Currency_model');

    $currFrom_result = $CI->Currency_model->get_currency_cron_data($id);

    $json = json_decode($currFrom_result->currency_values); /*print_r($currFrom_result); die();*/

    foreach ($json->currency_data as $item) {

        if ($item->from == $from_Currency) {

            foreach ($item->rates as $key => $val) {

                if ($key == $to_Currency) {
                    //$val  = substr($val,0,strpos($val,".") + 3);

                    $total = $amount * $val;

                   // return substr($total, 0, strpos($total, ".") + 3);
                    return number_format((float)($total), 2, '.','');

                    /*sprintf("%.2f", ($amount * $val));*/

                    /*return number_format((float)($amount * $val), 2, '.','');*/

                }

            }

        }

    }

}

function currency_conversion($from_Currency, $to_Currency, $amount, $id = ""){
    // echo $from_Currency; echo "----"; echo $to_Currency; echo "----"; echo $amount; die();
    $CI =& get_instance();
    $CI->load->model('Currency_model');
    $currFrom_result = $CI->Currency_model->get_currency_cron_data($id);
    if(!empty($currFrom_result)) {
        $json = json_decode($currFrom_result->currency_values); /*print_r($currFrom_result); die();*/
        /*newly added code - Nanthini */
        $arrCur = (array)$json->currency_data;
        $arrCur = objectToArray($arrCur);
        $key = array_search($from_Currency, array_column($arrCur, 'from'));
        $rates = isset($arrCur[$key]['rates'][$to_Currency]) ? $arrCur[$key]['rates'][$to_Currency] : 1;
        $total = $amount * $rates;
         //return substr($total, 0, strpos($total, ".") + 3);
        return number_format((float)($total), 2, '.','');
    }else{
        //return substr($amount, 0, strpos($amount, ".") + 3);
        return number_format((float)($amount), 2, '.','');
    }
    /*newly added code  - Nanthini */

    /*
     * foreach ($json->currency_data as $item) {

        if ($item->from == $from_Currency) {
            foreach ($item->rates as $key => $val) {
                if ($key == $to_Currency) {
                    //$val  = substr($val,0,strpos($val,".") + 3);

                    $total = $amount * $val;
                    return substr($total, 0, strpos($total, ".") + 3);
                    //return $val;
                    //sprintf("%.2f", ($amount * $val));
                    //return number_format((float)($amount * $val), 2, '.','');
                }
            }
        }
    }*/

}
function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}


?>

