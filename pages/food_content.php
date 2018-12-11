<?php require_once('../Connections/eplay.php'); ?>



<?php
session_start();
if(!isset($_SESSION['tempord_id'])){
$tempord_id=date('Ymdhis');
$_SESSION['tempord_id']=$tempord_id;
} ?>



<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO love_food (goods_id, memId, goods_img, goods_name) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['goods_id'], "text"),
                       GetSQLValueString($_POST['memId'], "text"),
                       GetSQLValueString($_POST['goods_img'], "text"),
                       GetSQLValueString($_POST['goods_name'], "text"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($insertSQL, $eplay) or die(mysql_error());
}

$colname_productRec = "-1";
if (isset($_GET['goods_id'])) {
  $colname_productRec = $_GET['goods_id'];
}
mysql_select_db($database_eplay, $eplay);
$query_productRec = sprintf("SELECT * FROM shop_goods WHERE goods_id = %s", GetSQLValueString($colname_productRec, "text"));
$productRec = mysql_query($query_productRec, $eplay) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
$totalRows_productRec = "-1";
if (isset($_GET['goods_id'])) {
  $totalRows_productRec = $_GET['goods_id'];
}
$colname_productRec = "-1";


mysql_select_db($database_eplay, $eplay);
$query_productRec = sprintf("SELECT * FROM food_goods WHERE goods_id = %s", GetSQLValueString($colname_productRec, "text"));
$productRec = mysql_query($query_productRec, $eplay) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
$totalRows_productRec = "-1";
if (isset($_GET['goods_id'])) {
  $totalRows_productRec = $_GET['goods_id'];
}

$colname_productRec = "-1";

mysql_select_db($database_eplay, $eplay);
$query_productRec = sprintf("SELECT * FROM food_goods WHERE goods_id = %s", GetSQLValueString($colname_productRec, "text"));
$productRec = mysql_query($query_productRec, $eplay) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
$totalRows_productRec = mysql_num_rows($productRec);$colname_productRec = "-1";
if (isset($_GET['goods_id'])) {
  $colname_productRec = $_GET['goods_id'];
}
mysql_select_db($database_eplay, $eplay);
$query_productRec = sprintf("SELECT * FROM food_goods WHERE goods_id = %s", GetSQLValueString($colname_productRec, "text"));
$productRec = mysql_query($query_productRec, $eplay) or die(mysql_error());
$row_productRec = mysql_fetch_assoc($productRec);
$totalRows_productRec = mysql_num_rows($productRec);

$colname_mem = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_mem = $_SESSION['MM_Username'];
}
mysql_select_db($database_eplay, $eplay);
$query_mem = sprintf("SELECT * FROM memberdata WHERE memId = %s", GetSQLValueString($colname_mem, "text"));
$mem = mysql_query($query_mem, $eplay) or die(mysql_error());
$row_mem = mysql_fetch_assoc($mem);
$totalRows_mem = mysql_num_rows($mem);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> e旅遊-美食 </title>

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
    .style20 {	font-size: 12pt;
	color: #CC0066;
	font-weight: bold;
}
.style211 {	font-size: 12pt;
	font-weight: bold;
}
    .style201 {	font-size: 12pt;
	color: #000;
	font-weight: bold;
}
</style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
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
                <div class="panel-heading">
                  <p>美食</p>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <form action="<?php echo $editFormAction; ?>" name="form3" enctype="multipart/form-data" method="POST">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <th width="250" rowspan="4"><img src="foodimg/<?php echo $row_productRec['goods_img']; ?>" alt="" width="250" height="250" /></th>
                          <td height="52" colspan="4" bgcolor="#FFFFFF">編號：<?php echo $row_productRec['goods_id']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="4" bgcolor="#FFE1F0"><?php echo $row_productRec['goods_name']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="4" bgcolor="#FFFFFF"><p class="style201"><?php echo $row_productRec['goods_desc']; ?></p>
                            <p class="style201"><br />
                          </p></td>
                        </tr>
                        <tr>
                          <td height="88" colspan="4" bgcolor="#FFFFFF"><p class="style201"><span class="style20">地址&nbsp;:<?php echo $row_productRec['goods_stand']; ?><br />
電話&nbsp;: <?php echo $row_productRec['goods_price']; ?></span></p>
                          <p class="style201">
                            <input name="love" type="submit" value="收藏"  >
                            <input name="memId" type="hidden" id="memId" value="<?php echo $row_mem['memId']; ?>">
                            <input name="goods_img" type="hidden" id="goods_img" value="<?php echo $row_productRec['goods_img']; ?>">
                          </p></td>
                        </tr>
                      </tbody>
                    </table>
                    <p><span class="style201">
                    <input name="goods_id" type="hidden" id="goods_id" value="<?php echo $row_productRec['goods_id']; ?>" />
                    <input name="goods_name" type="hidden" id="goods_name" value="<?php echo $row_productRec['goods_name']; ?>" />
                    <input name="goods_stand" type="hidden" id="goods_stand" value="<?php echo $row_productRec['goods_stand']; ?>" />
                    <input name="goods_price" type="hidden" id="goods_price" value="<?php echo $row_productRec['goods_price']; ?>" />
                    <input name="ord_id" type="hidden" id="ord_id" value="<?php echo $tempord_id?>" />
                    </span></p>
                    <p>&nbsp;</p>
                    <input type="hidden" name="MM_insert" value="form3">
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
mysql_free_result($productRec);

mysql_free_result($mem);
?>
