<?php require_once('../Connections/eplay.php'); ?>
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

$maxRows_goodsRec = 8;
$pageNum_goodsRec = 0;
if (isset($_GET['pageNum_goodsRec'])) {
  $pageNum_goodsRec = $_GET['pageNum_goodsRec'];
}
$startRow_goodsRec = $pageNum_goodsRec * $maxRows_goodsRec;

mysql_select_db($database_eplay, $eplay);
$query_goodsRec = "SELECT * FROM shop_goods";
$query_limit_goodsRec = sprintf("%s LIMIT %d, %d", $query_goodsRec, $startRow_goodsRec, $maxRows_goodsRec);
$goodsRec = mysql_query($query_limit_goodsRec, $eplay) or die(mysql_error());
$row_goodsRec = mysql_fetch_assoc($goodsRec);

if (isset($_GET['totalRows_goodsRec'])) {
  $totalRows_goodsRec = $_GET['totalRows_goodsRec'];
} else {
  $all_goodsRec = mysql_query($query_goodsRec);
  $totalRows_goodsRec = mysql_num_rows($all_goodsRec);
}

$pageNum_goodsRec = 0;
if (isset($_GET['pageNum_goodsRec'])) {
  $pageNum_goodsRec = $_GET['pageNum_goodsRec'];
}
$startRow_goodsRec = $pageNum_goodsRec * $maxRows_goodsRec;

$maxRows_goodsRec = 8;
$pageNum_goodsRec = 0;
if (isset($_GET['pageNum_goodsRec'])) {
  $pageNum_goodsRec = $_GET['pageNum_goodsRec'];
}
$startRow_goodsRec = $pageNum_goodsRec * $maxRows_goodsRec;

mysql_select_db($database_eplay, $eplay);
$query_goodsRec = "SELECT * FROM shop_goods ORDER BY goods_date DESC";
$query_limit_goodsRec = sprintf("%s LIMIT %d, %d", $query_goodsRec, $startRow_goodsRec, $maxRows_goodsRec);
$goodsRec = mysql_query($query_limit_goodsRec, $eplay) or die(mysql_error());
$row_goodsRec = mysql_fetch_assoc($goodsRec);

if (isset($_GET['totalRows_goodsRec'])) {
  $totalRows_goodsRec = $_GET['totalRows_goodsRec'];
} else {
  $all_goodsRec = mysql_query($query_goodsRec);
  $totalRows_goodsRec = mysql_num_rows($all_goodsRec);
}
$totalPages_goodsRec = ceil($totalRows_goodsRec/$maxRows_goodsRec)-1;

$maxRows_foodRec = 8;
$pageNum_foodRec = 0;
if (isset($_GET['pageNum_foodRec'])) {
  $pageNum_foodRec = $_GET['pageNum_foodRec'];
}
$startRow_foodRec = $pageNum_foodRec * $maxRows_foodRec;

mysql_select_db($database_eplay, $eplay);
$query_foodRec = "SELECT * FROM food_goods ORDER BY goods_date DESC";
$query_limit_foodRec = sprintf("%s LIMIT %d, %d", $query_foodRec, $startRow_foodRec, $maxRows_foodRec);
$foodRec = mysql_query($query_limit_foodRec, $eplay) or die(mysql_error());
$row_foodRec = mysql_fetch_assoc($foodRec);

if (isset($_GET['totalRows_foodRec'])) {
  $totalRows_foodRec = $_GET['totalRows_foodRec'];
} else {
  $all_foodRec = mysql_query($query_foodRec);
  $totalRows_foodRec = mysql_num_rows($all_foodRec);
}
$totalPages_foodRec = ceil($totalRows_foodRec/$maxRows_foodRec)-1;

$maxRows_articleRec = 8;
$pageNum_articleRec = 0;
if (isset($_GET['pageNum_articleRec'])) {
  $pageNum_articleRec = $_GET['pageNum_articleRec'];
}
$startRow_articleRec = $pageNum_articleRec * $maxRows_articleRec;

mysql_select_db($database_eplay, $eplay);
$query_articleRec = "SELECT * FROM article_goods ORDER BY goods_date DESC";
$query_limit_articleRec = sprintf("%s LIMIT %d, %d", $query_articleRec, $startRow_articleRec, $maxRows_articleRec);
$articleRec = mysql_query($query_limit_articleRec, $eplay) or die(mysql_error());
$row_articleRec = mysql_fetch_assoc($articleRec);

if (isset($_GET['totalRows_articleRec'])) {
  $totalRows_articleRec = $_GET['totalRows_articleRec'];
} else {
  $all_articleRec = mysql_query($query_articleRec);
  $totalRows_articleRec = mysql_num_rows($all_articleRec);
}
$totalPages_articleRec = ceil($totalRows_articleRec/$maxRows_articleRec)-1;

$maxRows_preferRec = 6;
$pageNum_preferRec = 0;
if (isset($_GET['pageNum_preferRec'])) {
  $pageNum_preferRec = $_GET['pageNum_preferRec'];
}
$startRow_preferRec = $pageNum_preferRec * $maxRows_preferRec;

mysql_select_db($database_eplay, $eplay);
$query_preferRec = "SELECT * FROM prefer_goods ORDER BY goods_date DESC";
$query_limit_preferRec = sprintf("%s LIMIT %d, %d", $query_preferRec, $startRow_preferRec, $maxRows_preferRec);
$preferRec = mysql_query($query_limit_preferRec, $eplay) or die(mysql_error());
$row_preferRec = mysql_fetch_assoc($preferRec);

if (isset($_GET['totalRows_preferRec'])) {
  $totalRows_preferRec = $_GET['totalRows_preferRec'];
} else {
  $all_preferRec = mysql_query($query_preferRec);
  $totalRows_preferRec = mysql_num_rows($all_preferRec);
}
$totalPages_preferRec = ceil($totalRows_preferRec/$maxRows_preferRec)-1;

$maxRows_newsRec = 5;
$pageNum_newsRec = 0;
if (isset($_GET['pageNum_newsRec'])) {
  $pageNum_newsRec = $_GET['pageNum_newsRec'];
}
$startRow_newsRec = $pageNum_newsRec * $maxRows_newsRec;

mysql_select_db($database_eplay, $eplay);
$query_newsRec = "SELECT * FROM placardmain ORDER BY postDate DESC";
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
 if (!isset($_SESSION)){session_start();} ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> e旅遊-首頁 </title>

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
                        <li><a href="love2_index.php"><i class="fa fa-gear fa-fw"></i> 所有收藏</a>
                        </li>
                        <li><a href="addmem.php"><i class="fa fa-gear fa-fw"></i> 加入會員</a>
                        </li>
                        <li><a href="login_out.php"><i class="fa fa-gear fa-fw"></i> 登出會員</a>
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
                            <a href="search.php"> <input type="text" class="form-control"  placeholder="搜尋...">
                             </a>
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
                     <li>
                          <a href="love2_index.php"> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><b>所有收藏</b></span></a>
                         
                   
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
                    <h1 class="page-header">
                    
					<div id="myCarousel" class="carousel slide">
						
						
	<!-- 轮播（Carousel）指标 -->
	<!-- 轮播（Carousel）项目 -->
    
    <div class="container coverflow">
    
	<div class="carousel-inner" >
    
		<div class="item active"   >
			<img src="photos/w1.jpg" alt="First slide">
            <div class="carousel-caption">1</div>
        </div>
		<div class="item"  >
        
			<img src="photos/w3.jpg" alt="Second slide">
			<div class="carousel-caption">2</div>
		</div>
        
		<div class="item"  >
			<img src="photos/w4.jpg" alt="Third slide">
			<div class="carousel-caption">3</div>
		</div>
        
        <div class="item"  >
			<img src="photos/w5.jpg" alt="Third slide">
			<div class="carousel-caption">4</div>
		</div>
        
        <div class="item"  >
			<img src="photos/w2.jpg" alt="Third slide">
			<div class="carousel-caption">5</div>
		</div>
        
        <div class="item"  >
			<img src="photos/w6.jpg" alt="Third slide">
			<div class="carousel-caption">6</div>
		</div>
        
        <div class="item"  >
			<img src="photos/w7.jpg" alt="Third slide">
			<div class="carousel-caption">7</div>
		</div>
        
        <div class="item"  >
			<img src="photos/w8.jpg" alt="Third slide">
			<div class="carousel-caption">8</div>
		</div>
        <div class="item"  >
			<img src="photos/w9.jpg" alt="Third slide">
			<div class="carousel-caption">9</div>
		</div>
        
	</div>
	<!-- 轮播（Carousel）导航 -->
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	</a>

</div>
</div>
                  </h1>
              </div>
              <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row"></div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    
                    
                    
                    <!-- /.panel -->
                   
                   
                  <div class="panel panel-default">
                        <div class="panel-heading">
                          <p>所有景點
                          </p>
                            
                      </div>
                        <!-- /.panel-heading -->
                     
                          
                                
                                <!-- /.panel-heading -->
                                
                                  <!-- Nav tabs -->
                   
                  <div class="row show-grid" style="height:50px";>
                                <?php do { ?>
                                <div class="col-xs-6 col-md-3"><a href="goods_content.php?goods_id=<?php echo $row_goodsRec['goods_id']; ?>"><img name="" src="goodsimg/<?php echo $row_goodsRec['goods_img']; ?>" width="180" height="180" alt=""></a><b><span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><?php echo $row_goodsRec['goods_name']; ?></span></b><br>
                                </div>
                                  <?php } while ($row_goodsRec = mysql_fetch_assoc($goodsRec)); ?>
                                
                    </div>
                        
                   <a href="goods_index.php">
                   <button type="button" class="btn btn-primary" >查看全部</button>
                  </a>                  </div>
                   
                   
                   
                  <img src="photos/1539622335259.jpg" width="226" height="30">
                  
                  <div class="panel panel-default">
                        <div class="panel-heading">
                          <p>所有美食
                          </p>
                            
                      </div>
                        <!-- /.panel-heading -->
                     
                          
                                
                                <!-- /.panel-heading -->
                                
                                  <!-- Nav tabs -->
                   
                  <div class="row show-grid" style="height:50px";>
                       <?php do { ?>
                       <div class="col-xs-6 col-md-3">
                           <p><a href="food_content.php?goods_id=<?php echo $row_foodRec['goods_id']; ?>"><img name="" src="foodimg/<?php echo $row_foodRec['goods_img']; ?>" width="180" height="180" alt=""></a></p>
                           <b> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"> <p><?php echo $row_foodRec['goods_name']; ?></p>   </span></b>      
                           
                       </div>
                         <?php } while ($row_foodRec = mysql_fetch_assoc($foodRec)); ?>
                        
                   
                 
                    </div>
                    <a href="food_index.php">
                    <button type="button" class="btn btn-primary">查看全部</button>
                    </a>                     </div>
                     
                   <img src="photos/1539622335259.jpg" width="226" height="30">
                  
<!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <i class="fa fa-clock-o fa-fw"></i></div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"></div>
                        <!-- /.panel-body -->
                  </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i>所有遊記</div>
                        <!-- /.panel-heading -->
                      <div class="panel-body">
                        <div class="list-group">
                                <?php do { ?>
                                   <b> <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><a href="article_content.php?goods_id=<?php echo $row_articleRec['goods_id']; ?>" class="list-group-item"> <i class="fa fa-comment fa-fw"></i><?php echo $row_articleRec['goods_name']; ?></a></span></b>
                                  <?php } while ($row_articleRec = mysql_fetch_assoc($articleRec)); ?>
                          </div>
                          <!-- /.list-group -->
                          <a href="article_index.php" class="btn btn-default btn-block">查看全部</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>優惠活動</div>
                      <div class="panel-body">
                        <div id="morris-donut-chart"></div>
                          <p><b><span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';">
                            <?php do { ?>
                          <a href="prefer_content.php?goods_id=<?php echo $row_preferRec['goods_id']; ?>" class="list-group-item"> <i class="fa fa-comment fa-fw"></i><?php echo $row_preferRec['goods_name']; ?></a>
                              <?php } while ($row_preferRec = mysql_fetch_assoc($preferRec)); ?>
                          </span></b></p>
                          <p><a href="prefer_index.php" class="btn btn-default btn-block">查看全部</a></p>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                    
                    
                    
                    
                    
                        <!-- /.panel-body -->
                       
                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
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
mysql_free_result($goodsRec);

mysql_free_result($foodRec);

mysql_free_result($articleRec);

mysql_free_result($preferRec);

mysql_free_result($newsRec);
?>
