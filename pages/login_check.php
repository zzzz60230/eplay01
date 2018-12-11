<?php require_once('../Connections/eplay.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php 
if(isset($_GET['chk']) && $_GET['chk']=='ok'){
  $updateSQL = sprintf("UPDATE member SET member_level=4 WHERE member_mail=%s",
                       GetSQLValueString($_GET['memmail'], "text"));
  mysql_select_db($database_shop, $shop);
  $Result1 = mysql_query($updateSQL, $shop) or die(mysql_error());
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user_mail'])) {
  $loginUsername=$_POST['user_mail'];
  $password=$_POST['user_pd'];
  $MM_fldUserAuthorization = "member_level";
  $MM_redirectLoginSuccess = "../product/pro_index.php?folder=member&page=member.php";
  
  if(isset($_SESSION['curr_url'])){$MM_redirectLoginSuccess = $_SESSION['curr_url'];}
  
  $MM_redirectLoginFailed = "../product/pro_index.php?folder=member&page=login.php&msg=1";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_shop, $shop);
  	
  $LoginRS__query=sprintf("SELECT member_mail, member_pd, member_level FROM member WHERE member_mail=%s AND member_pd=%s AND member_level<=4",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $shop) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'member_level');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    /* if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    } */
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?> 