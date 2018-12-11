<?php session_start()?>
<?php require_once('../Connections/eplay.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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

mysql_select_db($database_eplay, $eplay);
$query_personal_pageRec = "SELECT * FROM memberdata";
$personal_pageRec = mysql_query($query_personal_pageRec, $eplay) or die(mysql_error());
$row_personal_pageRec = mysql_fetch_assoc($personal_pageRec);
$colname_personal_pageRec = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_personal_pageRec = $_SESSION['MM_Username'];
}
mysql_select_db($database_eplay, $eplay);
$query_personal_pageRec = sprintf("SELECT * FROM memberdata WHERE memberdata.memId = %s", GetSQLValueString($colname_personal_pageRec, "text"));
$personal_pageRec = mysql_query($query_personal_pageRec, $eplay) or die(mysql_error());
$row_personal_pageRec = mysql_fetch_assoc($personal_pageRec);
$totalRows_personal_pageRec = mysql_num_rows($personal_pageRec);

$colname_person_picRec = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_person_picRec = $_SESSION['MM_Username'];
}
mysql_select_db($database_eplay, $eplay);
$query_person_picRec = sprintf("SELECT * FROM personal_pic WHERE personal_pic.memld = %s", GetSQLValueString($colname_person_picRec, "text"));
$person_picRec = mysql_query($query_person_picRec, $eplay) or die(mysql_error());
$row_person_picRec = mysql_fetch_assoc($person_picRec);
$totalRows_person_picRec = mysql_num_rows($person_picRec);

$colname_love = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_love = $_SESSION['MM_Username'];
}
mysql_select_db($database_eplay, $eplay);
$query_love = sprintf("SELECT * FROM love_goods WHERE memId = %s ORDER BY loveId DESC", GetSQLValueString($colname_love, "text"));
$love = mysql_query($query_love, $eplay) or die(mysql_error());
$row_love = mysql_fetch_assoc($love);
$totalRows_love = mysql_num_rows($love);

$colname_love2 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_love2 = $_SESSION['MM_Username'];
}
mysql_select_db($database_eplay, $eplay);
$query_love2 = sprintf("SELECT * FROM love_food WHERE memId = %s ORDER BY loveId DESC", GetSQLValueString($colname_love2, "text"));
$love2 = mysql_query($query_love2, $eplay) or die(mysql_error());
$row_love2 = mysql_fetch_assoc($love2);
$totalRows_love2 = mysql_num_rows($love2);
 session_start()?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> e旅遊-所有收藏 </title>

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
    .heart {    width: 80px;
    height: 80px;
    background: url("https://cssanimation.rocks/images/posts/steps/heart.png") no-repeat;
    background-position: 0 0;
    cursor: pointer;
    -webkit-transition: background-position 1s steps(28);
    transition: background-position 1s steps(28);
    -webkit-transition-duration: 0s;
    transition-duration: 0s;
}
.heart {    -webkit-transition-duration: 1s;
    transition-duration: 1s;
    background-position: -2800px 0;
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
              <div class="alert alert-danger" role="alert">
              <span style="color: #000000; font-size: 22px;font-family: '微軟正黑體';"><b>所有收藏</b></span></div>
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading"><span style="color: #000000; font-size: 22px;font-family: '微軟正黑體';"><b>景點</div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    <p>&nbsp;</p>
                    <form name="form4" method="post" action="">
                      <p>
                        <input name="memId" type="hidden" id="memId">
                      </p>
                      <div id="showgoods3">
                        <?php do { ?>
                        <table width="3" border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><div id="showgoods4">
                              <table width="2" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td><a href="goods_content.php?goods_id=<?php echo $row_love['goods_id']; ?>"><img src="goodsimg/<?php echo $row_love['goods_img']; ?>" alt="" width="165" height="165" /></a><a href="goods.php?goods_id=<?php echo $row_productRec['goods_id']; ?>"></a></td>
                                </tr>
                                <tr>
                                  <td><div align="left" style="width:165px;height:50px;"><?php echo $row_love['goods_name']; ?></div></td>
                                </tr>
                                  
                                <tr>
                                  <td><script src="http://wow.techbrood.com/libs/jquery/jquery-1.11.1.min.js"></script></td>
                                </tr>
                              </table>
                              </div>
                              <a href="goods_content.php?goods_id=<?php echo $row_productRec['goods_id']; ?>"></a></td>
                          </tr>
                        </table>
                          <?php } while ($row_love = mysql_fetch_assoc($love)); ?>
                      </div>
                    </form>
                    <form name="form1" method="post" action="">
                      <div id="showgoods2"></div>
                    </form>
                    <p>&nbsp;</p>

                    <form name="form3" method="post" action="">
                      <div class="albumDiv">
                        <div class="picDiv"></a></div>
                        <div class="albuminfo"></div>
                      </div>
                      <div id="showgoods"></div>
                    </form>
<p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
<!-- /.panel-body -->
                </div>
                <!-- /.panel --></div>
              <!-- /.col-lg-8 --><!-- /.col-lg-4 -->
            </div>
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">美食</div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    <p>&nbsp;</p>
                    <form name="form4" method="post" action="">
                      <div id="showgoods6">
                        <?php do { ?>
                          <table width="3" border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><div id="showgoods9">
                                <table width="2" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><a href="food_content.php?goods_id=<?php echo $row_love2['goods_id']; ?>"><img src="foodimg/<?php echo $row_love2['goods_img']; ?>" alt="" width="165" height="165" /></a><a href="goods.php?goods_id=<?php echo $row_productRec['goods_id']; ?>"></a></td>
                                  </tr>
                                  <tr>
                                    <td><div align="left" style="width:165px;height:50px;"><?php echo $row_love2['goods_name']; ?></div></td>
                                  </tr>
                                </table>
                              </div>
                                <a href="goods_content.php?goods_id=<?php echo $row_productRec['goods_id']; ?>"></a></td>
                            </tr>
                          </table>
                          <?php } while ($row_love2 = mysql_fetch_assoc($love2)); ?>
                      </div>
                      <p>&nbsp;</p>
                      <div id="showgoods5"></div>
                    </form>
                    <form name="form1" method="post" action="">
                      <div id="showgoods7"></div>
                    </form>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <form name="form3" method="post" action="">
                      <div class="albumDiv">
                        <div class="picDiv"></a></div>
                        <div class="albuminfo"></div>
                      </div>
                      <div id="showgoods8"></div>
                    </form>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <!-- /.panel-body -->
                  </div>
                  <!-- /.panel -->
                <b></span></div>
                <!-- /.col-lg-8 -->
                <!-- /.col-lg-4 -->
              </div>
              <p>&nbsp;</p>
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
mysql_free_result($personal_pageRec);

mysql_free_result($person_picRec);

mysql_free_result($love);

mysql_free_result($love2);
?>
