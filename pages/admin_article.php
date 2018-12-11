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

if ((isset($_GET['goods_id'])) && ($_GET['goods_id'] != "") && (isset($_POST['goods_id']))) {
  $deleteSQL = sprintf("DELETE FROM shop_goods WHERE goods_id=%s",
                       GetSQLValueString($_GET['goods_id'], "text"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($deleteSQL, $eplay) or die(mysql_error());

  $deleteGoTo = "admin_goods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_showgoodsRec = 10;
$pageNum_showgoodsRec = 0;
if (isset($_GET['pageNum_showgoodsRec'])) {
  $pageNum_showgoodsRec = $_GET['pageNum_showgoodsRec'];
}
$startRow_showgoodsRec = $pageNum_showgoodsRec * $maxRows_showgoodsRec;



$maxRows_showgoodsRec = 10;
$pageNum_showgoodsRec = 0;
if (isset($_GET['pageNum_showgoodsRec'])) {
  $pageNum_showgoodsRec = $_GET['pageNum_showgoodsRec'];
}
$startRow_showgoodsRec = $pageNum_showgoodsRec * $maxRows_showgoodsRec;

mysql_select_db($database_eplay, $eplay);
$query_showgoodsRec = "SELECT shop_goods.*,shop_item.item_name FROM shop_goods INNER JOIN shop_item    ON shop_item.item_id=shop_goods.item_id";
$query_limit_showgoodsRec = sprintf("%s LIMIT %d, %d", $query_showgoodsRec, $startRow_showgoodsRec, $maxRows_showgoodsRec);
$showgoodsRec = mysql_query($query_limit_showgoodsRec, $eplay) or die(mysql_error());
$row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);

if (isset($_GET['totalRows_showgoodsRec'])) {
  $totalRows_showgoodsRec = $_GET['totalRows_showgoodsRec'];
} else {
  $all_showgoodsRec = mysql_query($query_showgoodsRec);
  $totalRows_showgoodsRec = mysql_num_rows($all_showgoodsRec);
}
$totalPages_showgoodsRec = ceil($totalRows_showgoodsRec/$maxRows_showgoodsRec)-1;
$query_showgoodsRec = "SELECT article_goods.*,shop_item.item_name FROM article_goods INNER JOIN shop_item    ON shop_item.item_id=article_goods.item_id";
$showgoodsRec = mysql_query($query_showgoodsRec, $eplay) or die(mysql_error());
$row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
$totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);

$queryString_showgoodsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showgoodsRec") == false && 
        stristr($param, "totalRows_showgoodsRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showgoodsRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showgoodsRec = sprintf("&totalRows_showgoodsRec=%d%s", $totalRows_showgoodsRec, $queryString_showgoodsRec);

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

    <title> e旅遊-遊記管理 </title>

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
    .style19 {color: #FF0000}
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
           <!-- /標題 -->
              <h3 style="color: #F794CF; font-family: '微軟正黑體'; font-style: normal;"> <strong>e旅遊  </strong> </h3>
        </div>
			
            
            
            
            
            
            <!-- /左上按鈕 -->
            <b>
		  <ul class="nav navbar-top-links navbar-left ">
                <li class="dropdown ">
                    <a class="dropdown-toggle ; bg-danger ; " href="index.php">
                    <span style="color: #000000; font-size: 20px; font-family: '微軟正黑體';">首頁</span> </a>
                   
                    <!-- /.dropdown-user -->
            </li>
                <!-- /.dropdown -->
              <li class="dropdown">
                    <a class="dropdown-toggle  ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';">所有</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="goods_index.php"><i class="fa fa-gear fa-fw"></i> 所有景點</a>
                        </li>
                        <li><a href="food_index.php"><i class="fa fa-gear fa-fw"></i> 所有美食</a>
                        </li>
                        <li><a href="article_index.php"><i class="fa fa-gear fa-fw"></i> 所有遊記</a>
                        </li>
                        <li><a href="prefer_index.php"><i class="fa fa-gear fa-fw"></i> 所有優惠</a>
                        </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle  ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';">分類</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 台北</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 基隆</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> 桃園</a>
                        </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';">規劃</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="map_index.php"><i class="fa fa-gear fa-fw"></i> 旅遊地圖</a>
                        </li>
                        <li><a href="stroke_劉/stroke_taipei.php"><i class="fa fa-gear fa-fw"></i> 旅遊行程</a>
                        </li>
                        
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                
                
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="#">
                    <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';">客服</span> </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="question.php"><i class="fa fa-gear fa-fw"></i> 常見問題</a>
                        </li>
                        <li><a href="aboutme.php"><i class="fa fa-gear fa-fw"></i> 關於我</a>
                        </li>
                        <li><a href="contactme.php"><i class="fa fa-gear fa-fw"></i> 聯絡我</a>
                        </li>
                        
                  </ul>
                    <!-- /.dropdown-user -->
              </li>
                 
        </ul></b>
			
            
            
            
            <!-- /.navbar-header -->
            <!-- /.右上按鈕 -->
			<b>
          <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						
                    <span style="font-size: 20px; color: #1B4061;font-family: '微軟正黑體';">會員管理 </span></a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="login01.php"><i class="fa fa-gear fa-fw"></i> 登入會員</a>
                        </li>
                        <li><a href="personal_page.php"><i class="fa fa-gear fa-fw"></i> 個人頁面</a>
                        </li>
                        <li><a href="personal_data.php"><i class="fa fa-gear fa-fw"></i> 個人資料</a>
                        </li>
                        <li><a href="addmem.php"><i class="fa fa-gear fa-fw"></i> 加入會員</a>
                        </li>
                        
                        
                  </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                
                <!-- /.dropdown -->
                <li class="dropdown">
                
                    <a class="dropdown-toggle"  href="news_index.php">
                    <span style="font-size: 20px; color: #1B4061;font-family: '微軟正黑體';">通知訊息 </span></a>
                    
                    
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
              <!-- /.dropdown -->
        </ul>
            <!-- /.navbar-top-links -->
			</b>
            
            <br>
        <div class="navbar-default sidebar" role="navigation">
          
              <div class="sidebar-nav navbar-collapse">
                
                  <ul class="nav" id="side-menu">
                    <!-- /.搜尋 -->
                    
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
                        
                        <!-- /.左側按鈕 -->
                          
                          <a href="goods_index.php"> <span style="font-size: 20px; color: #000000;font-family: '微軟正黑體';"><b>所有景點</b></span></a>
                          <!-- /.nav-second-level -->
                    </li>
                        
					  <li>
                          <a href="food_index.php"> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><b>所有美食</b></span></a>                            <!-- /.nav-second-level -->
                      </li>
						
						
					  <li>
                          <a href="article_index.php"> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><b>所有遊記</b></span></a>
                
                          <!-- /.nav-second-level -->
                      </li>
					  <li>
                          <a href="map_index.php"> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><b>旅遊地圖</b></span></a>
                
                          <!-- /.nav-second-level -->
                      </li>
					  <li>
                          <a href="stroke_劉/stroke_taipei.php"> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><b>推薦行</b>程</span></a>
                
                          <!-- /.nav-second-level -->
                      </li>
						
					  <li>
                          <a href="prefer_index.php"> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><b>優惠活動</b></span></a>
                         
                   
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
                <div class="panel-heading">遊記管理</div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <p>
                    <!-- /.table-responsive -->
                  </p>
                  <form name="form3" enctype="multipart/form-data" method="POST">
                    <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="550" colspan="2" bgcolor="#9DACBF"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="550" colspan="2" bgcolor="#9DACBF"><p align="left" class="style11">&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td colspan="2"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF">
                            <tr>
                              <td width="16%" bgcolor="#E3E9F1"><div align="center"><span class="style15">遊記編號</span></div></td>
                              <td width="45%" bgcolor="#E3E9F1"><div align="center">遊記名稱</div></td>
                              <td width="17%" bgcolor="#E3E9F1"><div align="center">遊記分類</div></td>
                              <td width="9%" bgcolor="#E3E9F1"><div align="left" class="style15">
                                <div align="center">遊記網址</div>
                              </div></td>
                              <td width="13%" bgcolor="#E3E9F1"><div align="center"><span class="style15">動作</span></div></td>
                            </tr>
                            <?php do { ?>
                            <tr>
                              <td bgcolor="#E3E9F1"><div align="center"><?php echo $row_showgoodsRec['goods_id']; ?></div></td>
                              <td bgcolor="#E3E9F1"><a href="article_content.php?goods_id=<?php echo $row_showgoodsRec['goods_id']; ?>"><font color="#333399"><?php echo $row_showgoodsRec['goods_name']; ?></font></a></td>
                              <td bgcolor="#E3E9F1"><div align="center"><?php echo $row_showgoodsRec['item_name']; ?></div></td>
                              <td bgcolor="#E3E9F1"><div align="center"><a href="<?php echo $row_showgoodsRec['goods_stand']; ?>"><img src="photos/options.gif" width="30" height="30"></a></div></td>
                              <td bgcolor="#E3E9F1"><label>
                                <input type="image" name="imageField" id="imageField" src="photos/del.gif" />
                                <input name="goods_id" type="hidden" id="goods_id" value="<?php echo $row_showgoodsRec['goods_id']; ?>" />
                              </label></td>
                            </tr>
                            <?php } while ($row_showgoodsRec = mysql_fetch_assoc($showgoodsRec)); ?>
                          </table></span></td>
                        </tr>
                        <tr>
                          <td height="10"><div align="right">共<?php echo $totalRows_showgoodsRec ?> 篇遊記</div></td>
                          <td>&nbsp;
                            <table border="0">
                              <tr>
                                <td><?php if ($pageNum_showgoodsRec > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, 0, $queryString_showgoodsRec); ?>"><img src="../photos/First.gif"></a>
                                <?php } // Show if not first page ?></td>
                                <td><?php if ($pageNum_showgoodsRec > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, max(0, $pageNum_showgoodsRec - 1), $queryString_showgoodsRec); ?>"><img src="../photos/Previous.gif"></a>
                                <?php } // Show if not first page ?></td>
                                <td><?php if ($pageNum_showgoodsRec < $totalPages_showgoodsRec) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, min($totalPages_showgoodsRec, $pageNum_showgoodsRec + 1), $queryString_showgoodsRec); ?>"><img src="../photos/Next.gif"></a>
                                <?php } // Show if not last page ?></td>
                                <td><?php if ($pageNum_showgoodsRec < $totalPages_showgoodsRec) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, $totalPages_showgoodsRec, $queryString_showgoodsRec); ?>"><img src="../photos/Last.gif"></a>
                                <?php } // Show if not last page ?></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>                        <p align="left" class="style11">&nbsp;</p></td>
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
mysql_free_result($showgoodsRec);
?>
