<?php
session_start();
require_once('connect.php');

if(isset($_SESSION['username']) & !empty($_SESSION['username'])){
  //$smsg = "Already Logged In" . $_SESSION['username'];
  header('location:home.php');
}

if(isset($_POST) & !empty($_POST)){
  $username = mysqli_real_escape_string($connection, $_POST['username']);
  $password = md5($_POST['password']);
  $sql = "SELECT * FROM `users` WHERE ";
  $sql .= "username='$username'";
  $sql .= " AND password='$password'";
  $sql;
  $res = mysqli_query($connection, $sql);
  $count = mysqli_num_rows($res);

  if($count == 1){
    $_SESSION['username'] = $username;
    header('location: login.php');
  }else{
    $fmsg = "User does not exist";
  }
}
?>
<html>
<head>
<title>User Login Script in PHP & MySQL</title>
<!-- Latest compiled and minified CSS -->
<?php require_once('include_link.php');?>

</head>
<body>
	<div class="container">
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Please Login</h2>
        <div class="input-group">
    		  <!-- <span class="input-group-addon" id="basic-addon1">@</span> -->
    		  <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
    		</div><br/>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      </form>
</div>
</body>
</html>
