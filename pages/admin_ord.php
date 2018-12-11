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

if ((isset($_POST['ord_id'])) && ($_POST['ord_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM shop_ord_main WHERE ord_id=%s",
                       GetSQLValueString($_POST['ord_id'], "text"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($deleteSQL, $eplay) or die(mysql_error());

$deleteSQL = sprintf("DELETE FROM shop_ord_sub WHERE ord_id=%s",
                       GetSQLValueString($_POST['ord_id'], "text"));
  mysql_select_db($database_webshopConn, $webshopConn);
  $Result2 = mysql_query($deleteSQL, $webshopConn) or die(mysql_error());


  $deleteGoTo = "admin_ord.php";
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_showordRec = 10;
$pageNum_showordRec = 0;
if (isset($_GET['pageNum_showordRec'])) {
  $pageNum_showordRec = $_GET['pageNum_showordRec'];
}
$startRow_showordRec = $pageNum_showordRec * $maxRows_showordRec;

mysql_select_db($database_eplay, $eplay);
$query_showordRec = "SELECT * FROM shop_ord_main";
$query_limit_showordRec = sprintf("%s LIMIT %d, %d", $query_showordRec, $startRow_showordRec, $maxRows_showordRec);
$showordRec = mysql_query($query_limit_showordRec, $eplay) or die(mysql_error());
$row_showordRec = mysql_fetch_assoc($showordRec);

if (isset($_GET['totalRows_showordRec'])) {
  $totalRows_showordRec = $_GET['totalRows_showordRec'];
} else {
  $all_showordRec = mysql_query($query_showordRec);
  $totalRows_showordRec = mysql_num_rows($all_showordRec);
}
$totalPages_showordRec = ceil($totalRows_showordRec/$maxRows_showordRec)-1;

$queryString_showordRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showordRec") == false && 
        stristr($param, "totalRows_showordRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showordRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showordRec = sprintf("&totalRows_showordRec=%d%s", $totalRows_showordRec, $queryString_showordRec);
$query_showordRec = "SELECT * FROM shop_ord_main ORDER BY ord_date DESC";
$showordRec = mysql_query($query_showordRec, $eplay) or die(mysql_error());
$row_showordRec = mysql_fetch_assoc($showordRec);
$totalRows_showordRec = mysql_num_rows($showordRec);

$query_showitemRec = "SELECT shop_item.item_id,shop_item.item_name,count(shop_goods.item_id) as num FROM shop_item LEFT OUTER JOIN shop_goods    ON shop_item.item_id=shop_goods.item_id GROUP BY shop_item.item_id ";
$showitemRec = mysql_query($query_showitemRec, $eplay) or die(mysql_error());
$row_showitemRec = mysql_fetch_assoc($showitemRec);
$totalRows_showitemRec = mysql_num_rows($showitemRec);
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
    .style11 {	color: #FFFFFF;
	font-size: 10pt;
}
    .style15 {	font-size: 10pt;
	color: #666666;
}
.style16 {font-size: 10pt}
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
                  <form name="form3" enctype="multipart/form-data" method="POST">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="550" colspan="2" bgcolor="#9DACBF"><p align="left" class="style11">客戶訂單管理</p></td>
                      </tr>
                      <tr>
                        <td colspan="2"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF">
                          <tr>
                            <td bgcolor="#E3E9F1"><div align="center"><span class="style15">訂單編號</span></div></td>
                            <td bgcolor="#E3E9F1"><div align="center">
                              <div align="center">訂單金額</div></td>
                            <td bgcolor="#E3E9F1"><div align="center">訂單日期</div></td>
                            <td bgcolor="#E3E9F1"><div align="center"><span class="style15">動作</span></div></td>
                          </tr>
                          <?php do { ?>
                          <?php if ($totalRows_showordRec > 0) { // Show if recordset not empty ?>
                          <tr>
                            <td bgcolor="#E3E9F1"><div align="center"><a href="admin_editord.php?<?php echo $row_showordRec['ord_id']; ?>=<?php echo $row_showordRec['ord_id']; ?>"><font color="#330099"><?php echo $row_showordRec['ord_id']; ?></font></a></div></td>
                            <td bgcolor="#E3E9F1"><div align="center"><?php echo $row_showordRec['ord_total']; ?></div></td>
                            <td bgcolor="#E3E9F1"><div align="center"><?php echo $row_showordRec['ord_date']; ?></div></td>
                            <td bgcolor="#E3E9F1"><label>
                              <input type="image" name="imageField" id="imageField" src="photos/del.gif" />
                              <input name="ord_id" type="hidden" id="ord_id" value="<?php echo $row_showordRec['ord_id']; ?>" />
                              <div align="center"></div>
                              </label></td>
                          </tr>
                          <?php } // Show if recordset not empty ?>
                          <?php } while ($row_showordRec = mysql_fetch_assoc($showordRec)); ?>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="10"><div align="right">共<?php echo $totalRows_showordRec ?> 筆訂單</div></td>
                        <td>&nbsp;
                          <table border="0">
                            <tr>
                              <td><?php if ($pageNum_showordRec > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, 0, $queryString_showordRec); ?>"><img src="../photos/First.gif"></a>
                                  <?php } // Show if not first page ?></td>
                              <td><?php if ($pageNum_showordRec > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, max(0, $pageNum_showordRec - 1), $queryString_showordRec); ?>"><img src="../photos/Previous.gif"></a>
                                  <?php } // Show if not first page ?></td>
                              <td><?php if ($pageNum_showordRec < $totalPages_showordRec) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, min($totalPages_showordRec, $pageNum_showordRec + 1), $queryString_showordRec); ?>"><img src="../photos/Next.gif"></a>
                                  <?php } // Show if not last page ?></td>
                              <td><?php if ($pageNum_showordRec < $totalPages_showordRec) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_showordRec=%d%s", $currentPage, $totalPages_showordRec, $queryString_showordRec); ?>"><img src="../photos/Last.gif"></a>
                                  <?php } // Show if not last page ?></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                  </form>
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
mysql_free_result($showordRec);
?>
