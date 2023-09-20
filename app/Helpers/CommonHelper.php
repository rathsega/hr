<?php
// import facade 
use Illuminate\Support\Facades\File;


//All common helper functions
if (!function_exists('get_phrase')) {
    function get_phrase($phrase = "", $replaces = array())
    {
        if(!is_array($replaces)){
            $replaces = array($replaces);
        }
        foreach ($replaces as $replace) {
            $phrase = preg_replace('/____/', $replace, $phrase, 1); // Replace one placeholder at a time
        }

        return $phrase;
    }
}

//All common helper functions
if (!function_exists('get_image')) {
    function get_image($url = null, $optimized = false)
    {
        if ($url == null)
            return asset('uploads/placeholder/placeholder.svg');

        //If the value of URL is from an online URL
        if (str_contains($url, 'http://') && str_contains($url, 'https://'))
            return $url;

        $url_arr = explode('/', $url);
        //File name & Folder path
        $file_name = $url_arr[count($url_arr) - 1];
        $path = str_replace($file_name, '', $url);

        if ($optimized) {
            //Optimized image url
            $optimized_image = $path . 'optimized/' . $file_name;
            if (is_file(public_path($optimized_image)) && file_exists(public_path($optimized_image))) {
                return asset($optimized_image);
            } else {
                return asset($optimized_image . 'placeholder/placeholder.png');
            }
        } else {
            if (is_file(public_path($url)) && file_exists(public_path($url))) {
                return asset($url);
            } else {
                return asset($path . 'placeholder/placeholder.png');
            }
        }
    }
}

// Global Settings
if (!function_exists('remove_file')) {
    function remove_file($url = null)
    {
        $url = public_path($url);
        $url = str_replace('optimized/', '', $url);
        $url_arr = explode('/', $url);
        $file_name = $url_arr[count($url_arr) - 1];

        if (is_file($url) && file_exists($url) && !empty($file_name)) {
            unlink($url);

            $url = str_replace($file_name, 'optimized/' . $file_name, $url);
            if (is_file($url) && file_exists($url)) {
                unlink($url);
            }
        }
    }
}

if (!function_exists('script_checker')) {
    function script_checker($string = '', $convert_string = true)
    {

        if ($convert_string == true) {
            $string = nl2br(htmlspecialchars($string));
        } else {
            //make script to string
            $string = str_replace("<script>", "&lt;script&gt;", $string);
            $string = str_replace("</script>", "&lt;/script&gt;", $string);

            //removing <script> tags
            $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $string);
            $string = preg_replace("/[<][^<]*script.*[>].*[<].*[\/].*script*[>]/i", "", $string);

            //removing inline js events
            $string = preg_replace("/([ ]on[a-zA-Z0-9_-]{1,}=\".*\")|([ ]on[a-zA-Z0-9_-]{1,}='.*')|([ ]on[a-zA-Z0-9_-]{1,}=.*[.].*)/", "", $string);

            //removing inline js
            $string = preg_replace("/([ ]href.*=\".*javascript:.*\")|([ ]href.*='.*javascript:.*')|([ ]href.*=.*javascript:.*)/i", "", $string);
        }

        return $string;
    }
}

if (!function_exists('date_formatter')) {
    function date_formatter($strtotime = "", $format = "")
    {
        if ($strtotime && !is_numeric($strtotime)) {
            $strtotime = strtotime($strtotime);
        } elseif (!$strtotime) {
            $strtotime = time();
        }

        if ($format == "") {
            return date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime);
        }

        if ($format == 1) {
            return date('D', $strtotime) . ', ' . date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime);
        }

        if ($format == 2) {
            $time_difference = time() - $strtotime;
            if ($time_difference <= 10) {
                return get_phrase('Just now');
            }
            //864000 = 10 days
            if ($time_difference > 864000) {
                return date_formatter($strtotime, 3);
            }

            $condition = array(
                12 * 30 * 24 * 60 * 60    => get_phrase('year'),
                30 * 24 * 60 * 60        =>  get_phrase('month'),
                24 * 60 * 60            =>  get_phrase('day'),
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
            );

            foreach ($condition as $secs => $str) {
                $d = $time_difference / $secs;
                if ($d >= 1) {
                    $t = round($d);
                    return $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ' . get_phrase('ago');
                }
            }
        }

        if ($format == 3) {
            $date = date('d', $strtotime);
            $date .= ' ' . date('M', $strtotime);

            if (date('Y', $strtotime) != date('Y', time())) {
                $date .= date(' Y', $strtotime);
            }

            $date .= ' ' . get_phrase('at') . ' ';
            $date .= date('h:i a', $strtotime);
            return $date;
        }

        if ($format == 4) {
            return date('d', $strtotime) . ' ' . date('M', $strtotime) . ' ' . date('Y', $strtotime) . ', ' . date('h:i:s A', $strtotime);
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
        if ($lowercase) {
            $randVal = strtolower($randVal);
        }
        return $randVal;
    }
}


if (!function_exists('get_settings')) {
    function get_settings($type = "", $decode = false)
    {
        $value = DB::table('settings')->where('type', $type)->value('description');
        if ($decode === true) {
            return json_decode($value, true);
        } else {
            return $value;
        }
    }
}


// Global Settings
if (!function_exists('set_config')) {
    function set_config($key = '', $value = '')
    {
        $config = json_decode(file_get_contents(base_path('config/config.json')), true);

        $config[$key] = $value;

        file_put_contents(base_path('config/config.json'), json_encode($config));
    }
}

if (!function_exists('currency')) {
    function currency($price = null)
    {
        $currency_code = App\Models\Currency::where('id', get_settings('system_currency'))->value('code');
        if ($price === null) {
            return $currency_code;
        } else {
            return number_format($price) . ' ' . $currency_code;
        }
    }
}

if (!function_exists('getCurrentLocation')) {
    function getCurrentLocation($lat = 0, $long = 0)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$long&zoom=18",
            CURLOPT_VERBOSE => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: Creativeitem Workplace'
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);


        if ($response) {
            $location = json_decode($response, true)['display_name'];
            $location_arr = explode(",", $location);
            $name = null;
            foreach ($location_arr as $key => $location_name) {
                if ($key == 4) break;
                if ($key > 0) {
                    $name .= ',' . $location_name;
                } else {
                    $name .= $location_name;
                }
            }
            return $name;
        } else {
            return null;
        }
    }
}
