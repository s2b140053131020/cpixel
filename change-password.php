<?php

session_start();
if (!isset($_SESSION['username']) & empty($_SESSION['username'])) {
    header('location: index.php');
}
$username = $_SESSION['username'];
  require_once 'connect.php';  
if(isset($_POST) & !empty($_POST)){
  $cpass = md5($_POST['cpass']);
  $newpass = md5($_POST['newpass']);
  $newpass1 = md5($_POST['newpass1']);

  $passsql = "SELECT * FROM `users` WHERE username='$username'";
  $passres = mysqli_query($connection, $passsql);
  $passr = mysqli_fetch_assoc($passres);
  if($cpass == $passr['password']){
    if($newpass == $newpass1){
      $passusql = "UPDATE `users` SET password='$newpass' WHERE username='$username'";
      $passures = mysqli_query($connection, $passusql);
      if($passures){
		?>		
		<div class="alert alert-success fade in">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Success!</strong> Password successfully update.
		</div>
 <?php
	  }
    }
	else{
		?>
		<div class="alert alert-danger fade in">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Error!</strong> Not match
		</div>
      <?php
	}
  }
  else{
	?>
		<div class="alert alert-danger fade in">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Error!</strong> Not match
		</div>
      <?php
  }
}

?>

<html>
<head>
<title>update Password</title>

<?php require_once 'function/include_link.php';?>
</head>

<body>
<?php require_once 'header_navigation.php';?>	  
<div class="container text-center">
	<div class="col-sm-2"></div>	  
	<div class="col-sm-8">
  	<div class="panel panel-default">
			<div class="panel-heading"><h4>Change Password</h4></div>
		  <div class="panel-body">

          <div class="col-sm-6 col-centered">
            <form method="post" class="form-horizontal">

                  <div class="form-group">
                      <label for="input1" class="col-sm-4 control-label">Current Password</label>
                      <div class="col-sm-8">
                        <input type="password" name="cpass" class="form-control" placeholder="Current Password">
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="input1" class="col-sm-4 control-label">New Password</label>
                      <div class="col-sm-8">
                        <input type="password" name="newpass" class="form-control" placeholder="New Password">
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="input1" class="col-sm-4 control-label">Repeat Again</label>
                      <div class="col-sm-8">
                        <input type="password" name="newpass1" class="form-control" placeholder="Repeat New Password" required>
                      </div>
                  </div>

                  <input type="submit" class="btn btn-primary col-md-3 col-md-offset-9" value="Update">
            </form> 
          </div>
            <!-- /.box-body -->
          			</div>
          <!-- /.box -->
        		</div>
	</div>
	<div class="col-sm-2"></div>	  
		</div>
	</div>
</div>
</body>
</html>