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
if(isset($_POST['btn-login']))
{
         include 'db-user.php';// ~ connect to db and account obj

         //Validation
         //If  input is valid email, send right to variables otherwise
         //validate as username then jump to variables,
         //Otherwise display error.

         if( $account->valid_email($_POST['txt_uname_email'])  ){
            $uname = $account->basicValidation($_POST['txt_uname_email']);
            $umail = $account->basicValidation($_POST['txt_uname_email']);
         }else{
            if( $account->valid_username($_POST['txt_uname_email'])  ){
                 $uname = $account->basicValidation($_POST['txt_uname_email']);
                 $umail = $account->basicValidation($_POST['txt_uname_email']);
            }else{$msg = $error = true; }
         }
         
         if( $account->valid_password($_POST['txt_password']) ){
              $upass = $account->basicValidation($_POST['txt_password']);
         }else{$msg = $error = true; }
         
         
         if(!$error):
             
           // log user in
           if($userInfo = $account->login($uname,$umail,$upass))
           {
            //send user to homepage profile
            session_start();
            $_SESSION['loggedin'] = $userInfo['user_id'];
            $account->redirect('home');
           }
           else{
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
<title>Login</title>
<meta name="description" content="A description of the page" /><!-- 155 characters max --> 
<link href="https://fonts.googleapis.com/css?family=Port+Lligat+Sans" rel="stylesheet">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="vision">

   <section id="rotating-section">
    <div id="rotating-animation">
        <div>
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
            <div class="rect6"></div>
            <div class="rect7"></div>
            <div class="rect8"></div>
            <div class="rect9"></div>
            <div class="rect10"></div>
            <div class="rect11"></div>
            <div class="rect12"></div>
            <div class="rect13"></div>
            <div class="rect14"></div>
            <div class="rect15"></div>
            <div class="rect16"></div>
            <div class="rect17"></div>
            <div class="rect18"></div>
            <div class="rect19"></div>
            <div class="rect20"></div>
        </div>
    </div>
</section>
    
    
    <div class="form">
    <div class="box">
        <img src="opener.png" />
    </div>  
   <div class="box login">
            <form method="post" id="login-form">
                     <h2>Log in to your account</h2>
                     <p>
                     <?php
                     //error element output message
                         if($error) {
                            $account->printError();
                        }
                        if($msg) {
                            $account->printMsg();
                        }
                        ?>                      
                     </P>
                      <input type="text" class="" name="txt_uname_email" placeholder="Username or Email" value="<?php if($error){echo $account->basicValidation($_POST['txt_uname_email']);}?>" maxlength="45"/>
                      <input type="password" class="" name="txt_password" placeholder="Your Password" maxlength="45" />

                      <button type="submit" name="btn-login" class="btn btn-block btn-primary">SIGN IN</button>


                     <p>Don't have an account yet? <a href="create-account">Create one</a></p>

         </form>
    </div>  
    </div>  
    
    
    
    <footer>
        <p><span class="copyright">&copy;</span>
            <span class="green">Create</span> <span class="purple">with</span> <span class="pink">❤</span> <span class="blue">forever</span></p>
    </footer>

     
     
</div><!-- Vision container -->

</body>
</html>