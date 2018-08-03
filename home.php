<?php
session_start();
if (!isset($_SESSION['username']) & empty($_SESSION['username'])) {
    header('location: index.php');
}
$username = $_SESSION['username'];
?>

<html>
<head>
<title>upload File</title>
<!-- Latest compiled and minified CSS -->
<?php require_once 'function/include_link.php';?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" >
</head>
<body>

<?php require_once 'header_navigation.php';?>
<div class="container">
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-10">
    <p class="statusMsg"></p>
    <form enctype="multipart/form-data" id="fupForm" >
        <div class="form-group">
            <input type="file" class="form-control" id="file" name="e_file"style="display:inline-block; width:80%" required />
            <input type="submit" name="submit" class="btn btn-danger submitBtn"style="display:inline-block;" value="UPLOAD"/>
        </div>
    </form>
    <button class="btn btn-success" id ="get_start" filename="119-abc.csv" >Start Process</button>

<div id ="pbar" class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar"
  aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
  processing.....
  </div>
</div>	
</div>
    
</div>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-10">
<hr>
<h2>Uploded File </h2>
<hr>
<table id="resultdata" class="table table-striped table-bordered" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>File Name</th>
          <th>Status</th>
          <th>Download</th>
		  <th>Date</th>
        </tr>
      </thead>
      <tbody>
	  <?php 
  require_once 'connect.php';  
	$sql = "SELECT * FROM `form_data` WHERE status = 1  ORDER BY `create_at` DESC";
    $res = mysqli_query($connection, $sql);
	$i=1;
	while($row = mysqli_fetch_assoc($res)){
 	  ?>
        <tr>
          <th scope="row"><?php  echo $i; ?></th>
          <td><?php  echo $row['file_name']; ?></td>
          <td class ="text-success">Done</td>
          <td><a href="file/<?php  echo $row['file_name']; ?>"><img src="img/dwn.ico" class="dwn"></a></td>
		   <td><?php  echo $row['create_at']; ?></td>
        </tr>
		
<?php 
$i++;
}
?>
      </tbody>
    </table>
	
</div>
</div>
</body>
</html>
<script>
$(document).ready(function(e){
    $("#fupForm").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'file_upload_ajax.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#fupForm').css("opacity",".5");
            },
            success: function(msg){
                $('.statusMsg').html('');
                if(msg == 'err'){
                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
                }else{
                    $('#get_start').show(100);
                    $('#get_start').attr( "filename",msg);
                    $('#fupForm')[0].reset();
                    $('.statusMsg').html('<span style="font-size:18px;color:#34A853">File Uploaded successfully.</span>');

                }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    });

$('#get_start').click(function(){
	$('#pbar').show(100);
var fname = $('#get_start').attr( "filename");
$.ajax
({
    url: 'readfile.php',
    data: {"fname": fname},
    type: 'post',
    success: function(result)
    {
		$('#pbar').hide(100);
        $('#get_start').hide(1000);
		location.reload(true);
    }
});
});
    //file type validation
    $("#file").change(function() {
		$('#pbar').hide(100);
        var file = this.files[0];
        var imagefile = file.name;
        a = imagefile.split('.');
       filext = a[1];
        console.log(filext);
        var match= ["xlsx","csv"];
        if(!((filext==match[0]) || (filext==match[1]) || (filext==match[2]))){
            alert('Please select a valid image file.');
            $("#file").val('');
            return false;
        }
    });
});
$(document).ready(function() {
    $('#resultdata').DataTable();
} );
</script>