<?php
session_start();
require_once('connect.php');
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: login.php');
}
$username = $_SESSION['username'];
?>

<html>
<head>
<title>upload File</title>
<!-- Latest compiled and minified CSS -->
<?php require_once('include_link.php');?>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">User Area</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
  	<!-- <div class="col-sm-3">

	</div> -->
	<div class="col-sm-9">
    <form class="form-signin" method="POST">
      <h2 class="form-signin-heading">Please Login</h2>
      <div class="input-group">
      <span class="input-group-addon" id="basic-addon1">URL</span></br>
        <input type="text" name="url" id="URL" class="form-control" placeholder="URL" required>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
    </form>
	</div>
</div>
</body>
</html>

<?php
if(isset($_POST['url']))
{$url = $_POST['url'];}

if(isset($url)){
    $ch = curl_init( $url);
    curl_setopt( $ch, CURLOPT_USERAGENT, "Internet Explorer" );
    ob_start();
    curl_exec( $ch );
    curl_close( $ch );
    $data = ob_get_contents();
    ob_end_clean();

    function strpos_array($haystack, $needles) {
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
/* give content and keyword */

$res = strpos_array($data, array('https://connect.facebook.net/en_US/fbevents.js', "fbq('init'",'pixel','Facebook Pixel'));
if(isset($res)){
//$sucess = 'found';
?>
<div class="alert alert-success fade in">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Success!</strong> Found.
</div>
<?php
}else{
	//$sucess = 'Not Found';
  ?>
  <div class="alert alert-danger fade in">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Error!</strong> Not Found
  </div>
  <?php
}

}
?>
