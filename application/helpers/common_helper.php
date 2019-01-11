<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Common Helper Function
 * */

//get language message
function lang($keyword)
{
	$CI =& get_instance();
	return $CI->lang->line($keyword);
}


//update session
function update_session($identity)
{
	$CI =& get_instance();
	$query = $CI->db->select('users.email, users.first_name,users.last_name, users.id, users.password, users.access, users.profile_avtar,users.profile_background, users.status,  users.active, users.last_login,users.stripe_id,users.weight,users.last_login,membership.status as mstatus')
		                  ->where('users.id', $identity)
		                  ->join('membership','membership.user_id=users.id','left')
		                  ->limit(1)
		    			  ->order_by('id', 'desc')
		                  ->get('users');
		       $user = $query->row();

	$session_data = array(
		    'identity'             => $user->email,
		    'email'                => $user->email,
		    'coxdr_fname'          => $user->first_name,
		    'coxdr_lname'          => $user->last_name,
		    'coxdr_email'          => $user->email,
		    'coxdr_access'         => $user->access,
		    'coxdr_profile_avtar'    => $user->profile_avtar,
		    'coxdr_profile_background'  => $user->profile_background,
		    'coxdr_weight'    	   => $user->weight,
		    'coxdr_userid'         => $user->id, //everyone likes to overwrite id so we'll use cnxdr_userid
		    'old_last_login'       => $user->last_login,
		    'stripe_id'            => $user->stripe_id,
		    'weight'               => $user->weight,
		    'mstatus'              => $user->mstatus

		);

		$CI->session->set_userdata($session_data);

}

// get single Row  by pass table name,fields & where conditions

function getRow($table='',$field='',$where='')
{
		$CI =& get_instance();
		$result = false;
		if($table != '' && $field !=''){
			$CI->db->select($field);
			if(is_array($where) && count($where) > 0){
				$CI->db->where($where);
			}
			$query = $CI->db->get($table);
			$result=$query->row();
		}
		return $result;
}

// create assets Url for front
function assets($path = ""){
	return base_url("assets")."/$path";
}

// create assets Url for backend
function admin_assets($path = ""){
	return base_url("assets/backend")."/$path";
}

// create Url for backend
function admin_url($path = ""){
	//return base_url("admin")."/$path";
	return base_url("backend")."/$path";
}

// view Html on backend
function admin_views($views=null, $data=null){
	$ci =& get_instance();
	if($views)$ci->load->view("backend/$views", $data);
}

// view Html on fontend
function views($views=null, $data=null){
	$ci =& get_instance();
	if($views)$ci->load->view("frontend/$views", $data);
}

// mail function
function emailsend1($to,$subject,$msg,$from='admin@gmail.com',$file='',$filename='',$content='',$type='')
{
        //echo phpinfo();die;
    $headers = "From: " . ADMIN_EMAIL_SEND . "\r\n";
    $headers .= "Reply-To: ". ADMIN_EMAIL_SEND . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";


    $mail = mail($to, $subject, $msg, $headers);
        if ($mail) {
            return true;
        } else {
         //$CI->email->print_debugger();die(" rtet");
            return false;
        }

}

// mail function
function emailsend($to,$subject,$msg,$from='Gigcalls',$file='',$filename='',$content='',$type='')
{


		$config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'harshan.shantiinfotech@gmail.com',
		'smtp_pass' => 'harshan123456',
		'mailtype' => 'html',
		'charset' => 'iso-8859-1',
		'newline'   => "\r\n"
		);

		$CI = &get_instance();
		$CI->load->library('email', $config);
		$CI->email->initialize($config);
		$CI->email->set_mailtype("html");
		$CI->email->set_newline("\r\n");
		$CI->email->set_header('MIME-Version', '1.0');
		$CI->email->set_newline("\r\n");
		$CI->email->set_header('X-Priority', '1');
		$CI->email->set_newline("\r\n");

		//$list = array('harshan.shantiinfotech@gmail.com','harshankadam@outlook.com','nrathore45@yahoo.com');
		$CI->email->from($from, 'Gigcalls');
		$CI->email->reply_to($from, 'Gigcalls');

		//$CI->email->from(ADMIN_EMAIL_SEND, $from);
		$CI->email->to( $to );
		$CI->email->subject($subject);
		$CI->email->message($msg);

		if(!empty($file) && $type=='pdf')
		{
			for($i=0;$i<count($file);$i++)
			{
				$CI->email->attach($file[$i]);
			}
		}
		else
		{
			$CI->email->attach( $file);
		}

		$result = $CI->email->send();

		if ($result) {
			return true;
		} else {
		 //$CI->email->print_debugger();die(" rtet");
			return false;
		}

}
// pagination

function mypagi($url="",$tot="",$segment="")
{
	  $CI =& get_instance();
	   $config = array();
	   $config["base_url"] = base_url().$url;
	   $config["total_rows"] = $tot;
	   $config["per_page"] = ITEMS_PER_PAGE_FRONT;
	   $config['use_page_numbers'] = TRUE;
	   $config['num_links'] =   $tot;
	   $config['cur_tag_open'] = '<a class="active">';
	   $config['cur_tag_close'] = '</a>';

	   //~ $config['next_tag_open'] = '<a class="nextbtn">';
	   $config['next_link'] = 'Next';
	   //~ $config['next_tag_close'] = '</a>';

	   //~ $config['prev_tag_open'] = '<a class="previous">';
	   $config['prev_link'] = 'Previous';
	   //~ $config['prev_tag_close'] = '</a>';

	   $config['first_link'] = '&raquo;';
	   $config['first_tag_open'] = '<li>';
	   $config['first_tag_close'] = '</li>';
	   $config['last_link'] = '&laquo;';
	   $config['last_tag_open'] = '<li>';
	   $config['last_tag_close'] = '</li>';
	   $config['next_tag_open'] = '<li>';
	   $config['next_tag_close'] = '</li>';
	   $config['prev_tag_open'] = '<li>';
	   $config['prev_tag_close'] = '</li>';
	   $config["uri_segment"] = $segment;
	   if($config["total_rows"] >=0)
	   {
		 $page_number = $CI->uri->segment($segment);
		 $page['offset']="0";
		 if(isset($page_number))
		 {
			 $CI->pagination->initialize($config);
			 $page['offset'] =(isset($page_number)&&is_numeric($page_number))?($page_number-1) *  $config["per_page"]:0;
		 }
		 else
		 {
			 $CI->pagination->initialize($config);
			 $page['offset'] =(isset($page_number)&&is_numeric($page_number))?($page_number-1) *  $config["per_page"]:0;

		 }
	  }
	  $data = array();
	  $data['offset'] =  $page['offset'];
	  $data['per_page'] =  $config["per_page"];

	  return $data;
}



function date_to_path($date){
	return date("Y/m/d", strtotime($date))."/";
}

function array_insert(&$array, $stack){
	foreach($stack as $key=>$val)$array[$key] = $val;
	return $array;
}

function current_uri()
{
    $CI =& get_instance();
    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

function array_except(&$array, $key){
	if(is_array($key)){
		foreach($key as $k)array_except($array, $k);
	}
	else	unset($array[$key]);
	return $array;
}

function get_https_content($url=NULL,$method="GET"){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0');
	curl_setopt($ch, CURLOPT_URL,$url);
	return curl_exec($ch);
}



function get_sortlink($str, $db_column){
	$link = "<a href='";
	$link.="?sort_by=$db_column&sort_order=";
	$link.=(isset($_GET['sort_order']) && isset($_GET['sort_by']) && $_GET['sort_order']=="asc" && $_GET['sort_by']==$db_column)?"desc":"asc";
	foreach($_GET as $key=>$val)if($key!='sort_by' && $key!='sort_order')$link.="&$key=$val";
	$link.="'". ((isset($_GET['sort_order']) && isset($_GET['sort_by']) && $_GET['sort_by'] == $db_column)?" class='{$_GET['sort_order']}'":"") .">$str</a>";
	return $link;
}


function breakDateFolder($date, $root)
{
	$removespace = explode(" ", $date);
	$newdate = explode("-", $removespace[0]);
	return 'assets/'.$root.'/'.$newdate[0].'/'.$newdate[1].'/'.$newdate[2].'/';
}

function createDateFolder($date, $root)
{
	$removespace = explode(" ", $date);
	$newdate = explode("-", $removespace[0]);

	if (!is_dir('assets/'.$root.'/'.$newdate[0]))
	{
		@mkdir('assets/'.$root.'/'.$newdate[0], 0755, TRUE);
	}

	if (!is_dir('assets/'.$root.'/'.$newdate[0].'/'.$newdate[1]))
	{
		@mkdir('assets/'.$root.'/'.$newdate[0].'/'.$newdate[1], 0755, TRUE);
	}

	if (!is_dir('assets/'.$root.'/'.$newdate[0].'/'.$newdate[1].'/'.$newdate[2]))
	{
		@mkdir('assets/'.$root.'/'.$newdate[0].'/'.$newdate[1].'/'.$newdate[2], 0755, TRUE);
	}

	return 'assets/'.$root.'/'.$newdate[0].'/'.$newdate[1].'/'.$newdate[2].'/';
}



function encryptPass($password){
	return hash("sha256", $password);
	//return md5($password);
	$options = array('cost' => 9,'salt' => 'f0¾<2R¿xà![2=9¢L-!ƒ');
	$new_pass = password_hash($password, PASSWORD_BCRYPT, $options)."\n";
	return $new_pass;
}

function str_min($str, $chr){
	return strlen($str)>$chr?substr($str,0,$chr).' …':$str;
}

function rand_str($min_len = 4, $max_len = 10){
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"),rand(0,50),rand($min_len,$max_len));
}

// function simple_enc($text, $salt = "b$2!aSyu@mbs$123")
// {
//     return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
// }
// // This function will be used to decrypt data.
// function simple_dec($text, $salt = "b$2!aSyu@mbs$123")
// {
//     return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
// }
//
// function simple_enc_url($text, $salt = "b$2!aSyu@mbs$123")
// {
//     $encrypted = simple_enc($text, $salt);
//     return strtr($encrypted, '+/=', '-_:');
// }
// function simple_dec_url($text, $salt = "b$2!aSyu@mbs$123")
// {
//     $text = strtr($text, '-_:', '+/=');
//     return simple_dec($text, $salt);
// }

function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}
function escape_clean($string) {
	    //echo $string;
          $char = array( ",","<",".",">","?","/","'","\"",";",":","[","{","}","]","\\","|","`","~","!","@","#","$","^","*","(",")" );
 		  foreach($char as $c){
		          if(strpos($string, $c)>0){
					     return true;die;
				   }
			  }
}

function url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

function url_decode($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}

//getting ip address
function get_client_ip() {
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
}

function encryptid($string, $key='UNKNOWN') {
  $result = '';
  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
  }

  $s = base64_encode($result);

 return strtr(base64_encode($s), '+/=', '-_#');
}

function decryptid($string, $key='UNKNOWN') {
  $result = '';
  $string = base64_decode(strtr($string, '-_#', '+/='));
  $string = base64_decode($string);

  for($i=0; $i<strlen($string); $i++) {
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }

  return $result;
}
 function wrap_text_with_tags( $haystack, $needle , $beginning_tag='<strong>', $end_tag='</strong>' ) {
    $needle_start = stripos($haystack, $needle);
    $needle_end = $needle_start + strlen($needle);
    $return_string = substr($haystack, 0, $needle_start) . $beginning_tag . $needle . $end_tag . substr($haystack, $needle_end);
    return $return_string;
}

//~ ~~~~~~~~~~~~~~~~~~~~ get unique coupon code ~~~~~~~~~~~~~~~~~

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
