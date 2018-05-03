<?PHP
require_once("/home/CEN4010_S2018g03/public_html/FAUOWLS/security/include/fg_membersite.php");
$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('lamp.cse.fau.edu/~CEN4010_S2018g03/FAUOWLS/security');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('jcordes@fau.edu');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB(/*hostname*/'lamp.cse.fau.edu',
                      /*username*/'CEN4010_S2018g03',
                      /*password*/'cen4010_s2018',
                      /*database name*/'CEN4010_S2018g03',
                      /*table name*/'Store_users');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('qSRcVS6DrTzrPvr');

?>