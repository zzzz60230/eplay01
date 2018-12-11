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




$colname_IDtestRec = "-1";
if (isset($_GET['newID'])) {
  $colname_IDtestRec = $_GET['newID'];
}
mysql_select_db($database_eplay, $eplay);
$query_IDtestRec = sprintf("SELECT * FROM memberdata WHERE memberdata.memId = %s", GetSQLValueString($colname_IDtestRec, "text"));
$IDtestRec = mysql_query($query_IDtestRec, $eplay) or die(mysql_error());
$row_IDtestRec = mysql_fetch_assoc($IDtestRec);
$totalRows_IDtestRec = mysql_num_rows($IDtestRec);



//回傳資料集中資料筆數.0代表無相同的帳號存在
echo $totalRows_IDtestRec;

mysql_free_result($IDtestRec);
?>
