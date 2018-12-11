<?php session_start()?>
<?php require_once('../Connections/eplay.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login01.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$maxRows_newsRec = 10;
$pageNum_newsRec = 0;
if (isset($_GET['pageNum_newsRec'])) {
  $pageNum_newsRec = $_GET['pageNum_newsRec'];
}
$startRow_newsRec = $pageNum_newsRec * $maxRows_newsRec;

mysql_select_db($database_eplay, $eplay);
$query_newsRec = "SELECT * FROM placardmain WHERE placardmain.postDate";
$query_limit_newsRec = sprintf("%s LIMIT %d, %d", $query_newsRec, $startRow_newsRec, $maxRows_newsRec);
$newsRec = mysql_query($query_limit_newsRec, $eplay) or die(mysql_error());
$row_newsRec = mysql_fetch_assoc($newsRec);

if (isset($_GET['totalRows_newsRec'])) {
  $totalRows_newsRec = $_GET['totalRows_newsRec'];
} else {
  $all_newsRec = mysql_query($query_newsRec);
  $totalRows_newsRec = mysql_num_rows($all_newsRec);
}
$totalPages_newsRec = ceil($totalRows_newsRec/$maxRows_newsRec)-1;

$queryString_newsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_newsRec") == false && 
        stristr($param, "totalRows_newsRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_newsRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_newsRec = sprintf("&totalRows_newsRec=%d%s", $totalRows_newsRec, $queryString_newsRec);
$query_newsRec = "SELECT * FROM placardmain ORDER BY placardmain.postDate DESC";
$newsRec = mysql_query($query_newsRec, $eplay) or die(mysql_error());
$row_newsRec = mysql_fetch_assoc($newsRec);
$totalRows_newsRec = mysql_num_rows($newsRec);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> e旅遊-版型 </title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    .style2 {
	color: #FFFFFF;
	font-family: "微軟正黑體";
}
.style4 {
	font-size: 14pt;
	text-align: left;
}
.style6 {color: #FF0000}
    .style41 {
	font-size: 14pt
}
    .style3 {	color: #003300
}
    .style1 {color: #666666}
.style21 {	font-size: 12pt;
	color: #990000;
	font-weight: bold;
}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
            </button>
              <p style="font-size: 36px; color: #F794CF; font-family: '微軟正黑體'; font-style: normal;"> <strong>e旅遊  </strong> </p>
            </div>
			
            
            
            
            
            
            
		  <ul class="nav navbar-top-links navbar-left ">
                <li class="dropdown ">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 18px; font-family: '微軟正黑體';">首頁</span> </a>
                   
                    <!-- /.dropdown-user -->
            </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 16px;font-family: '微軟正黑體';">熱門</span> </a>
                  <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> 評分排名</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 最近熱門</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> 大家推薦</a>
                    </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle  ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 16px;font-family: '微軟正黑體';">分類</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> 地區</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 種類</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 特色</a>
                        </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 16px;font-family: '微軟正黑體';">規劃</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> 我的收藏</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 地區熱門</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 地圖路線</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 瀏覽紀錄</a>
                        </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 16px;font-family: '微軟正黑體';">優惠</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> 積點兌換</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 優惠活動</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 套裝行程</a>
                        </li>
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 16px;font-family: '微軟正黑體';">客服</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="question.php"><i class="fa fa-gear fa-fw"></i> 常見問題</a>
                        </li>
                        <li><a href="aboutme.php"><i class="fa fa-gear fa-fw"></i> 關於我</a>
                        </li>
                        <li><a href="contactme.php"><i class="fa fa-user fa-fw"></i> 聯絡我</a>
                        </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
               
               
                
                
                
                
            </ul>
			
            
            
            
            <!-- /.navbar-header -->
            <!-- /.右上按鈕 -->

          <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						
                    <span style="font-size: 16px; color: #1B4061;font-family: '微軟正黑體';">會員管理 </span></a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="login01.php"><i class="fa fa-gear fa-fw"></i> 登入會員</a>
                        </li>
                        <li><a href="personal_page.php"><i class="fa fa-user fa-fw"></i> 個人頁面</a>
                        </li>
                        <li><a href="personal_data.php"><i class="fa fa-gear fa-fw"></i> 個人資料</a>
                        </li>
                        <li><a href="addmem.php"><i class="fa fa-gear fa-fw"></i> 加入會員</a>
                        </li>
                        
                        
                        
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span style="font-size: 16px; color: #1B4061;font-family: '微軟正黑體';">我的收藏 </span></a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" style="font-size: 16px; color: #1B4061;font-family: '微軟正黑體';" data-toggle="dropdown">                        通知訊息</a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
              <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			
            
            <br>
          <div class="navbar-default sidebar" role="navigation">
          
                <div class="sidebar-nav navbar-collapse">
                
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="搜尋...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li></li>
                        <li>
                            <a href="#"> <span style="font-size: 18px; color: #000000; font-family: '微軟正黑體';">縣市地區</span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                  <a href="flot.html">1</a>
                              </li>
                                <li>
                                  <a href="morris.html">2</a>
                                </li>
                          </ul>
                            <!-- /.nav-second-level -->
                      </li>
                        
						<li>
                            <a href="#"> <span style="font-size: 18px; color: #000000;font-family: '微軟正黑體';">台灣熱門景點</span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">日月潭</a>
                                </li>
                                <li>
                                  <a href="morris.html">墾丁</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						
						<li>
                            <a href="#"> <span style="font-size: 18px; color: #000000;font-family: '微軟正黑體';">景點推薦</span></a>
                
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"> <span style="color: #000000; font-size: 18px;font-family: '微軟正黑體';">美食推薦</span></a>
                
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"> <span style="color: #000000; font-size: 18px;font-family: '微軟正黑體';">遊記分享</span></a>
                
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
                            <a href="#"> <span style="color: #000000; font-size: 18px;font-family: '微軟正黑體';">旅遊美食牆</span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">旅遊</a>
                                </li>
                                <li>
                                  <a href="morris.html">美食</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
                            <a href="#"> <span style="color: #000000; font-size: 18px;font-family: '微軟正黑體';">規劃旅遊行程</span></a>
                
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
                            <a href="#"> <span style="color: #000000; font-size: 18px;font-family: '微軟正黑體';">優惠活動</span></a>
                
                            <!-- /.nav-second-level -->
                        </li>
						
						<li>
                            <a href="#"> <span style="color: #000000; font-size: 18px;font-family: '微軟正黑體';">飯店民宿</span></a>
                
                            <!-- /.nav-second-level -->
                        </li>
						
						
						
						
						
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
          </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                  <p>&nbsp;</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row"></div>
            <!-- /.row -->
            <div class="row">
              <div class="panel panel-default">
                <div class="panel-heading">最新消息</div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <p>
                    <!-- /.table-responsive -->
                  </p>
                  <form action="<?php echo $editFormAction; ?>" name="form3" enctype="multipart/form-data" method="POST">
                    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td background="img/he3_4.gif">&nbsp;</td>
                        <td><?php if ($totalRows_newsRec == 0) { // Show if recordset empty ?>
                          <table width="100%" border="0">
                            <tr>
                              <td align="center"><span class="style21">目前無任何消息發佈</span></td>
                            </tr>
                          </table>
                          <?php } // Show if recordset empty ?>
                          <table width="150" border="0" align="center" cellpadding="0" cellspacing="2">
                            <tr>
                              <td align="center">&nbsp;
                                <table border="0">
                                  <tr>
                                    <td><?php if ($pageNum_newsRec > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_newsRec=%d%s", $currentPage, 0, $queryString_newsRec); ?>"><img src="photos/bt_skip_bk1.gif" /></a>
                                    <?php } // Show if not first page ?></td>
                                    <td><?php if ($pageNum_newsRec > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_newsRec=%d%s", $currentPage, max(0, $pageNum_newsRec - 1), $queryString_newsRec); ?>"><img src="photos/bt_rev1.gif" /></a>
                                    <?php } // Show if not first page ?></td>
                                    <td><?php if ($pageNum_newsRec < $totalPages_newsRec) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_newsRec=%d%s", $currentPage, min($totalPages_newsRec, $pageNum_newsRec + 1), $queryString_newsRec); ?>"><img src="photos/bt_ff1.gif" /></a>
                                    <?php } // Show if not last page ?></td>
                                    <td><?php if ($pageNum_newsRec < $totalPages_newsRec) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_newsRec=%d%s", $currentPage, $totalPages_newsRec, $queryString_newsRec); ?>"><img src="photos/bt_skip_sw1.gif" /></a>
                                    <?php } // Show if not last page ?></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table>
                          <?php if ($totalRows_newsRec > 0) { // Show if recordset not empty ?>
                          <table width="650" border="1" cellpadding="1" cellspacing="0" bordercolor="#A4BAE0">
                            <tr>
                              <td width="100" align="center" valign="middle">發布時間</td>
                              <td width="60" align="center" valign="middle">類別</td>
                              <td width="412" align="center" valign="middle">消息主題</td>
                              <td width="60" align="center" valign="middle"><p>動作</p></td>
                            </tr>
                            <?php do { ?>
                            <tr>
                              <td align="center"><span class="style1"><?php echo $row_newsRec['postDate']; ?></span></td>
                              <td align="center"><span class="style1"><?php echo $row_newsRec['type']; ?></span></td>
                              <td align="left"><span class="style1"></span><?php echo $row_newsRec['title']; ?></td>
                              <td align="center"><span class="style1"><a href="delnews.php?idno=<?php echo $row_newsRec['idNo']; ?>"><img src="photos/block1.gif" alt="刪除消息" width="16" height="16" border="0" /></a> <a href="editnews.php?idno=<?php echo $row_newsRec['idNo']; ?>"><img src="photos/edit.gif" alt="編輯消息" width="16" height="16" border="0" /></a></span></td>
                            </tr>
                            <?php } while ($row_newsRec = mysql_fetch_assoc($newsRec)); ?>
                          </table>
                          <?php } // Show if recordset not empty ?>
                          <table width="650" border="0">
                            <tr>
                              <td align="left">&nbsp;</td>
                              <td align="right"><a href="addnews.php"><img src="photos/apply.gif" alt="新增最新消息" width="73" height="16" border="0" /></a></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                    <table width="200" border="1">
                      <tr>
                        <td><?php echo $row_newsRec['type']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO1']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO2']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO3']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO4']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO5']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO6']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO7']; ?></td>
                      </tr>
                      <tr>
                        <td><?php echo $row_seeNews['NO8']; ?></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                  </form>
                  <p>&nbsp;</p>
                  <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
              </div>
              <!-- /.col-lg-8 --><!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>
<script>
		$(function(){
			$('.coverflow').css('max-width',$('.coverflow img').width());
		});
		$('.carousel').carousel({
  interval: 2500
})
	</script>

</body>

</html>
<?php
mysql_free_result($newsRec);
?>
