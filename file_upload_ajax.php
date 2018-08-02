<?php
if(isset($_FILES['e_file'])){
    $file_name = $_FILES['e_file']['name'];
    $file_size =$_FILES['e_file']['size'];
    $file_tmp =$_FILES['e_file']['tmp_name'];
    $file_type=$_FILES['e_file']['type'];
    $tmp = explode('.', $_FILES['e_file']['name']);
    $file_extension = end($tmp);
    $file_ext=strtolower($file_extension);      
    $expensions= array("xlsx","csv","php");
    if(in_array($file_ext,$expensions)=== false){
       $errors="Please choose Only Xlsx.";
    }
    if($file_size > 20897152){
       $errors='File size must be excately 20 MB';
    }
    if(empty($errors)==true){
        $date = date('Y-m-d-i-s', time());
        $file_name = $date.'-'.$file_name;
        $new_path = "file/".$file_name;
        move_uploaded_file($file_tmp,$new_path);
       //include database configuration file
        require_once('connect.php'); 
        //insert form data in the database
        $insert = $connection->query("INSERT form_data (file_name) VALUES ('".$file_name."')");
         echo $insert?$file_name:'err';
    }else{
    }
 }

?>