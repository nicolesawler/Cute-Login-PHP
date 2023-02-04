<?php
/* 
  ❤ IMPORTANT ❤ 
 * User is not required to be logged in on this page
 */
include 'constants.php'; // ~ constants required on every page that may need login 
include 'session.php'; // ~ session start required user pages

 ?>


Hello Planet, <?php echo ($user_is_logged_in ? ' <a href="home">home</a> <a href="log-out">Log Out</a>' : '<a href="log-in">Log In</a>');