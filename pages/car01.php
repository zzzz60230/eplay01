<?php require_once('../Connections/eplay.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
mysql_query("SET NAMES 'UTF8'");


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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE shop_car SET goods_price=%s, ord_num=%s, ord_sum=%s WHERE temp_no=%s",
                       GetSQLValueString($_POST['goods_price'], "int"),
                       GetSQLValueString($_POST['ord_num'], "int"),
                       GetSQLValueString($_POST['goods_price'], "int"),
                       GetSQLValueString($_POST['temp_no'], "int"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($updateSQL, $eplay) or die(mysql_error());

  $updateGoTo = "car.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['temp_no'])) && ($_GET['temp_no'] != "") && (isset($_GET['del']))) {
  $deleteSQL = sprintf("DELETE FROM shop_car WHERE temp_no=%s",
                       GetSQLValueString($_GET['temp_no'], "int"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($deleteSQL, $eplay) or die(mysql_error());

  $deleteGoTo = "car.php";
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_carRec = "-1";
if (isset($_SESSION['tempord_id'])) {
  $colname_carRec = $_SESSION['tempord_id'];
}
mysql_select_db($database_eplay, $eplay);
$query_carRec = sprintf("SELECT * FROM shop_car WHERE ord_id = %s ORDER BY temp_no DESC", GetSQLValueString($colname_carRec, "text"));
$carRec = mysql_query($query_carRec, $eplay) or die(mysql_error());
$row_carRec = mysql_fetch_assoc($carRec);
$totalRows_carRec = mysql_num_rows($carRec);
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
<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
    </script>
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
                    <table width="560" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td colspan="2" background="img/mod_nw.gif"></td>
                        <td width="5"><img src="img/mod_ne.gif" width="5" height="5" /></td>
                      </tr>
                      <tr>
                        <td width="5" background="img/mod_left.gif"><img src="img/mod_left.gif" width="5" height="5" /></td>
                        <td width="550" bgcolor="#9DACBF"><p align="left" class="style11">檢視購物車</p></td>
                        <td rowspan="2" background="img/mod_right.gif"></td>
                      </tr>
                      <tr>
                        <td background="img/mod_left.gif"></td>
                        <td width="550" bgcolor="#FFFFFF"><div align="center">
                          <?php if ($totalRows_carRec > 0) { // Show if recordset not empty ?>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="38%"><div align="left">品名</div></td>
            <td width="9%"><div align="left">數量</div></td>
            <td width="12%"><div align="left">單價</div></td>
            <td width="16%"><div align="left">小計</div></td>
            <td width="25%"><div align="left"></div></td>
          </tr>
          <?php do { ?>
            <?php 
$total=0;
do { ?>
              <tr>
                
                <td><div align="left"><?php echo $row_carRec['goods_name']; ?></div></td>
                <td><div align="left">
                  <select name="ord_num" id="ord_num">
                    <option value="1" <?php if (!(strcmp(1, $row_carRec['ord_num']))) {echo "selected=\"selected\"";} ?>>1</option>
                    <option value="2" <?php if (!(strcmp(2, $row_carRec['ord_num']))) {echo "selected=\"selected\"";} ?>>2</option>
                    <option value="3" <?php if (!(strcmp(3, $row_carRec['ord_num']))) {echo "selected=\"selected\"";} ?>>3</option>
                    <option value="4" <?php if (!(strcmp(4, $row_carRec['ord_num']))) {echo "selected=\"selected\"";} ?>>4</option>
                    <option value="5" <?php if (!(strcmp(5, $row_carRec['ord_num']))) {echo "selected=\"selected\"";} ?>>5</option>
                    </select>
                </div></td>
                <td><div align="left">NT$<?php echo $row_carRec['goods_price']; ?></div></td>
                <td><div align="left">NT$<?php echo $row_carRec['ord_sum']; ?></div></td>
                <td><input name="temp_no" type="hidden" id="temp_no" value="<?php echo $row_carRec['temp_no']; ?>" />
                  <input name="goods_price" type="hidden" id="goods_price" value="<?php echo $row_carRec['goods_price']; ?>" />
                  <input type="submit" name="button" id="button" value="修改" />
                  <input name="del" type="button" id="del" onclick="MM_goToURL('parent','car.php?del=true&amp;temp_no=<?php echo $row_carRec['temp_no']; ?>');return document.MM_returnValue" value="刪除" /></td>
                <input type="hidden" name="MM_update" value="delform" />
                
              </tr>
              <?php 
$total=$total+($row_carRec['ord_num']*$row_carRec['goods_price']);
} while ($row_carRec = mysql_fetch_assoc($carRec)); ?>
            <?php } while ($row_carRec = mysql_fetch_assoc($carRec)); ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="right">總計NT$</div></td>
            <td><div align="left"><?php echo $total; ?></div></td>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?>
  
  
<input name="button2" type="button" id="button2" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="繼續購物" />
                          <?php if ($totalRows_carRec > 0) { // Show if recordset not empty ?>
                          <input name="button3" type="button" id="button3" onclick="MM_goToURL('parent','order.php');return document.MM_returnValue" value="立即結帳" />
                          <?php } // Show if recordset not empty ?>
                          <br />
                        </div></td>
                      </tr>
                      <tr>
                        <td colspan="2" background="img/mod_sw.gif"></td>
                        <td><img src="img/mod_se.gif" width="5" height="5" /></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                    <input type="hidden" name="MM_update" value="form3">
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
mysql_free_result($carRec);
?>
