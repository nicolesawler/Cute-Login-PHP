<?php
/* 
  ❤ You Are Here. ❤ 
 */

//STart the session
session_start();

// If the page is restricted (meaning it requires being logged in to be on it)
// Users who are not logged in will be redirected to the log-in.php page
if($restricted):
 if (!isset($_SESSION['loggedin'])) :
       header('Location: log-in');
       exit();
 endif;
 $user_is_logged_in = true;
endif;

//If page is not restricted/does not require a log in, but the user is in fact logged in. 
//Put that in a variable in case;
if(!$restricted):
    if (isset($_SESSION['loggedin'])) :
          $user_is_logged_in = true;
    endif;
endif;