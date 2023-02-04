<?php
class USER
{
    /** @var object $pdo Copy of PDO connection */
    private $db;
    /** @var string prints light user msg for errors */
    public $msg;
    /** @var string prints error message for user - DB related */
    public $error;
    /** @var string DB table used in this class */
    private $table;
    /** @var int number of permitted wrong login attempts */
    private $permitedAttempts = 5;

    function __construct($DB_con)
    {
      $this->db = $DB_con;
      $this->table = 'accounts';
    }
    

    
    /**
      Get all user account stuff
      @param string $email User email.
      @return boolean of success. 
    */
    public function getUserStuff($id) {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE user_id = ? limit 1");
        $stmt->execute([$id]);
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
          
        if($stmt->rowCount() > 0){
            return $userInfo;
        }else{
            return false;
        }
    }
    
    
    //Username Validation
    public function valid_username($username){
            if( !ctype_alnum($username) ){
                $this->msg = "Usernames can only be letters and numbers.";
                return false;
            }else if(strlen($username) < 4){
                $this->msg = "Usernames must be at least 4 characters.";
                return false;
            }else if(strlen($username) > 34){
                $this->msg = "Usernames must be less than 34 characters.";
                return false;
            }  
        return true;
    }
    
    //Email Validation
    public function valid_email($email){
            if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
                $this->msg = "You must use a valid email address.";
                return false;
            } else if(strlen($email) < 7){
                $this->msg = "Email must be at least 7 characters.";
                return false;
            }else if(strlen($email) > 34){
                $this->msg = "Email must be less than 34 characters.";
                return false;
            } 
        return true;
    }
    
    //Password Validation
    public function valid_password($password){
           /*if( ctype_alpha($password) or ctype_alnum($password)  ){
                $this->msg = "Passwords must have at least one special character and number.";
                return false;
            } else if(strlen($password) < 7){
                $this->msg = "Password must be at least 7 characters.";
                return false;
            }else if(strlen($password) > 34){
                $this->msg = "Password must be less than 34 characters.";
                return false;
            } */
        return true;
    }
    
    
    /**
      Get all user account stuff
      @param string $email User email.
      @return boolean of success. 
    */
    public function available($uname,$uemail) {
        $stmt = $this->db->prepare("SELECT user_name,user_email FROM $this->table WHERE user_name = ? OR user_email = ?");
        $stmt->execute([$uname,$uemail]);
        $availability = $stmt->fetch(PDO::FETCH_ASSOC);
          
        if($stmt->rowCount() > 0){
            $this->msg="That username or email is already taken.";
            return false;
        }else{
            return true;
        }
    }
   
    
    /*
      Create An Account
      @param string,string,string (Username,Email,Password)
      @return int - last id added to db
    */
    public function create($uname,$umail,$upass) {
       try
       {
           //hash password and create activation code
           $hash = $this->hashPass($upass);
           $activation_code = $this->hashPass(date('Y-m-d H:i:s').$umail);
            
           $stmt = $this->db->prepare("INSERT INTO $this->table(user_name, user_email, user_pass, user_ip, confirm_code) VALUES(?,?,?,?,?)");
           $stmt->execute([$uname,$umail,$hash,$this->getUserIpAddr(),$activation_code]);
           
           if($stmt->rowCount()>0){
               $lastId = $this->db->lastInsertId();
               return $lastId; 
           }
           //Shouldn't end up here - only if data goes wonky
           $this->msg = "We had trouble creating your account!";
           return false;
       }
       catch(PDOException $e) {
           error_log('HELLO! - Error Creating account function CREATE - class USER');
           error_log($e->getMessage());
           //If DB error this appears to user
           $this->error = 'We had trouble with the connection while creating your account.';
           return false;
       }    
    }
    
    
    
    
    /**
      Login function
      @param string $umail User email.
      @param string $upass User password.
      @param string $uname User name.
      @return bool Returns login success.
    */
    public function login($uname,$umail,$upass) {
       try
       {
          $stmt = $this->db->prepare("SELECT user_id,user_pass,first,wrong_logins FROM $this->table WHERE user_name=:uname OR user_email=:umail LIMIT 1");
          $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
          $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
          
          if($stmt->rowCount() > 0) {
              
            if(password_verify($upass,$userInfo['user_pass'])){
                   
                if($userInfo['wrong_logins'] <= $this->permitedAttempts){
                    return $userInfo;
                }else{
                    $this->msg = 'This user account is blocked. For your safety and ours, you will have to reset your password! Learn More';
                }
                return false;
            }else{
                
                if($userInfo['wrong_logins'] <= $this->permitedAttempts){
                    if($this->registerWrongLoginAttempt($userInfo['user_id'])):
                        $this->msg = 'Password is incorrect.';
                    else:
                        $this->msg = 'Something went wrong registering your login.';
                    endif;
                }else{
                    $this->msg = 'This user account is blocked. For your safety and ours, you will have to reset your password! Learn More';
                }
                
                return false;
            } //if password verify
          }else{//if $stmt
              $this->msg = 'That account does not exist yet.';
              return false;
          }
       }
       catch(PDOException $e) {
           //echo $e->getMessage();
           $this->error = 'Something went wrong with the connection. Please try again!';
           error_log("HELLO! Error on connect ~ Class USER - public function login", 0);
           error_log($e->getMessage());
           return false;
       }
   }
 

   /**
      Check if user is logged in
     Sets session for user_id *IMPORTANT*
      @return bool.
    */
   public function is_loggedin() {
      if(isset($_SESSION['loggedin'])){
         return true;
      }
      return false;
   }
   
    /**
      Logout the user and remove it from the session.
      @return true
    */
    public function logout() {
        $_SESSION['loggedin'] = null;
        session_destroy();
        unset($_SESSION['loggedin']);
        return true;
    }



    /**
      Register a wrong login attempt function
      @param string $email User email.
      @return void.
    */
    private function registerWrongLoginAttempt($id){
        $stmt = $this->db->prepare("UPDATE $this->table SET wrong_logins = (wrong_logins + 1) WHERE user_id = ?");
        $stmt->execute([$id]);

       if($stmt) {
           return true;
       }
        $this->error = 'Something went wrong registering your login.';
        error_log("HELLO! Error on connect ~ Class USER - public function registerWrongLoginAttempt", 0);
        error_log($e->getMessage());
        return false;
    }
      

    
    
    /**
      Get user IP when creating account
      @return string
    */
   function getUserIpAddr(){
   $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
    
    
    /**
      Do basic validation on any input
      @return value (string).
    */ 
    public function basicValidation($input)  {
        $input = trim($input);
        $input = strip_tags($input);
        $input = stripcslashes($input);
        $input = htmlspecialchars($input);
        return $input; 
    } 
   
    
    /**
      Redirect to URL
      @return void.
    */
   public function redirect($url){
       header("Location: $url");
   }
 
    /**
      Password hash function
      @param string $password User password.
      @return string $password Hashed password.
    */
    private function hashPass($pass){
        return password_hash($pass, PASSWORD_DEFAULT);
    }
    
    /**
      Print error msg function
      @return void.
    */
    public function printMsg(){
        print $this->msg;
    }
    public function printError(){
        print $this->error;
    }


    /**
      Beautifies date and time
      @return void.
    */
    public function dateTimeConvert($date){
        $newdate = new DateTime($date);
        return $newdate->format('M d, Y h:ia');
    }
   

    

}//class
