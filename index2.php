<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge Two</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
<?php
?>
<form action="actions/login.php" method="post">
  <div class="container">
    <label for="email"><b>Email address</b></label>
    <input type="email" placeholder="Enter Email address" name="email" required>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <button type="submit">Login</button>
  </div>
</form>
</body>
</html>