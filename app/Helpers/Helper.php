<?php
use App\SmStudent;
use App\SmDateFormat;
use App\SmSmsGateway;
use App\SmGeneralSettings;
use Illuminate\Support\Facades\Auth;

function sendEmailBio($data, $to_name, $to_email, $email_sms_title)
{
        $systemSetting = DB::table('sm_general_settings')->select('school_name', 'email')->find(1);
        $systemEmail = DB::table('sm_email_settings')->find(1);
        $system_email = $systemEmail->from_email;
        $school_name = $systemSetting->school_name;
        if (!empty($system_email)) {
            $data['email_sms_title'] = $email_sms_title;
            $data['system_email'] = $system_email;
            $data['school_name'] = $school_name;
            $details = $to_email;
            dispatch(new \App\Jobs\SendEmailJob($data, $details));
            $error_data =  [];
            return true;
        } else {
            $error_data[0] = 'success';
            $error_data[1] = 'Operation Failed, Please Updated System Mail';
            return $error_data;
        }
    
}

function sendSMSApi($to_mobile, $sms,$id)
{    
        $activeSmsGateway = SmSmsGateway::find($id);
        if ($activeSmsGateway->gateway_name == 'Twilio') {
            $client = new Twilio\Rest\Client($activeSmsGateway->twilio_account_sid, $activeSmsGateway->twilio_authentication_token);
            if (!empty($to_mobile)) {
                $result = $message = $client->messages->create($to_mobile, array('from' => $activeSmsGateway->twilio_registered_no,  'body' => $sms));
                return $result ;
            }
        } //end Twilio
        else if ($activeSmsGateway->gateway_name == 'Clickatell') {

            // config(['clickatell.api_key' => $activeSmsGateway->clickatell_api_id]); //set a variale in config file(clickatell.php)

            $clickatell = new \Clickatell\Rest();
            $result = $clickatell->sendMessage(['to' => $to_mobile,  'content' => $sms]);
        } //end Clickatell

        else if ($activeSmsGateway->gateway_name == 'Msg91') {
            $msg91_authentication_key_sid   = $activeSmsGateway->msg91_authentication_key_sid;
            $msg91_sender_id                = $activeSmsGateway->msg91_sender_id;
            $msg91_route                    = $activeSmsGateway->msg91_route;
            $msg91_country_code             = $activeSmsGateway->msg91_country_code;

            $curl = curl_init();

            $url = "https://api.msg91.com/api/sendhttp.php?mobiles=" . $to_mobile . "&authkey=" . $msg91_authentication_key_sid . "&route=" . $msg91_route . "&sender=" . $msg91_sender_id . "&message=" . $sms . "&country=91";

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                $result =  "cURL Error #:" . $err;
            } else {
                $result =  $response;
            }
        } //end Msg91

        return $result;
   
}
function sendSMSBio($to_mobile, $sms)
{    
        $activeSmsGateway = SmSmsGateway::where('active_status', '=', 1)->first();
        if ($activeSmsGateway->gateway_name == 'Twilio') {

            config(['TWILIO.SID' => $activeSmsGateway->twilio_account_sid]);
            config(['TWILIO.TOKEN' => $activeSmsGateway->twilio_authentication_token]);
            config(['TWILIO.FROM' => $activeSmsGateway->twilio_registered_no]);
            $account_id         = $activeSmsGateway->twilio_account_sid; // Your Account SID from www.twilio.com/console
            $auth_token         = $activeSmsGateway->twilio_authentication_token; // Your Auth Token from www.twilio.com/console
            $from_phone_number  = $activeSmsGateway->twilio_registered_no;
            $client = new Twilio\Rest\Client($account_id, $auth_token);
            if (!empty($to_mobile)) {
                $result = $message = $client->messages->create($to_mobile, array('from' => $from_phone_number,  'body' => $sms));
                return $result ;
            }
        } //end Twilio
        else if ($activeSmsGateway->gateway_name == 'Clickatell') {


            // config(['clickatell.api_key' => $activeSmsGateway->clickatell_api_id]); //set a variale in config file(clickatell.php)

            $clickatell = new \Clickatell\Rest();
            $result = $clickatell->sendMessage(['to' => $to_mobile,  'content' => $sms]);
        } //end Clickatell

        else if ($activeSmsGateway->gateway_name == 'Msg91') {
            $msg91_authentication_key_sid   = $activeSmsGateway->msg91_authentication_key_sid;
            $msg91_sender_id                = $activeSmsGateway->msg91_sender_id;
            $msg91_route                    = $activeSmsGateway->msg91_route;
            $msg91_country_code             = $activeSmsGateway->msg91_country_code;

            $curl = curl_init();

            $url = "https://api.msg91.com/api/sendhttp.php?mobiles=" . $to_mobile . "&authkey=" . $msg91_authentication_key_sid . "&route=" . $msg91_route . "&sender=" . $msg91_sender_id . "&message=" . $sms . "&country=91";

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                $result =  "cURL Error #:" . $err;
            } else {
                $result =  $response;
            }
        } //end Msg91

        return $result;
   
}

function getValueByString($student_id, $string, $extra=null){
    $student = SmStudent::find($student_id);
    if($extra != null){
        return $student->$string->$extra;

    }else{
        return $student->$string; 
    } 
}

function getParentName($student_id, $string, $extra=null){
    $student = SmStudent::find($student_id);
    $parent=SmParent::where('id',$student->parent_id)->first();
    if($extra != null){
        return $student->$parent->$extra;

    }else{
         return $parent->fathers_name;; 
    } 
}

function SMSBody($body, $s_id,$time){  
    try { 
    $original_message= $body; 
    // $original_message= "Dear Parent [fathers_name], your child [class] came to the school at [section]"; 
    $chars = preg_split('/[\s,]+/', $original_message, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    foreach($chars as $item){
        if(strstr($item[0],"[")){
            $str= str_replace('[','',$item);
            $str= str_replace(']','',$str); 
            $str= str_replace('.','',$str); 
            if($str=="class"){
                $str= "class";
                $extra="class_name";
                $custom_array[$item]= getValueByString($s_id, $str, $extra);
            }elseif($str=="section"){
                $str= "section";
                $extra="section_name";
                $custom_array[$item]= getValueByString($s_id, $str, $extra);
            }elseif($str == 'check_in_time'){
                $custom_array[$item] = $time;
            }
            
            elseif($str == 'fathers_name'){
                $str= "parents";
                $extra="fathers_name";
                $custom_array[$item]= getValueByString($s_id, $str, $extra);
                // $custom_array[$item]= 'father';
            }
            else{
                $custom_array[$item]= getValueByString($s_id, $str);
            } 
        } 
    }

    foreach($custom_array as $key=>$value){
        $original_message = str_replace($key,$value,$original_message); 
    }

  
        return $original_message;
    

       
    } catch (\Exception $e) {
        $data=[];
        return $data;
    } 
    
}
function FeesDueSMSBody($body, $s_id,$time){  
    try { 
    $original_message= $body; 
    // $original_message= "Dear Parent [fathers_name], your child [class] came to the school at [section]"; 


    //  $original_message= "Fee Due Reminder for your child |StudentName|.  Dear Parent |ParentName|, please find the below fee summary.Fee: Rs.|Fee|, Back dues 
    // Adjustment: Rs.|Adjustment|, 
    // Total: Rs.|Total|, 
    // Paid: Rs.|Paid|, 
    // Balance: Rs.|Balance|. 
    // Please ignore in case already paid."; 
    
    $chars = preg_split('/[\s,]+/', $original_message, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    foreach($chars as $item){
        if(strstr($item[0],"|")){
            $str= str_replace('|','',$item);
            // return $str;
            $str= str_replace('|','',$str); 
            $str= str_replace('.','',$str); 
            if($str=="StudentName"){
                $str= "StudentName";
                $extra="full_name";
                $custom_array[$item]= getValueByString($s_id, $str, $extra);
            
            } elseif($str == 'fathers_name'){
                $str= "parents";
                $extra="fathers_name";
                $custom_array[$item]= getValueByString($s_id, $str, $extra);
                // $custom_array[$item]= 'father';
            }
            else{
                $custom_array[$item]= getValueByString($s_id, $str);
            } 
        } 
    }
    
    foreach($custom_array as $key=>$value){
        $original_message= str_replace($key,$value,$original_message); 
    }
    
        return $original_message;
    

       
    } catch (\Exception $e) {
        $data=[];
        return $data;
    } 
    
}

    function DateConvat($input_date)
    {
        $generalSetting = SmGeneralSettings::find(1);
        $system_date_foramt = SmDateFormat::find($generalSetting->date_format_id);
        $DATE_FORMAT =  $system_date_foramt->format;
        echo date_format(date_create($input_date), $DATE_FORMAT);
    }
 
   
   

    