<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Currency extends MY_Controller {



    function __construct(){

        parent::__construct();

		$this->load->helper(array('cookie','date','form'));

		$this->load->library(array('encrypt','form_validation'));		

		$this->load->model('currency_model');

		$this->load->model('location_model');

		if ($this->checkPrivileges('Currency',$this->privStatus) == FALSE){

			redirect(ADMIN_PATH);

		}

    }



    /**

     * 

     * This function loads the currency list page

     */

	public function index()

	{	

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else {

			redirect(ADMIN_PATH.'/currency/display_user_list');

		}

	}



	/**

     * 

     * This function loads the currency list page

     */

	public function display_currency_list()

	{

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else

		{

			/*$fc_currency_cron = $this->db->where('curren_id','12')->get('fc_currency_cron')->row()->currency_values;

			$parsedJson = json_decode($fc_currency_cron, true);

			print_r($parsedJson['currency_data']);

			echo '<hr>';

			if(count($parsedJson) > 0)

			{

				echo '<table class="display dataTable">';

				foreach($parsedJson['currency_data'] as $headings)

				{

					echo '

					<tr class="info">

						<td>Base Currency : </td>

						<td>'.$headings['from'].'</td>

					</tr>';

					foreach($headings['rates'] as $key=>$value)

					{

						echo '

						<tr>

							<td>'.$key.'</td>

							<td>'.$value.'</td>

						</tr>

						';

					}

				}

				echo '</table>';

			}

			exit;*/

			$this->data['heading'] = 'currency List';

			$condition = array();

			$this->data['currencyList'] = $this->currency_model->get_all_details(CURRENCY,$condition);



			$this->data['adminCurrencyCode'] = $this->currency_model->ExecuteQuery("select admin_currencyCode from ".ADMIN_SETTINGS." where id='1'")->row()->admin_currencyCode;



			$this->load->view('admin/currency/display_currency',$this->data);

		}

	}

	public function currencyConversion()

	{

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else

		{

			$this->data['heading'] = 'Currency conversion';

			$this->data['currencies']=$this->db->select('currency_type')->where('status','Active')->get('fc_currency')->result();

			$this->data['curren_date'] = $this->db->select('created_date')->order_by('curren_id','desc')->limit(1)->get('fc_currency_cron')->row()->created_date;

			$this->load->view('admin/currency/currency_conversion',$this->data);

		}

	}

	/**

	 *

	 * This function loads add new currency form

	 */

	public function add_currency_form()

	{

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else 

		{

		    $sortArr1 = array('field'=>'name','type'=>'asc');

		    $condition = array('status'=>'Active');

			$this->data['countryList'] = $this->currency_model->get_all_details(COUNTRY_LIST,$condition,array($sortArr1));

			$this->data['heading'] = 'Add New Currency';

			$this->load->view('admin/currency/add_currency',$this->data);

		}

	}



	public function insertEditCurrency()

	{	
		

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else

		{

		    $currency_id = $this->input->post('currency_id');

		    $location_name = $this->input->post('country_name');

		    $currency_type = $this->input->post('currency_type');

			$seourl = url_title($location_name, '-', TRUE);

			$excludeArr = array("status","currency_symbols","currency_id");



			if ($this->input->post('status') != '')

			{

				$location_status = 'Active';

			}else {

				$location_status = 'InActive';

			}



			$location_data=array();

			$this->load->helper('text');

			$inputArr = array('status' => $location_status,'seourl'=>$seourl,'currency_symbols'=>$this->input->post('currency_symbols'), 'meta_title'=>'', 'meta_keyword'=>'', 'meta_description'=>'');

			$dataArr = array_merge($inputArr,$location_data);

			$condition = array('id' => $currency_id);

			

			if ($currency_id == '')

			{

			    $currency_check = $this->currency_model->get_all_details(CURRENCY,array());

                if($currency_check->num_rows() >0)

                {

                	

				  $currency = array();

				  $currency_country = array();

				  $currency_symbol = array();

			      foreach($currency_check->result() as $currency_ck)

			      {

				      $currency[] =   $currency_ck->currency_type;   

				      $currency_country[] =   $currency_ck->country_name;   

				      $currency_symbol[] =   $currency_ck->currency_symbols;   

				  }
				  // in_array($this->input->post('currency_type'),$currency) OR 
			        if(in_array($this->input->post('country_name'),$currency_country))

			        {

			             $this->setErrorMessage('error','This Currency Type are Already Exists');

			              redirect(ADMIN_PATH.'/currency/add_currency_form');

			        }

			        else

			        {

				         $this->currency_model->commonInsertUpdate(CURRENCY,'insert',$excludeArr,$dataArr,$condition);

				         $this->setErrorMessage('success','Currency Added successfully');

				         redirect(ADMIN_PATH.'/currency/display_currency_list');

			        }

			    }

			}

			else

			{

				$currency_check = $this->currency_model->get_all_details(CURRENCY,array('currency_type' => $currency_type,'id !=' => $currency_id));
				if($currency_check->num_rows() >0)

                {
                	 $this->setErrorMessage('error','This Currency Type are Already Exists');

			              redirect(ADMIN_PATH.'/currency/edit_currency_form/'.$currency_id);
                }

                else{
                $this->currency_model->commonInsertUpdate(CURRENCY,'update',$excludeArr,$dataArr,$condition);

			    $this->location_model->saveCurrencySettings();

			    $this->setErrorMessage('success','Currency updated successfully');

			    redirect(ADMIN_PATH.'/currency/display_currency_list');
					}

		    }

	    }

	}



	/**

	 *

	 * This function loads edit currency page

	 */	

	public function edit_currency_form()

	{

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else

		{

			$this->data['heading'] = 'Edit Currency';

			$currency_id = $this->uri->segment(4,0);

			$condition = array('id' => $currency_id);

			$sortArr1 = array('field'=>'name','type'=>'asc');

			$this->data['countryList'] = $this->currency_model->get_all_details(COUNTRY_LIST,array('status'=>'Active'),array($sortArr1));

			$this->data['currency_details'] = $this->currency_model->get_all_details(CURRENCY,$condition);



			if ($this->data['currency_details']->num_rows() == 1){

				$this->load->view('admin/currency/edit_currency',$this->data);

			}else {

				redirect(ADMIN_PATH);

			}

		}

	}



	/**

	 *

	 * This function loads view currency page

	 */

	public function view_currency()

	{

		if ($this->checkLogin('A') == ''){

			redirect(ADMIN_PATH);

		}else {

			$this->data['heading'] = 'View Currency';

			$currency_id = $this->uri->segment(4,0);

			$condition = array('id' => $currency_id);

			$this->data['currency_details'] = $this->currency_model->get_all_details(CURRENCY,$condition);

			if ($this->data['currency_details']->num_rows() == 1){

				$this->load->view('admin/currency/view_currency',$this->data);

			}else {

				redirect(ADMIN_PATH);

			}

		}

	}

	public function delete_currency(){

	     

		 if ($this->checkLogin('A') == ''){

			redirect(ADMIN_PATH);

		}else {

			$currency_id = $this->uri->segment(4,0);

			$condition = array('id' => $currency_id);

			$this->currency_model->commonDelete(CURRENCY,$condition);

			$this->setErrorMessage('success','Currency deleted successfully');

			redirect(ADMIN_PATH.'/currency/display_currency_list');

		}

	}



	/**

	 *

	 * This function changes status and delete currency details

	 */

	public function change_currency_status_global()

	{

		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != '')

		{

			$this->user_model->activeInactiveCommon(CURRENCY,'id');



			if (strtolower($_POST['statusMode']) == 'delete'){

				$this->setErrorMessage('success','User records deleted successfully');

			}else {

				$this->setErrorMessage('success','User records status changed successfully');

			}

			redirect(ADMIN_PATH.'/currency/display_currency_list');

		}

	}



	/**

	 *

	 * This function changes currency status 

	 */

	public function change_currency_status()

	{

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else 

		{

			$mode = $this->uri->segment(4,0);

			$id = $this->uri->segment(5,0);

			$status = ($mode == '0')?'InActive':'Active';

			$newdata = array('status' => $status);

			$condition = array('id' => $id);

			$this->currency_model->update_details(CURRENCY,$newdata,$condition);

			$this->setErrorMessage('success','Currency Status Changed Successfully');

			redirect(ADMIN_PATH.'/currency/display_currency_list');

		}

	}

	

	/**

	 *

	 * This function make currency as default currency

	 */

	public function make_default($id)

	{

		if ($this->checkLogin('A') == '')

		{

			redirect(ADMIN_PATH);

		}

		else

		{

			$newdata = array('default_currency' => 'No');

			$condition = array('status'=>'Active');



			$this->currency_model->update_details(CURRENCY,$newdata,$condition);

			$newdata = array('default_currency' => 'Yes', 'currency_rate' => '1.00');

			$condition = array('id' => $id);



			$this->currency_model->update_details(CURRENCY,$newdata,$condition);

			$defaultCurrencyQuery = $this->currency_model->get_all_details(CURRENCY,$condition);

			$defaultCurrency = $defaultCurrencyQuery->row()->currency_type;



			$this->db->query("ALTER TABLE  `fc_product` CHANGE  `currency`  `currency` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '".$defaultCurrency."'");

			$this->setErrorMessage('success','Default Currency Changed Successfully');

			redirect(ADMIN_PATH.'/currency/display_currency_list');

		}

	}



	public function get_currency_code_and_symbol()

	{

		$countries = array(

		    'AF'=>'AFGHANISTAN',

		    'AL'=>'ALBANIA',

		    'DZ'=>'ALGERIA',

		    'AS'=>'AMERICAN SAMOA',

		    'AD'=>'ANDORRA',

		    'AO'=>'ANGOLA',

		    'AI'=>'ANGUILLA',

		    'AQ'=>'ANTARCTICA',

		    'AG'=>'ANTIGUA AND BARBUDA',

		    'AR'=>'ARGENTINA',

		    'AM'=>'ARMENIA',

		    'AW'=>'ARUBA',

		    'AU'=>'AUSTRALIA',

		    'AT'=>'AUSTRIA',

		    'AZ'=>'AZERBAIJAN',

		    'BS'=>'BAHAMAS',

		    'BH'=>'BAHRAIN',

		    'BD'=>'BANGLADESH',

		    'BB'=>'BARBADOS',

		    'BY'=>'BELARUS',

		    'BE'=>'BELGIUM',

		    'BZ'=>'BELIZE',

		    'BJ'=>'BENIN',

		    'BM'=>'BERMUDA',

		    'BT'=>'BHUTAN',

		    'BO'=>'BOLIVIA',

		    'BA'=>'BOSNIA AND HERZEGOVINA',

		    'BW'=>'BOTSWANA',

		    'BV'=>'BOUVET ISLAND',

		    'BR'=>'BRAZIL',

		    'IO'=>'BRITISH INDIAN OCEAN TERRITORY',

		    'BN'=>'BRUNEI DARUSSALAM',

		    'BG'=>'BULGARIA',

		    'BF'=>'BURKINA FASO',

		    'BI'=>'BURUNDI',

		    'KH'=>'CAMBODIA',

		    'CM'=>'CAMEROON',

		    'CA'=>'CANADA',

		    'CV'=>'CAPE VERDE',

		    'KY'=>'CAYMAN ISLANDS',

		    'CF'=>'CENTRAL AFRICAN REPUBLIC',

		    'TD'=>'CHAD',

		    'CL'=>'CHILE',

		    'CN'=>'CHINA',

		    'CX'=>'CHRISTMAS ISLAND',

		    'CC'=>'COCOS (KEELING) ISLANDS',

		    'CO'=>'COLOMBIA',

		    'KM'=>'COMOROS',

		    'CG'=>'CONGO',

		    'CD'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE',

		    'CK'=>'COOK ISLANDS',

		    'CR'=>'COSTA RICA',

		    'CI'=>'COTE D IVOIRE',

		    'HR'=>'CROATIA',

		    'CU'=>'CUBA',

		    'CY'=>'CYPRUS',

		    'CZ'=>'CZECH REPUBLIC',

		    'DK'=>'DENMARK',

		    'DJ'=>'DJIBOUTI',

		    'DM'=>'DOMINICA',

		    'DO'=>'DOMINICAN REPUBLIC',

		    'TP'=>'EAST TIMOR',

		    'EC'=>'ECUADOR',

		    'EG'=>'EGYPT',

		    'SV'=>'EL SALVADOR',

		    'GQ'=>'EQUATORIAL GUINEA',

		    'ER'=>'ERITREA',

		    'EE'=>'ESTONIA',

		    'ET'=>'ETHIOPIA',

		    'FK'=>'FALKLAND ISLANDS (MALVINAS)',

		    'FO'=>'FAROE ISLANDS',

		    'FJ'=>'FIJI',

		    'FI'=>'FINLAND',

		    'FR'=>'FRANCE',

		    'GF'=>'FRENCH GUIANA',

		    'PF'=>'FRENCH POLYNESIA',

		    'TF'=>'FRENCH SOUTHERN TERRITORIES',

		    'GA'=>'GABON',

		    'GM'=>'GAMBIA',

		    'GE'=>'GEORGIA',

		    'DE'=>'GERMANY',

		    'GH'=>'GHANA',

		    'GI'=>'GIBRALTAR',

		    'GR'=>'GREECE',

		    'GL'=>'GREENLAND',

		    'GD'=>'GRENADA',

		    'GP'=>'GUADELOUPE',

		    'GU'=>'GUAM',

		    'GT'=>'GUATEMALA',

		    'GN'=>'GUINEA',

		    'GW'=>'GUINEA-BISSAU',

		    'GY'=>'GUYANA',

		    'HT'=>'HAITI',

		    'HM'=>'HEARD ISLAND AND MCDONALD ISLANDS',

		    'VA'=>'HOLY SEE (VATICAN CITY STATE)',

		    'HN'=>'HONDURAS',

		    'HK'=>'HONG KONG',

		    'HU'=>'HUNGARY',

		    'IS'=>'ICELAND',

		    'IN'=>'INDIA',

		    'ID'=>'INDONESIA',

		    'IR'=>'IRAN, ISLAMIC REPUBLIC OF',

		    'IQ'=>'IRAQ',

		    'IE'=>'IRELAND',

		    'IL'=>'ISRAEL',

		    'IT'=>'ITALY',

		    'JM'=>'JAMAICA',

		    'JP'=>'JAPAN',

		    'JO'=>'JORDAN',

		    'KZ'=>'KAZAKSTAN',

		    'KE'=>'KENYA',

		    'KI'=>'KIRIBATI',

		    'KP'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',

		    'KR'=>'KOREA REPUBLIC OF',

		    'KW'=>'KUWAIT',

		    'KG'=>'KYRGYZSTAN',

		    'LA'=>'LAO PEOPLES DEMOCRATIC REPUBLIC',

		    'LV'=>'LATVIA',

		    'LB'=>'LEBANON',

		    'LS'=>'LESOTHO',

		    'LR'=>'LIBERIA',

		    'LY'=>'LIBYAN ARAB JAMAHIRIYA',

		    'LI'=>'LIECHTENSTEIN',

		    'LT'=>'LITHUANIA',

		    'LU'=>'LUXEMBOURG',

		    'MO'=>'MACAU',

		    'MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',

		    'MG'=>'MADAGASCAR',

		    'MW'=>'MALAWI',

		    'MY'=>'MALAYSIA',

		    'MV'=>'MALDIVES',

		    'ML'=>'MALI',

		    'MT'=>'MALTA',

		    'MH'=>'MARSHALL ISLANDS',

		    'MQ'=>'MARTINIQUE',

		    'MR'=>'MAURITANIA',

		    'MU'=>'MAURITIUS',

		    'YT'=>'MAYOTTE',

		    'MX'=>'MEXICO',

		    'FM'=>'MICRONESIA, FEDERATED STATES OF',

		    'MD'=>'MOLDOVA, REPUBLIC OF',

		    'MC'=>'MONACO',

		    'MN'=>'MONGOLIA',

		    'MS'=>'MONTSERRAT',

		    'MA'=>'MOROCCO',

		    'MZ'=>'MOZAMBIQUE',

		    'MM'=>'MYANMAR',

		    'NA'=>'NAMIBIA',

		    'NR'=>'NAURU',

		    'NP'=>'NEPAL',

		    'NL'=>'NETHERLANDS',

		    'AN'=>'NETHERLANDS ANTILLES',

		    'NC'=>'NEW CALEDONIA',

		    'NZ'=>'NEW ZEALAND',

		    'NI'=>'NICARAGUA',

		    'NE'=>'NIGER',

		    'NG'=>'NIGERIA',

		    'NU'=>'NIUE',

		    'NF'=>'NORFOLK ISLAND',

		    'MP'=>'NORTHERN MARIANA ISLANDS',

		    'NO'=>'NORWAY',

		    'OM'=>'OMAN',

		    'PK'=>'PAKISTAN',

		    'PW'=>'PALAU',

		    'PS'=>'PALESTINIAN TERRITORY, OCCUPIED',

		    'PA'=>'PANAMA',

		    'PG'=>'PAPUA NEW GUINEA',

		    'PY'=>'PARAGUAY',

		    'PE'=>'PERU',

		    'PH'=>'PHILIPPINES',

		    'PN'=>'PITCAIRN',

		    'PL'=>'POLAND',

		    'PT'=>'PORTUGAL',

		    'PR'=>'PUERTO RICO',

		    'QA'=>'QATAR',

		    'RE'=>'REUNION',

		    'RO'=>'ROMANIA',

		    'RU'=>'RUSSIAN FEDERATION',

		    'RW'=>'RWANDA',

		    'SH'=>'SAINT HELENA',

		    'KN'=>'SAINT KITTS AND NEVIS',

		    'LC'=>'SAINT LUCIA',

		    'PM'=>'SAINT PIERRE AND MIQUELON',

		    'VC'=>'SAINT VINCENT AND THE GRENADINES',

		    'WS'=>'SAMOA',

		    'SM'=>'SAN MARINO',

		    'ST'=>'SAO TOME AND PRINCIPE',

		    'SA'=>'SAUDI ARABIA',

		    'SN'=>'SENEGAL',

		    'SC'=>'SEYCHELLES',

		    'SL'=>'SIERRA LEONE',

		    'SG'=>'SINGAPORE',

		    'SK'=>'SLOVAKIA',

		    'SI'=>'SLOVENIA',

		    'SB'=>'SOLOMON ISLANDS',

		    'SO'=>'SOMALIA',

		    'ZA'=>'SOUTH AFRICA',

		    'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',

		    'ES'=>'SPAIN',

		    'LK'=>'SRI LANKA',

		    'SD'=>'SUDAN',

		    'SR'=>'SURINAME',

		    'SJ'=>'SVALBARD AND JAN MAYEN',

		    'SZ'=>'SWAZILAND',

		    'SE'=>'SWEDEN',

		    'CH'=>'SWITZERLAND',

		    'SY'=>'SYRIAN ARAB REPUBLIC',

		    'TW'=>'TAIWAN, PROVINCE OF CHINA',

		    'TJ'=>'TAJIKISTAN',

		    'TZ'=>'TANZANIA, UNITED REPUBLIC OF',

		    'TH'=>'THAILAND',

		    'TG'=>'TOGO',

		    'TK'=>'TOKELAU',

		    'TO'=>'TONGA',

		    'TT'=>'TRINIDAD AND TOBAGO',

		    'TN'=>'TUNISIA',

		    'TR'=>'TURKEY',

		    'TM'=>'TURKMENISTAN',

		    'TC'=>'TURKS AND CAICOS ISLANDS',

		    'TV'=>'TUVALU',

		    'UG'=>'UGANDA',

		    'UA'=>'UKRAINE',

		    'AE'=>'UNITED ARAB EMIRATES',

		    'GB'=>'UNITED KINGDOM',

		    'US'=>'UNITED STATES',

		    'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS',

		    'UY'=>'URUGUAY',

		    'UZ'=>'UZBEKISTAN',

		    'VU'=>'VANUATU',

		    'VE'=>'VENEZUELA',

		    'VN'=>'VIET NAM',

		    'VG'=>'VIRGIN ISLANDS, BRITISH',

		    'VI'=>'VIRGIN ISLANDS, U.S.',

		    'WF'=>'WALLIS AND FUTUNA',

		    'EH'=>'WESTERN SAHARA',

		    'YE'=>'YEMEN',

		    'YU'=>'YUGOSLAVIA',

		    'ZM'=>'ZAMBIA',

		    'ZW'=>'ZIMBABWE',

		);

		$currency_symbols = array(

		'AED'=>array('name' => 'United Arab Emirates Dirham', 'symbol'=>'د.إ', 'hex'=>'&#x62f;&#x2e;&#x625;'),

		'ANG'=>array('name' => 'NL Antillian Guilder', 'symbol'=>'ƒ', 'hex'=>'&#x192;'),

		'ARS'=>array('name' => 'Argentine Peso', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'AUD'=>array('name' => 'Australian Dollar', 'symbol'=>'A$', 'hex'=>'&#x41;&#x24;'),

		'BRL'=>array('name' => 'Brazilian Real', 'symbol'=>'R$', 'hex'=>'&#x52;&#x24;'),

		'BSD'=>array('name' => 'Bahamian Dollar', 'symbol'=>'B$', 'hex'=>'&#x42;&#x24;'),

		'CAD'=>array('name' => 'Canadian Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'CHF'=>array('name' => 'Swiss Franc', 'symbol'=>'CHF', 'hex'=>'&#x43;&#x48;&#x46;'),

		'CLP'=>array('name' => 'Chilean Peso', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'CNY'=>array('name' => 'Chinese Yuan Renminbi', 'symbol'=>'¥', 'hex'=>'&#xa5;'),

		'COP'=>array('name' => 'Colombian Peso', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'CZK'=>array('name' => 'Czech Koruna', 'symbol'=>'Kč', 'hex'=>'&#x4b;&#x10d;'),

		'DKK'=>array('name' => 'Danish Krone', 'symbol'=>'kr', 'hex'=>'&#x6b;&#x72;'),

		'EUR'=>array('name' => 'Euro', 'symbol'=>'€', 'hex'=>'&#x20ac;'),

		'FJD'=>array('name' => 'Fiji Dollar', 'symbol'=>'FJ$', 'hex'=>'&#x46;&#x4a;&#x24;'),

		'GBP'=>array('name' => 'British Pound', 'symbol'=>'£', 'hex'=>'&#xa3;'),

		'GHS'=>array('name' => 'Ghanaian New Cedi', 'symbol'=>'GH₵', 'hex'=>'&#x47;&#x48;&#x20b5;'),

		'GTQ'=>array('name' => 'Guatemalan Quetzal', 'symbol'=>'Q', 'hex'=>'&#x51;'),

		'HKD'=>array('name' => 'Hong Kong Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'HNL'=>array('name' => 'Honduran Lempira', 'symbol'=>'L', 'hex'=>'&#x4c;'),

		'HRK'=>array('name' => 'Croatian Kuna', 'symbol'=>'kn', 'hex'=>'&#x6b;&#x6e;'),

		'HUF'=>array('name' => 'Hungarian Forint', 'symbol'=>'Ft', 'hex'=>'&#x46;&#x74;'),

		'IDR'=>array('name' => 'Indonesian Rupiah', 'symbol'=>'Rp', 'hex'=>'&#x52;&#x70;'),

		'ILS'=>array('name' => 'Israeli New Shekel', 'symbol'=>'₪', 'hex'=>'&#x20aa;'),

		'INR'=>array('name' => 'Indian Rupee', 'symbol'=>'र', 'hex'=>'&#x20b9;'),

		'ISK'=>array('name' => 'Iceland Krona', 'symbol'=>'kr', 'hex'=>'&#x6b;&#x72;'),

		'JMD'=>array('name' => 'Jamaican Dollar', 'symbol'=>'J$', 'hex'=>'&#x4a;&#x24;'),

		'JPY'=>array('name' => 'Japanese Yen', 'symbol'=>'¥', 'hex'=>'&#xa5;'),

		'KRW'=>array('name' => 'South-Korean Won', 'symbol'=>'₩', 'hex'=>'&#x20a9;'),

		'LKR'=>array('name' => 'Sri Lanka Rupee', 'symbol'=>'₨', 'hex'=>'&#x20a8;'),

		'MAD'=>array('name' => 'Moroccan Dirham', 'symbol'=>'.د.م', 'hex'=>'&#x2e;&#x62f;&#x2e;&#x645;'),

		'MMK'=>array('name' => 'Myanmar Kyat', 'symbol'=>'K', 'hex'=>'&#x4b;'),

		'MXN'=>array('name' => 'Mexican Peso', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'MYR'=>array('name' => 'Malaysian Ringgit', 'symbol'=>'RM', 'hex'=>'&#x52;&#x4d;'),

		'NOK'=>array('name' => 'Norwegian Kroner', 'symbol'=>'kr', 'hex'=>'&#x6b;&#x72;'),

		'NZD'=>array('name' => 'New Zealand Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'PAB'=>array('name' => 'Panamanian Balboa', 'symbol'=>'B/.', 'hex'=>'&#x42;&#x2f;&#x2e;'),

		'PEN'=>array('name' => 'Peruvian Nuevo Sol', 'symbol'=>'S/.', 'hex'=>'&#x53;&#x2f;&#x2e;'),

		'PHP'=>array('name' => 'Philippine Peso', 'symbol'=>'₱', 'hex'=>'&#x20b1;'),

		'PKR'=>array('name' => 'Pakistan Rupee', 'symbol'=>'₨', 'hex'=>'&#x20a8;'),

		'PLN'=>array('name' => 'Polish Zloty', 'symbol'=>'zł', 'hex'=>'&#x7a;&#x142;'),

		'RON'=>array('name' => 'Romanian New Lei', 'symbol'=>'lei', 'hex'=>'&#x6c;&#x65;&#x69;'),

		'RSD'=>array('name' => 'Serbian Dinar', 'symbol'=>'RSD', 'hex'=>'&#x52;&#x53;&#x44;'),

		'RUB'=>array('name' => 'Russian Rouble', 'symbol'=>'руб', 'hex'=>'&#x440;&#x443;&#x431;'),

		'SEK'=>array('name' => 'Swedish Krona', 'symbol'=>'kr', 'hex'=>'&#x6b;&#x72;'),

		'SGD'=>array('name' => 'Singapore Dollar', 'symbol'=>'S$', 'hex'=>'&#x53;&#x24;'),

		'THB'=>array('name' => 'Thai Baht', 'symbol'=>'฿', 'hex'=>'&#xe3f;'),

		'TND'=>array('name' => 'Tunisian Dinar', 'symbol'=>'DT', 'hex'=>'&#x44;&#x54;'),

		'TRY'=>array('name' => 'Turkish Lira', 'symbol'=>'TL', 'hex'=>'&#x54;&#x4c;'),

		'TTD'=>array('name' => 'Trinidad/Tobago Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'TWD'=>array('name' => 'Taiwan Dollar', 'symbol'=>'NT$', 'hex'=>'&#x4e;&#x54;&#x24;'),

		'USD'=>array('name' => 'US Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'VEF'=>array('name' => 'Venezuelan Bolivar Fuerte', 'symbol'=>'Bs', 'hex'=>'&#x42;&#x73;'),

		'VND'=>array('name' => 'Vietnamese Dong', 'symbol'=>'₫', 'hex'=>'&#x20ab;'),

		'XAF'=>array('name' => 'CFA Franc BEAC', 'symbol'=>'FCFA', 'hex'=>'&#x46;&#x43;&#x46;&#x41;'),

		'XCD'=>array('name' => 'East Caribbean Dollar', 'symbol'=>'$', 'hex'=>'&#x24;'),

		'XPF'=>array('name' => 'CFP Franc', 'symbol'=>'F', 'hex'=>'&#x46;'),

		'ZAR'=>array('name' => 'South African Rand', 'symbol'=>'R', 'hex'=>'&#x52;')

	);

		$country_name=strtoupper($this->input->post("country_name"));

		$country_code= array_search($country_name,$countries);

		$country_det=json_decode((file_get_contents("https://restcountries.eu/rest/v1/alpha/".$country_code)));

		$currency_code= $country_det->{currencies}[0];

		

			$currency_symbol= $currency_symbols[strtoupper($currency_code)]["symbol"];

		

		echo $currency_details=json_encode(array("code"=>$currency_code,"symbol"=>$currency_symbol));

	}

	function getValue()

	{

		$dateIs = date('Y-m-d',strtotime($_POST['date']));

		$amount = $_POST['amount'];

		$fromCurrency = $_POST['fromCurrency']; 

		$toCurrency = $_POST['toCurrency'];

		//->where('created_date',$dateIs)

		$curren_id = $this->db->select('curren_id')->where('created_date',$dateIs)->get('fc_currency_cron')->row()->curren_id;

		if($curren_id)

		{

			$result =  currency_conversion($fromCurrency,$toCurrency,$amount,$curren_id);

			//echo '<b style="font-size:18px;">'.$amount.' '.$fromCurrency.'</b> = '.'<b  style="font-size:18px;">'.$result.' '.$toCurrency.'</b>';

			echo $result;

		}

		else

		{

			echo 'Sorry! Date not Found!';

		}

	}

}