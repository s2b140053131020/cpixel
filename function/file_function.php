<?php 
 function strpos_array($haystack, $needles) 
 {
    if ( is_array($needles) ) {
        foreach ($needles as $str) {
            if ( is_array($str) ) {
                $pos = strpos_array($haystack, $str);
            } else {
                $pos = strpos($haystack, $str);
            }
            if ($pos !== FALSE) {
                return $pos;
            }
        }
    } else {
        return strpos($haystack, $needles);
    }
  }
function get_data($url)
{
if(isset($url))
{
  $ch = curl_init( $url);
  curl_setopt( $ch, CURLOPT_USERAGENT, "Internet Explorer" );
  ob_start();
  curl_exec( $ch );
  curl_close( $ch );
  $data = ob_get_contents();
  ob_end_clean();

/* give content and keyword */
  $res = strpos_array($data, array('https://connect.facebook.net/en_US/fbevents.js', "fbq('init'",'pixel','Facebook Pixel'));
  if(isset($res))
    {
      return'Yes';
    }
  else
    {
      return 'No';
    }
} 
}
?>