<?php
session_start();
require_once 'connect.php';
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
            <input type="submit" name="submit" class="btn btn-danger submitBtn"style="display:inline-block;" value="SAVE"/>
        </div>
    </form>
    <button class="btn btn-success" id ="get_start" filename="119-abc.csv" >Start Process</button>
        </div>
    
</div>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-10">
<hr>
<h2>Uploded</h2>
<hr>
<table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>File Name</th>
          <th>Status</th>
          <th>Download</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>fb</td>
          <td>progress</td>
          <td><a href="#">download</a></td>
        </tr>

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
                    $('.statusMsg').html('<span style="font-size:18px;color:#34A853">Form data submitted successfully.</span>');

                }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
            }
        });
    });

$('#get_start').click(function(){
    $('.get_start').attr("disabled","disabled");
    $('#get_start').css("opacity",".5");
var fname = $(this).attr( "filename");
$.ajax
({
    url: 'readfile.php',
    data: {"fname": fname},
    type: 'post',
    success: function(result)
    {
        $('#get_start').hide(1000);
        $('#get_start').css("opacity","");
        $(".get_start").removeAttr("disabled");
    }
});
});

    //file type validation
    $("#file").change(function() {
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
</script>