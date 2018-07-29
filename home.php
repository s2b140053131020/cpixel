<?php 
include('session.php'); 

include('dbcon.php');

 ?>
<?php
   if(isset($_FILES['e_file'])){
      $file_name = $_FILES['e_file']['name'];
      $file_size =$_FILES['e_file']['size'];
      $file_tmp =$_FILES['e_file']['tmp_name'];
      $file_type=$_FILES['e_file']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['e_file']['name'])));      
      $expensions= array("xlsx","jpg","php");
      if(in_array($file_ext,$expensions)=== false){
         $errors="Please choose Only Xlsx.";
      }
      if($file_size > 20897152){
         $errors='File size must be excately 20 MB';
      }
      if(empty($errors)==true){
		  $file_name = rand(0,1000).'-'.$file_name;
		 $new_path = "file/".$file_name;
         move_uploaded_file($file_tmp,$new_path);

         $success = "uploaded ";
		 unset($_FILES['e_file']);
      }else{
      }
   }
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="form-wrapper">
<span class ="error_message"><?php echo isset($errors)?$errors : '' ?></span>
<span class ="sucess_message"><?php echo isset($success)?$success : '' ?></span>
<form action="" method="POST" enctype="multipart/form-data">
<div class="file-upload">
    <label for="upload" class="file-upload__label">File upload</label>
    <input id="upload" class="file-upload__input" type="file" name="e_file">
</div>
 <input type="submit" class= "submit-btn"/>
</form>
</div>
</body>
</html>