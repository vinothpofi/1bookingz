<?php
/**
 * Created by PhpStorm.
 * User: DS
 * Date: 10/31/2018
 * Time: 3:37 PM
 */
function getMakeArray()
{
    $ci =& get_instance();
    $vehicleType = $ci->db->where('status','Active')->get(MAKE_MASTER)->result();
    $vehicle_typeArray = array();
    foreach($vehicleType as $rt)
    {
        $vehicle_typeArray[$rt->id]=$rt->{$field_name};
    }
    return $vehicle_typeArray;
}
function language_dynamic_admin_enable_submit($field,$post="") {
    $langTypeArray=array();
    //$langTypeArray1=array();
    $ci =& get_instance();
    $langtype = $ci->db->where('dynamic_lang', 1)->where('status', 'Active')->order_by("language_order", "asc")->get(LANGUAGES)->result();
    foreach($field as $fieldname) {
        foreach ($langtype as $rt) {
            if($post==1) {
                $langTypeArray[$fieldname . '_' . $rt->lang_code] =$ci->input->post($fieldname . '_' . $rt->lang_code);
            } else if($post==2) {
                $langTypeArray[]=$fieldname . '_' . $rt->lang_code;
            } else
            {
                $langTypeArray[] = $fieldname . '_' . $rt->lang_code;
            }
        }
    }
    return $langTypeArray;
    //return $langTypeArray;
}
function language_dynamic_enable_for_fields(){
    $ci =& get_instance();
    $langtype = $ci->db->where('dynamic_lang', 1)->where('status', 'Active')->order_by("language_order", "asc")->get(LANGUAGES)->result();

        /*get the language field name while chnaging the content or pages*/
      return $langtype;

}
function language_dynamic_enable($field,$lng="",$values="") {
    $langTypeArray = array();
	$ci =& get_instance();
    $langtype = $ci->db->where('dynamic_lang', 1)->where('status', 'Active')->order_by("language_order", "asc")->get(LANGUAGES)->result();
    if($lng!="" && $values=="") {
        /*get the language field name while chnaging the content or pages*/
        if($lng=="en") return $field; else return $field.'_'.trim($lng);
    }
    elseif($lng=="") {
        /*get the dynamic languages field name while Adding the content*/
        foreach ($langtype as $rt) {
            $langTypeArray[]= array($rt->name,$field.'_'.$rt->lang_code);
        }
        return $langTypeArray;
    }
	else {
        if(is_object($values)) {
    		if ($lng == 'en') {
                    $listvalues = $values->{$field};
            } else {
                $cityAr = $field."_".$lng;
                if ($values->{$cityAr} == '') {
                    $listvalues = $values->{$field};
                } else {
                    $listvalues = $values->{$cityAr};
                }
            }
        } else {
            if ($lng == 'en') {
                    $listvalues = $values[$field];
            } else {
                $cityAr = $field."_".$lng;
                if ($values[$cityAr] == '') {
                    $listvalues = $values[$field];
                } else {
                    $listvalues = $values[$cityAr];
                }
            }
        }
		return $listvalues;		
		
	}
	
}
?>