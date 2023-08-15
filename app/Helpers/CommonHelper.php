<?php
// import facade 
use Illuminate\Support\Facades\File;


//All common helper functions
if (! function_exists('get_phrase')) {
    function get_phrase($phrase = "") {
        return $phrase;
    }
}

//All common helper functions
if (! function_exists('get_image')) {
    function get_image($image_path = "") {
        if(!is_file(public_path($image_path))){
            return asset('public/'.$image_path.'default.png');
        }

        if(file_exists(public_path($image_path))){
            return asset('public/'.$image_path);
        }else{
            $image_path_arr = explode('/', $image_path);
            $file_name = end($image_path_arr);
            return asset('public/'.str_replace($file_name, 'default.png', $image_path));
        }
    }
}

if (! function_exists('remove_scripts')) {
    function script_checker($string = '', $convert_string = true) {

        if($convert_string == true){
            $string = nl2br(htmlspecialchars($string));
        }else{
            //make script to string
            $string = str_replace("<script>","&lt;script&gt;", $string);
            $string = str_replace("</script>","&lt;/script&gt;", $string);

            //removing <script> tags
            $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
            $string = preg_replace("/[<][^<]*script.*[>].*[<].*[\/].*script*[>]/i","",$string);

            //removing inline js events
            $string = preg_replace("/([ ]on[a-zA-Z0-9_-]{1,}=\".*\")|([ ]on[a-zA-Z0-9_-]{1,}='.*')|([ ]on[a-zA-Z0-9_-]{1,}=.*[.].*)/","",$string);

            //removing inline js
            $string = preg_replace("/([ ]href.*=\".*javascript:.*\")|([ ]href.*='.*javascript:.*')|([ ]href.*=.*javascript:.*)/i","",$string);
        }

        return $string;
    }
}

if (!function_exists('date_formatter')) {
    function date_formatter($strtotime = "", $format = "")
    {
        if($strtotime && !is_numeric($strtotime)){
            $strtotime = strtotime($strtotime);
        }elseif(!$strtotime){
            $strtotime = time();
        }

        if ($format == "") {
            return date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime);
        }

        if ($format == 1) {
            return date('D', $strtotime) . ', ' . date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime);
        }

        if($format == 2){
        	$time_difference = time() - $strtotime;
	        if( $time_difference <= 10 ) { return get_phrase('Just now'); }
	        //864000 = 10 days
	        if($time_difference > 864000){ return date_formatter($strtotime, 3); }

	        $condition = array(
	        	12 * 30 * 24 * 60 * 60	=> get_phrase('year'),
	        	30 * 24 * 60 * 60		=>  get_phrase('month'),
	        	24 * 60 * 60            =>  get_phrase('day'),
	        	60 * 60                 =>  'hour',
	        	60                      =>  'minute',
	        	1                       =>  'second'
	        );

	        foreach( $condition as $secs => $str ){
	            $d = $time_difference / $secs;
	            if( $d >= 1 ){
	                $t = round( $d );
                    return $t .' '. $str . ( $t > 1 ? 's' : '' ) .' '. get_phrase('ago');
	            }
	        }
        }

        if ($format == 3) {
            $date = date('d', $strtotime);
            $date .= ' '. date('M', $strtotime);

            if(date('Y', $strtotime) != date('Y', time())){
                $date .= date(' Y', $strtotime);
            }

            $date .= ' '.get_phrase('at').' ';
            $date .= date('h:i a', $strtotime);
            return $date;
        }

        if ($format == 4) {
            return date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime). ', ' . date('h:i:s A', $strtotime);
        }
    }
}


if (!function_exists('slugify')) {
    function slugify($string)
    {
        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
        $string = trim($string, '-');
        return strtolower($string);
    }
}


if (!function_exists('ellipsis')) {
    function ellipsis($long_string, $max_character = 30)
    {
        $long_string = strip_tags($long_string);
        $short_string = strlen($long_string) > $max_character ? mb_substr($long_string, 0, $max_character) . "..." : $long_string;
        return $short_string;
    }
}



// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (!function_exists('random')) {
    function random($length_of_string, $lowercase = false)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        $randVal = substr(str_shuffle($str_result), 0, $length_of_string);
        if($lowercase){
        	$randVal = strtolower($randVal);
        }
        return $randVal;
    }
}


if (! function_exists('get_settings')) {
    function get_settings($type = "", $decode = "") {
        $value = DB::table('settings')->where('type', $type)->value('description');
        if($decode != ""){
            return json_decode($value, true);
        }else{
            return $value;
        }
    }
}


// file remove on delete and update 

if (! function_exists('removeFile')) {
    function removeFile($path = "") {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}


// Global Settings
if (!function_exists('set_config')) {
    function set_config($key = '', $value='')
    {
        $config = json_decode(file_get_contents(base_path('config/config.json')), true);

        $config[$key] = $value;

        file_put_contents(base_path('config/config.json'), json_encode($config));
    }
}

function getCurrentLocation($lat = 0, $long = 0){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => `https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$long&zoom=18`,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    if($response){
        return json_decode($response, true)['display_name'];
    }else{
        return null;
    }
    

}




