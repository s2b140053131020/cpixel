<?php 
if(isset($_REQUEST['fname']))
{
require_once('function/file_function.php'); 
$fname = $_REQUEST['fname'];
$file = fopen("file/".$fname,"r");

/* Read url */
$url_array = array();
while(! feof($file))
 {
  $url = fgetcsv($file)[0]; 
  if($url != '')
  $str1  = explode(";",$url)[0];
  if (filter_var($url, FILTER_VALIDATE_URL)) 
  {
    $url_array[] = $url;
  } 
}
fclose($file);
/* check available */
$final_array = array ();
foreach ($url_array as $str) 
{
$result__array = array();
$result__array['url'] = $str;
$result__array['status'] = get_data($str);
$final_array[] = $result__array ;   
 }
/* Write File*/
//  print_r($final_array);
 if(!empty($final_array)){
      $output = fopen("file/".$fname, "w");
     fputcsv($output,array('Url', 'Status'));       
      foreach($final_array as $row)       
     {  
       fputcsv($output, $row);  
     }       
     fclose($output);
 }
 if(isset($output))
 {
  $to = "sudhirrupani191993@gmail.com";
  $subject = "Report";
  $link = $_SERVER['HTTP_HOST'].'/file/'.$fname;

  $message = "
  <html>
  <head>
  <title>Download Report</title>
  </head>
  <body>
  <p></p>
  <table>
  <tr>
  <td><a href='$link'>Download Report</a></td>
  </tr>
  </table>
  </body>
  </html>
  ";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  mail($to,$subject,$message,$headers);
echo "sucess"; 
} 
else{
  echo "fail";
}
}
?>