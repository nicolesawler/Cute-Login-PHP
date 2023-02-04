<?php
/* 
  ❤ IMPORTANT ❤ 
 */
include 'constants.php'; // ~ constants required on every page that may need login 
//User is required to be logged in on this page
$restricted = true;
include 'session.php'; // ~ session start required user pages
include 'db-user.php'; // ~ connect to db and account obj

//$_SESSION['loggedin']

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
      <link href="https://fonts.googleapis.com/css?family=Port+Lligat+Sans" rel="stylesheet">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin" id='home'>
		<nav class="">
			<div>
				<h1>Welcome Home, USER NAME</h1>
			</div>
		</nav>
           

  
    <div class="foot-content">
   <div class='ajduke'>
    Made with <i class="fa fa-heart" aria-hidden="true"></i> in Halifax, NS by <a href="https://nicolesawler.com">Nicole Sawler</a> | <a href="log-out.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
   </div>

  </div>
</div>
	</body>
</html>