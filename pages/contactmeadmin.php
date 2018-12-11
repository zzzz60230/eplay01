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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_eplay, $eplay);
$query_Recordset1 = "SELECT * FROM contactme";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $eplay) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>

<style type="text/css">
h1{
	font-size: 36px;
	color: #001DFF;
	text-align: center;
	}
</style>

</head>

<body>

<h1>管理者頁面</h1>
<form id="form1" name="form1" method="post">
  <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
    <?php do { ?>
      <table width="600" border="1" align="center">
        <tbody>
          <tr>
            <td width="79" rowspan="4">&nbsp;</td>
            <td width="98">標題</td>
            <td colspan="5"><?php echo $row_Recordset1['subject']; ?></td>
          </tr>
          <tr>
            <td>留言內容</td>
            <td colspan="5"><?php echo $row_Recordset1['cont']; ?></td>
          </tr>
          <tr>
            <td>版主回覆</td>
            <td colspan="5"><?php echo $row_Recordset1['pons']; ?></td>
          </tr>
          <tr>
            <td>姓名</td>
            <td width="124"><?php echo $row_Recordset1['name']; ?></td>
            <td width="59">時間</td>
            <td width="107"><?php echo $row_Recordset1['date']; ?></td>
            <td width="42"><img src="<?php echo $row_Recordset1['phone']; ?>" alt="phone" name="phone" id="phone" /></td>
            <td width="45"><img src="<?php echo $row_Recordset1['mail']; ?>" alt="mail" name="mail" id="mail" /></td>
          </tr>
          <tr>
            <td colspan="7" style="text-align: center"><input type="submit" name="submit" id="submit" value="送出"></td>
          </tr>
        </tbody>
      </table>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    <?php } // Show if recordset not empty ?>
</form>
<?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <p>無</p>
  <?php } // Show if recordset empty ?>
<table border="0">
  <tr>
    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一頁</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">上一頁</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一頁</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最後一頁</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
記錄 <?php echo ($startRow_Recordset1 + 1) ?> 到 <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> 共 <?php echo $totalRows_Recordset1 ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
