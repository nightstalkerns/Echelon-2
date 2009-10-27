<?php
error_reporting( E_ERROR ^ E_WARNING );
include "ctracker.php"; 
require_once('Connections/inc_config.php');
 
// Make sure we don't cache this...
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter("must-revalidate");
// Start the session...
session_start(); 
// Third time offender... can't be right...
if ($_SESSION['xlrwrong'] >= 3)
  {
  echo "<html><head><title>xlr8or.snt.utwente.nl</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";
  echo "</head><body bgcolor=\"#4D5473\" text=\"#FFFFFF\" link=\"#FFFFFF\" vlink=\"#FFFFFF\" alink=\"#FFFFFF\">";
  echo "This account is locked, you've exceeded the maximum number of login attempts!";
  echo "</body></html>";
  exit;
  }
?>
<html>
  <head>
    <title>
      Echelon - B3 Repository Tool (by xlr8or)
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
      <!--
      @import url(css/default.css);
      -->
    </style>
  </head>
  <body>
    <div id="wrapper">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="center">
          <td align="left" class="tabelinhoud">
              <img src="img/head.gif" width="800" height="50" border="0">
          </td>
        </tr>
        <tr>
          <td align="center">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td>
            <table width="100%"  border="0" cellspacing="0" cellpadding="2" class="tabeluitleg">
              <tr>
                <td>
                  Welcome to Echelon. Echelon is the investigation tool for B3 admins. 
                  <br>With Echelon you can get quite a nice impression on how your gamers behave, with or without your presence.
                  <br>See who got banned, why and by who. Get to know your regular and non regular gamers!
                  <br>
                  <br>If you need support for this tool visit the forums at 
                  <a href="http://www.bigbrotherbot.com/" target="_blank">www.bigbrotherbot.com</a>. 
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="tabelinhoud">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td class="tabelkop">
            Admin login:
          </td>
        </tr>
        <tr>
          <td class="tabelinhoud">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td class="tabelinhoud">
<?php if ($_SESSION['xlradmin'] == NULL) {
  if (($_SESSION['xlrwrong'] == NULL) || ($_SESSION['xlrwrong'] == 0))
    {
    echo "Please log in below.";
    }
  // First time offender...
  if ($_SESSION['xlrwrong'] == 1)
    {
    echo "Wrong answer, try again please!";
    }
  // Second time offender... hmmmz...
  if ($_SESSION['xlrwrong'] == 2)
    {
    echo "Wrong answer again, try again please!";
    }
  echo "&nbsp;&nbsp;<i>(";
  echo 3 - $_SESSION['xlrwrong'];
  echo " attempts left...)</i><br>"
            ?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_validateForm() { //v4.0
var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
if (val) { nm=val.name; if ((val=val.value)!="") {
if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
} else if (test!='R') { num = parseFloat(val);
if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
min=test.substring(8,p); max=test.substring(p+1);
if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
} } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
} if (errors) alert('The following error(s) occurred:\n'+errors);
document.MM_returnValue = (errors == '');
}
//-->
</script>
            <form action="<?php echo $path; ?>login/validate.php" method="POST" name="loginform" id="loginform">
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class="tabelkop">
                <tr>
                  <td width="14%">
                    loginname: 
                  </td>
                  <td width="86%">
                    <input name="loginname" type="text" id="loginname">
                  </td>
                </tr>
                <tr>
                  <td>
                    pass: 
                  </td>
                  <td>
                    <input name="password" type="password" id="password">
                  </td>
                </tr>
                <tr>
                  <td>
                    &nbsp;
                  </td>
                  <td>
                    <input name="Login" type="submit" id="Login" onClick="MM_validateForm('loginname','','R','password','','R');return document.MM_returnValue" value="Submit">
                  </td>
                </tr>
              </table>
            </form>
<?php } // Closing tag for the if not logged in info.
//Going to the logged in info straight away:
            else {?>
            <table width="100%"  border="0" cellspacing="2" cellpadding="0" class="tabelinhoud">
              <tr>
                <td>
                  Hey 
                  <?php echo $_SESSION['xlradmin'];?>. You are already logged in!
                  <ul>
                    <li>
                    <a href="clients.php">Move on to the repository and start using Echelon</a></li>
                    <li>go to your 
                    <a href="links.php">available admintools</a></li>
                    <li>or logout by clicking 
                    <a href="<?php echo $path; ?>login/logout.php">here</a>.</li>
                  </ul>
                </td>
              </tr>
            </table>
            <?php } // Closing tag for the logged in info?>
          </td>
        </tr>
        <tr>
          <td class="tabelinhoud">
            &nbsp;
          </td>
        </tr>
      </table>
      <?php include "footer.php"; ?>
    </div>
  </body>
</html>
