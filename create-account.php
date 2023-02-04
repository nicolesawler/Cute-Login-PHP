<?php
/* 
  ❤ IMPORTANT ❤ 
 * User is not required to be logged in on this page
 */
 include 'constants.php';// ~ constants required on every page that may need login 
 include 'session.php';// ~ session start required user pages
 
 /* Send user home if already logged in
  * they don't need to be here.
  */
 if($user_is_logged_in):
       header('Location: home');
       exit();
 endif;

/* 
  ❤ Log In Button Pressed ❤ 
 */
if(isset($_POST['btn-create-account']))
{
         include 'db-user.php';// ~ connect to db and account obj

         //Validate fields
         //Reverse the order so that the errors (if any) return in sync with the display of the fields in html.
         //The error $msg will change based on the order.
         
         if( $account->valid_password($_POST['txt_password']) ){
              $upass = $account->basicValidation($_POST['txt_password']);
         }else{$msg = $error = true; }
         
         if( $account->valid_email($_POST['txt_email']) ){
              $umail = $account->basicValidation($_POST['txt_email']);
         }else{$msg = $error = true; }
         
         if($account->valid_username($_POST['txt_uname'])  ){
              $uname = $account->basicValidation($_POST['txt_uname']);
         }else{$msg = $error = true; }


         if(!$error):
            if($account->available($uname,$umail)){
                // create user account
                if($userID = $account->create($uname,$umail,$upass)):
                    //log the user in
                    session_start();
                    $_SESSION['loggedin'] = $userID;
                    //send user to account homepage
                    $account->redirect('home');
                else:
                     //otherwise display login info incorrect on error element
                      $msg = $error = true;
                endif;//create account
            }else{
                $msg = $error = true; 
            }
         endif;
}
/* 
  ❤ HTML BELOW ❤ 
 */
?>
<!DOCTYPE html>
<html lang="en" id="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name=”viewport” content="width=device-width, initial-scale=1" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<title>Create Your Account | </title>
<meta name="description" content="A description of the page" /><!-- 155 characters max --> 
<link href="https://fonts.googleapis.com/css?family=Port+Lligat+Sans" rel="stylesheet">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="vision">
    
    <div class="form">
    <div class="box space">
        <img src="opener.png" />
    </div>  
   <div class="box login">
            <form method="post" id="login-form">
                     <h2>Create your account</h2>
                     <p>
                     <?php
                     //error element output message
                         if($error) {$account->printError(); }
                         if($msg) {$account->printMsg();}
                        ?>                      
                     </P>
                     <input type="text" class="" name="txt_uname" placeholder="Choose a Username" 
                            value="<?php if($error){echo $account->basicValidation($_POST['txt_uname']);}?>" maxlength="34"/>
                     
                      <input type="text" class="" name="txt_email" placeholder="Your Email" 
                             value="<?php if($error){echo $account->basicValidation($_POST['txt_email']);}?>" maxlength="34"/>
                      
                      <input type="password" class="" name="txt_password" placeholder="Make a Password" maxlength="34" />

                      <button type="submit" name="btn-create-account" class="btn btn-block btn-primary">Ready, Let's Go</button>
                      
                     <p>Already have an account? <a href="log-in">Log in</a></p>

         </form>
    </div>  
    </div>  
    
    
    
    <footer>
        <p><span class="copyright">&copy</span> Create with <span class="pink">❤</span> by Nicole Sawler .</p>
    </footer>

     
     
</div><!-- Vision container -->

</body>
</html>