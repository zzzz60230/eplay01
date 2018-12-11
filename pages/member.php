<?php require_once('../Connections/eplay.php'); ?>
<?php $_SESSION['curr_url']=$_SERVER['REQUEST_URI'];?>
<?php
//先記錄了現在的URL,判斷是否已登入,再決定畫面顯示的內容
$_SESSION['url_val']=$_SERVER['REQUEST_URI'];
if(!isset($_SESSION['MM_Username'])){
	$pageUrl ="../pages/login01.php?folder=member&page=login01.php";
	echo "<script>window.location.href='$pageUrl'</script>";
}
else{
	if($_SESSION['MM_UserGroup']==5){
		$pageUrl ="../pages/personal_data.php?folder=member&page=personal_data.php";
		echo "<script>window.location.href='$pageUrl'</script>";
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>

</head>

<body>

</body>
</html>

