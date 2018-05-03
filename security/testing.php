<?PHP
require_once("/home/CEN4010_S2018g03/public_html/FAUOWLS/security/include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("/~CEN4010_S2018g03/FAUOWLS/security/login.php");
    exit;
}

?>
<html>
<?PHP echo $fgmembersite->UserFullName()
."<br>"
.$fgmembersite->UserEmail();?>
</html>