<?PHP
/*
    Registration/Login script from HTML Form Guide
    V1.0

    This program is free software published under the
    terms of the GNU Lesser General Public License.
    http://www.gnu.org/copyleft/lesser.html
    

This program is distributed in the hope that it will
be useful - WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.

For updates, please visit:
http://www.html-form-guide.com/php-form/php-registration-form.html
http://www.html-form-guide.com/php-form/php-login-form.html

*/
require_once("/home/CEN4010_S2018g03/public_html/FAUOWLS/security/include/class.phpmailer.php");
require_once("/home/CEN4010_S2018g03/public_html/FAUOWLS/security/include/formvalidator.php");

class FGMembersite
{
    var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
    
    //-----Initialization -------
    function FGMembersite()
    {
        $this->sitename = 'YourWebsiteName.com';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
    
    function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host  = $host;
        $this->username = $uname;
        $this->pwd  = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
        
    }
    function SetAdminEmail($email)
    {
        $this->admin_email = $email;
    }
    
    function SetWebsiteName($sitename)
    {
        $this->sitename = $sitename;
    }
    
    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
    
    //-------Main Operations ----------------------
    function RegisterUser()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateRegistrationSubmission())
        {
            return false;
        }
        
        $this->CollectRegistrationSubmission($formvars);
        
        if(!$this->SaveToDatabase($formvars))
        {
            return false;
        }
        
        if(!$this->SendUserConfirmationEmail($formvars))
        {
            return false;
        }

        $this->SendAdminIntimationEmail($formvars);
        
        return true;
    }

    function ConfirmUser()
    {
        if(empty($_GET['code'])||strlen($_GET['code'])<=10)
        {
            $this->HandleError("Please provide the confirm code");
            return false;
        }
        $user_rec = array();
        if(!$this->UpdateDBRecForConfirmation($user_rec))
        {
            return false;
        }
        
        $this->SendUserWelcomeEmail($user_rec);
        
        $this->SendAdminIntimationOnRegComplete($user_rec);
        
        return true;
    }    
    
    function Login()
    {
        if(empty($_POST['username']))
        {
            $this->HandleError("UserName is empty!");
            return false;
        }
        
        if(empty($_POST['password']))
        {
            $this->HandleError("Password is empty!");
            return false;
        }
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(!isset($_SESSION)){ session_start(); }
        if(!$this->CheckLoginInDB($username,$password))
        {
            return false;
        }
        
        $_SESSION[$this->GetLoginSessionVar()] = $username;
        
        return true;
    }
    
    function CheckLogin()
    {
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }


    function UserFullName()
    {
        return isset($_SESSION['name_of_user'])?$_SESSION['name_of_user']:'';
    }
    
    function UserEmail()
    {
        return isset($_SESSION['email_of_user'])?$_SESSION['email_of_user']:'';
    }
	
    function LogOut()
    {
        session_start();
        
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar]=NULL;
        
        unset($_SESSION[$sessionvar]);
    }
    
    function EmailResetPasswordLink()
    {
        //if(empty($_POST['email']))
		if(empty($_POST['FAU_email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        $user_rec = array();
        //if(false === $this->GetUserFromEmail($_POST['email'], $user_rec))
		if(false === $this->GetUserFromEmail($_POST['FAU_email'], $user_rec))
        {
            return false;
        }
        if(false === $this->SendResetPasswordLink($user_rec))
        {
            return false;
        }
        return true;
    }
    
    function ResetPassword()
    {
        //if(empty($_GET['email']))
		if(empty($_POST['FAU_email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        if(empty($_GET['code']))
        {
            $this->HandleError("reset code is empty!");
            return false;
        }
        //$email = trim($_GET['email']);
		$email = trim($_POST['FAU_email']);
        $code = trim($_GET['code']);
        
        if($this->GetResetPasswordCode($email) != $code)
        {
            $this->HandleError("Bad reset code!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($email,$user_rec))
        {
            return false;
        }
        
        $new_password = $this->ResetUserPasswordInDB($user_rec);
        if(false === $new_password || empty($new_password))
        {
            $this->HandleError("Error updating new password");
            return false;
        }
        
        if(false == $this->SendNewPassword($user_rec,$new_password))
        {
            $this->HandleError("Error sending new password");
            return false;
        }
        return true;
    }
    
    function ChangePassword()
    {
        if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['oldpwd']))
        {
            $this->HandleError("Old password is empty!");
            return false;
        }
        if(empty($_POST['newpwd']))
        {
            $this->HandleError("New password is empty!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($this->UserEmail(),$user_rec))
        {
            return false;
        }
        
        $pwd = trim($_POST['oldpwd']);
        
        if($user_rec['password'] != md5($pwd))
        {
            $this->HandleError("The old password does not match!");
            return false;
        }
        $newpwd = trim($_POST['newpwd']);
        
        if(!$this->ChangePasswordInDB($user_rec, $newpwd))
        {
            return false;
        }
        return true;
    }
    
    //-------Public Helper functions -------------
    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
    }
    
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    //-------Private Helper functions-----------
    
    function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n mysqlerror:".mysqli_error($this->connection));
    }
    
    function GetFromAddress()
    {
        if(!empty($this->from_address))
        {
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="nobody@$host";
        return $from;
    } 
    
    function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
    function CheckLoginInDB($username,$password)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }          
        $username = $this->SanitizeForSQL($username);
        $pwdmd5 = md5($password);
        #$qry = "Select name, email from $this->tablename where username='$username' and password='$pwdmd5' and confirmcode='y'";
		$qry = "Select first_name, last_name, FAU_email from $this->tablename where username='$username' and password='$pwdmd5' and confirmcode='y'";
		
        $result = mysqli_query($this->connection,$qry);

        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("Error logging in. The username or password does not match");
            return false;
        }

        $row = mysqli_fetch_assoc($result);
        
        //$_SESSION['name_of_user']  = $row['name'];
		$_SESSION['name_of_user']  = $row['first_name'].' '.$row['last_name'];
		
        //$_SESSION['email_of_user'] = $row['email'];
		$_SESSION['email_of_user'] = $row['FAU_email'];
        
        return true;
    }
    
    function UpdateDBRecForConfirmation(&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        //$result = mysqli_query($this->connection,"Select name, email from $this->tablename where confirmcode='$confirmcode'");
		$result = mysqli_query($this->connection,"Select first_name, last_name, FAU_email from $this->tablename where confirmcode='$confirmcode'"); 
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("Wrong confirm code.");
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        
		//$user_rec['name'] = $row['name'];
		$user_rec['first_name'] = $row['first_name'];
		$user_rec['last_name'] = $row['last_name'];
		
        //$user_rec['email']= $row['email'];
		$user_rec['FAU_email']= $row['FAU_email'];
        
        $qry = "Update $this->tablename Set confirmcode='y' Where  confirmcode='$confirmcode'";
        
        if(!mysqli_query($this->connection,$qry))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$qry");
            return false;
        }
        return true;
    }
    
    function ResetUserPasswordInDB($user_rec)
    {
        $new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->ChangePasswordInDB($user_rec,$new_password))
        {
            return false;
        }
        return $new_password;
    }
    
    function ChangePasswordInDB($user_rec, $newpwd)
    {
        $newpwd = $this->SanitizeForSQL($newpwd);
        
        //$qry = "Update $this->tablename Set password='".md5($newpwd)."' Where  id_user=".$user_rec['id_user']."";
        $qry = "Update $this->tablename Set password='".md5($newpwd)."' Where  z_num=".$user_rec['z_num']."";
		
        if(!mysqli_query($this->connection,$qry))
        {
            $this->HandleDBError("Error updating the password \nquery:$qry");
            return false;
        }     
        return true;
    }
    
    function GetUserFromEmail($email,&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $email = $this->SanitizeForSQL($email);
        
        //$result = mysqli_query($this->connection,"Select * from $this->tablename where email='$email'");
		$result = mysqli_query($this->connection,"Select * from $this->tablename where FAU_email='$email'");

        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("There is no user with email: $email");
            return false;
        }
        $user_rec = mysqli_fetch_assoc($result);

        
        return true;
    }
    
    function SendUserWelcomeEmail(&$user_rec)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        //$mailer->AddAddress($user_rec['email'],$user_rec['name']);
		//$name = $user_rec['first_name'] . ' ' . $user_rec['last_name'];
		$mailer->AddAddress($user_rec['FAU_email'], $user_rec['first_name'] . ' ' . $user_rec['last_name']);
        
        $mailer->Subject = "Welcome to ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        //$mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
        $mailer->Body ="Hello " . $user_rec['first_name'] . ' ' . $user_rec['last_name'] . "\r\n\r\n".
		"Welcome! Your registration  with ".$this->sitename." is completed.\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("Failed sending user welcome email.");
            return false;
        }
        return true;
    }
    
    function SendAdminIntimationOnRegComplete(&$user_rec)
    {
        if(empty($this->admin_email))
        {
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        //$mailer->Subject = "Registration Completed: ".$user_rec['name'];
		//$name = user_rec['first_name'] . ' ' . user_rec['last_name'];
		$mailer->Subject = "Registration Completed: " . user_rec['first_name'] . ' ' . user_rec['last_name'];
		
        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        //"Name: ".$user_rec['name']."\r\n".
		"Name: " . user_rec['first_name'] . ' ' . user_rec['last_name'] . "\r\n".
        //"Email address: ".$user_rec['email']."\r\n";
        "Email address: ".$user_rec['FAU_email']."\r\n";
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function GetResetPasswordCode($email)
    {
       return substr(md5($email.$this->sitename.$this->rand_key),0,10);
    }
    
    function SendResetPasswordLink($user_rec)
    {
        //$email = $user_rec['email'];
        $email = $user_rec['FAU_email'];
		
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        //$mailer->AddAddress($email,$user_rec['name']);
		//$name = user_rec['first_name'] . ' ' . user_rec['last_name'];
        $mailer->AddAddress($email , $user_rec['first_name'] . ' ' . $user_rec['last_name']);
		
        $mailer->Subject = "Your reset password request at ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $link = $this->GetAbsoluteURLFolder().
                '/resetpwd.php?email='.
                urlencode($email).'&code='.
                urlencode($this->GetResetPasswordCode($email));

        //$mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
		$mailer->Body ="Hello " . user_rec['first_name'] . ' ' . user_rec['last_name'] . "\r\n\r\n".
        "There was a request to reset your password at ".$this->sitename."\r\n".
        "Please click the link below to complete the request: \r\n".$link."\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SendNewPassword($user_rec, $new_password)
    {
        //$email = $user_rec['email'];
		$email = $user_rec['FAU_email'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        //$mailer->AddAddress($email,$user_rec['name']);
        //$name = user_rec['first_name'] . ' ' . user_rec['last_name'];
		$mailer->AddAddress($email, $user_rec['first_name'] . ' ' . $user_rec['last_name']);
		
        $mailer->Subject = "Your new password for ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        //$mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
		$mailer->Body ="Hello " . user_rec['first_name'] . ' ' . user_rec['last_name'] . "\r\n\r\n".
        "Your password is reset successfully. ".
        "Here is your updated login:\r\n".
        "username:".$user_rec['username']."\r\n".
        "password:$new_password\r\n".
        "\r\n".
        "Login here: ".$this->GetAbsoluteURLFolder()."/login.php\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }    
    
    function ValidateRegistrationSubmission()
    {
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        //$validator->addValidation("name","req","Please fill in Name");
		$validator->addValidation("first_name","req","Please fill in First Name");
		$validator->addValidation("last_name","req","Please fill in Last Name");
		
        $validator->addValidation("FAU_email","email","Input for 'FAU Email Address' should be a valid email value");
        $validator->addValidation("FAU_email","req","Please fill in 'FAU Email Address'");
        $validator->addValidation("username","req","Please fill in 'FAU Username'");
        $validator->addValidation("password","req","Please fill in 'Password'");

        
        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }        
        return true;
    }
    
    function CollectRegistrationSubmission(&$formvars)
    {
        //$formvars['name'] = $this->Sanitize($_POST['name']);
		$formvars['z_num'] = $this->Sanitize($_POST['z_num']);
		$formvars['first_name'] = $this->Sanitize($_POST['first_name']);
		$formvars['last_name'] = $this->Sanitize($_POST['last_name']);
		
        //$formvars['email'] = $this->Sanitize($_POST['email']);
		$formvars['FAU_email'] = $this->Sanitize($_POST['FAU_email']);
		
        $formvars['username'] = $this->Sanitize($_POST['username']);
        $formvars['password'] = $this->Sanitize($_POST['password']);
    }
    
	/*
	//new
	function GetFullName(&$formvars)
	{
		return $formvars['first_name'].' '.$formvars['last_name'];
	}
	*/
	
    function SendUserConfirmationEmail(&$formvars)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        //$mailer->AddAddress($formvars['email'],$formvars['name']);
		//$name = GetFullName($formvars);
        $mailer->AddAddress($formvars['FAU_email'],$formvars['first_name'].' '.$formvars['last_name']);
		
        $mailer->Subject = "Your registration with ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
        
        $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
        
        //$mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
		$mailer->Body ="Hello ".$formvars['first_name'].' '.$formvars['last_name']."\r\n\r\n".
		
        "Thanks for your registration with ".$this->sitename."\r\n".
        "Please click the link below to confirm your registration.\r\n".
        "$confirm_url\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("Failed sending registration confirmation email.");
            return false;
        }
        return true;
    }
    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }
    
    function SendAdminIntimationEmail(&$formvars)
    {
        if(empty($this->admin_email))
        {
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        //$mailer->Subject = "New registration: ".$formvars['name'];
		//$name = GetFullName($formvars);
		$mailer->Subject = "New registration: ".$formvars['first_name'].' '.$formvars['last_name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        //"Name: ".$formvars['name']."\r\n".
		//"Email address: ".$formvars['email']."\r\n".
		"Name: ".$formvars['first_name'].' '.$formvars['last_name']."\r\n".
		"Email address: ".$formvars['FAU_email']."\r\n".
        
        "UserName: ".$formvars['username'];
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SaveToDatabase(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
        if(!$this->Ensuretable())
        {
            return false;
        }
        //if(!$this->IsFieldUnique($formvars,'email'))
		if(!$this->IsFieldUnique($formvars,'FAU_email'))
        {
            $this->HandleError("This email is already registered");
            return false;
        }
        
        if(!$this->IsFieldUnique($formvars,'username'))
        {
            $this->HandleError("Username already associated with an account. Please log in with username and password.");
            return false;
        }        
        if(!$this->InsertIntoDB($formvars))
        {
            $this->HandleError("Insertion to Database failed!");
            return false;
        }
        return true;
    }
    
    function IsFieldUnique($formvars,$fieldname)
    {
        $field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        $qry = "select username from $this->tablename where $fieldname='".$field_val."'";
        $result = mysqli_query($this->connection,$qry);   
        if($result && mysqli_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    function DBLogin()
    {

        $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd);

        if(!$this->connection)
        {   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
        if(!mysqli_select_db($this->connection,$this->database))
        {
            $this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
            return false;
        }
        if(!mysqli_query($this->connection,"SET NAMES 'UTF8'"))
        {
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    }    
    
    function Ensuretable()
    {
        $result = mysqli_query($this->connection,"SHOW COLUMNS FROM $this->tablename");   
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            return $this->CreateTable();
        }
        return true;
    }
    
    function CreateTable()
    {
        $qry = "Create Table $this->tablename (".
				"user_type VARCHAR( 255 ) NOT NULL ,".
				"client_retail TINYINT( 1 ) NOT NULL ,".
				"client_jobber TINYINT( 1 ) NOT NULL ,".
				"client_bulk TINYINT( 1 ) NOT NULL ,".
				"first_name VARCHAR( 255 ) NOT NULL ,".
				"last_name VARCHAR( 255 ) NOT NULL ,".
				"username VARCHAR( 255 ) NOT NULL ,".
				"address VARCHAR( 255 ) NOT NULL ,".
				"city VARCHAR( 255 ) NOT NULL ,".
				"state VARCHAR( 255 ) NOT NULL ,".
				"zip_code INT( 10 ) UNSIGNED NOT NULL ,".
                "z_num INT( 10 ) UNSIGNED NOT NULL ,".
				"major_1 VARCHAR( 255 ) NOT NULL ,".
				"major_2 VARCHAR( 255 ) NOT NULL ,".
				"minor_1 VARCHAR( 255 ) NOT NULL ,".
				"minor_2 VARCHAR( 255 ) NOT NULL ,".
				"phone VARCHAR( 16 ) NOT NULL ,".
                "FAU_email VARCHAR( 255 ) NOT NULL ,".
                "password VARCHAR( 255 ) NOT NULL ,".
				"grad_semester VARCHAR( 255 ) NOT NULL ,".
				"grad_year SMALLINT( 5 ) UNSIGNED NOT NULL ,".
                "confirmcode VARCHAR( 32 ) ,".
                "PRIMARY KEY ( z_num )".
                ")";
                
        if(!mysqli_query($this->connection,$qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function InsertIntoDB(&$formvars)
    {
    
        //$confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        $confirmcode = $this->MakeConfirmationMd5($formvars['FAU_email']);
		
        $formvars['confirmcode'] = $confirmcode;
        
        /*
		$insert_query = 'insert into '.$this->tablename.'(
                name,
                email,
                username,
                password,
                confirmcode
                )
                values
                (
                "' . $this->SanitizeForSQL($formvars['name']) . '",
                "' . $this->SanitizeForSQL($formvars['email']) . '",
                "' . $this->SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
                "' . $confirmcode . '"
                )';
				*/
		$insert_query = 'insert into '.$this->tablename.'(
				z_num,
                first_name,
				last_name,
                FAU_email,
                username,
                password,
                confirmcode
                )
                values
                (
				"' . $this->SanitizeForSQL($formvars['z_num']) . '",
                "' . $this->SanitizeForSQL($formvars['first_name']) . '",
				"' . $this->SanitizeForSQL($formvars['last_name']) . '",
                "' . /*$this->SanitizeForSQL($formvars['email'])*/ $this->SanitizeForSQL($formvars['FAU_email']). '",
                "' . $this->SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
                "' . $confirmcode . '"
                )';      
		
        if(!mysqli_query($this->connection,$insert_query))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }        
        return true;
    }
    function MakeConfirmationMd5($email)
    {
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$this->rand_key.$randno1.''.$randno2);
    }
    function SanitizeForSQL($str)
    {
        if( function_exists( "mysqli_real_escape_string" ) )
        {
              $ret_str = mysqli_real_escape_string($this->connection,$str);
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
 /*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }    
    function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }    
}
?>