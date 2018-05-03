<?PHP
require_once("/home/CEN4010_S2018g03/public_html/FAUOWLS/security/include/membersite_config.php");;

if(isset($_POST['submitted']))
{
   if($fgmembersite->RegisterUser())
   {
        $fgmembersite->RedirectToURL("/~CEN4010_S2018g03/FAUOWLS/security/thank-you.html");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Contact us</title>
    <link rel="STYLESHEET" type="text/css" href="/~CEN4010_S2018g03/FAUOWLS/security/style/fg_membersite.css" />
    <script type='text/javascript' src='/~CEN4010_S2018g03/FAUOWLS/security/scripts/gen_validatorv31.js'></script>
    <link rel="STYLESHEET" type="text/css" href="/~CEN4010_S2018g03/FAUOWLS/security/style/pwdwidget.css" />
    <script src="/~CEN4010_S2018g03/FAUOWLS/security/scripts/pwdwidget.js" type="text/javascript"></script>      
</head>
<body>

<!-- Form Code Start -->
<div id='fg_membersite'>
<form id='register' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Register</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<div class='short_explanation'>* required fields</div>
<input type='text'  class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<!--
<div class='container'>
    <label for='name' >Your Full Name*: </label><br/>
    <input type='text' name='name' id='name' value='<#?php echo $fgmembersite->SafeDisplay('name') ?>' maxlength="50" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
-->
<div class='container'>
    <label for='z_num' >Z-number*: </label><br/>
    <input type='number' name='z_num' id='z_num' value='<?php echo $fgmembersite->SafeDisplay('z_num') ?>' maxlength="10" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='first_name' >First Name*: </label><br/>
    <input type='text' name='first_name' id='first_name' value='<?php echo $fgmembersite->SafeDisplay('first_name') ?>' maxlength="255" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='last_name' >Last Name*: </label><br/>
    <input type='text' name='last_name' id='last_name' value='<?php echo $fgmembersite->SafeDisplay('last_name') ?>' maxlength="255" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>

<!--
<div class='container'>
    <label for='email' >Email Address*:</label><br/>
    <input type='text' name='email' id='email' value='<#?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
    <span id='register_email_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='username' >UserName*:</label><br/>
    <input type='text' name='username' id='username' value='<#?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
    <span id='register_username_errorloc' class='error'></span>
</div>
-->
<div class='container'>
    <label for='FAU_email' >FAU Email Address*:</label><br/>
    <input type='text' name='FAU_email' id='FAU_email' value='<?php echo $fgmembersite->SafeDisplay('FAU_email') ?>' maxlength="255" /><br/>
    <span id='register_email_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='username' >FAU Username*:</label><br/>
    <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="255" /><br/>
    <span id='register_username_errorloc' class='error'></span>
</div>

<div class='container' style='height:80px;'>
    <label for='password' >Password*:</label><br/>
    <div class='pwdwidgetdiv' id='thepwddiv' ></div>
    <noscript>
    <input type='password' name='password' id='password' maxlength="50" />
    </noscript>    
    <div id='register_password_errorloc' class='error' style='clear:both'></div>
</div>

<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('thepwddiv','password');
    pwdwidget.MakePWDWidget();
    
    var frmvalidator  = new Validator("register");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    //frmvalidator.addValidation("name","req","Please provide your name");
	frmvalidator.addValidation("first_name","req","Please provide your first name");
	frmvalidator.addValidation("last_name","req","Please provide your last name");

    frmvalidator.addValidation("FAU_email","req","Please provide your FAU email address");

    frmvalidator.addValidation("FAU_email","email","Please provide a valid FAU email address");

    frmvalidator.addValidation("username","req","Please provide a username");
    
    frmvalidator.addValidation("password","req","Please provide a password");

// ]]>
</script>

<!--
Form Code End (see html-form-guide.com for more info.)
-->

</body>
</html>