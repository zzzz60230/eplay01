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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
	
move_uploaded_file($_FILES["goods_img"]["tmp_name"], "foodimg\\" . $_FILES["goods_img"]["name"]);

$insertSQL = sprintf("INSERT INTO food_goods (goods_id, goods_name, goods_price, goods_stand, goods_desc, goods_img, item_id) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['goods_id'], "text"),
                       GetSQLValueString($_POST['goods_name'], "text"),
                       GetSQLValueString($_POST['goods_price'], "int"),
                       GetSQLValueString($_POST['goods_stand'], "text"),
                       GetSQLValueString($_POST['goods_desc'], "text"),
                       GetSQLValueString($_FILES["goods_img"]["name"], "text"),
                       GetSQLValueString($_POST['item_id'], "int"));

	
 

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($insertSQL, $eplay) or die(mysql_error());

  $insertGoTo = "admin_food.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_eplay, $eplay);
$query_itemRec = "SELECT * FROM shop_item";
$itemRec = mysql_query($query_itemRec, $eplay) or die(mysql_error());
$row_itemRec = mysql_fetch_assoc($itemRec);
$totalRows_itemRec = mysql_num_rows($itemRec);

$query_showitemRec = "SELECT shop_item.item_id,shop_item.item_name,count(food_goods.item_id) as num FROM shop_item LEFT OUTER JOIN food_goods    ON shop_item.item_id=food_goods.item_id GROUP BY shop_item.item_id ";
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

    <title> e旅遊-上架美食 </title>

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
                <div class="panel-heading">上架美食</div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <p>
                    <!-- /.table-responsive -->
                  </p>
                  <form action="<?php echo $editFormAction; ?>" name="form3" enctype="multipart/form-data" method="POST">
                    <span style="color: #000000; font-size: 20px;font-family: '微軟正黑體';"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="1">
                      <tr>
                        <td width="10%" align="left"><div align="right"><span class="style15">分類</span></div></td>
                        <td width="90%"><div align="left">
                          <select name="item_id" id="item_id">
                            <?php
do {  
?>
                            <option value="<?php echo $row_itemRec['item_id']?>"><?php echo $row_itemRec['item_name']?></option>
                            <?php
} while ($row_itemRec = mysql_fetch_assoc($itemRec));
  $rows = mysql_num_rows($itemRec);
  if($rows > 0) {
      mysql_data_seek($itemRec, 0);
	  $row_itemRec = mysql_fetch_assoc($itemRec);
  }
?>
                          </select>
                        </div></td>
                      </tr>
                      <tr>
                        <td align="left"><div align="right">名稱</div></td>
                        <td><div align="left">
                          <input name="goods_name" type="text" id="goods_name" />
                        </div></td>
                      </tr>
                      <tr>
                        <td align="left"><div align="right">圖片</div></td>
                        <td><div align="left">
                          <input type="file" name="goods_img" id="goods_img" />
                        </div></td>
                      </tr>
                      <tr>
                        <td align="left"><div align="right">編號</div></td>
                        <td><div align="left">
                          <input type="text" name="goods_id" id="goods_id" />
                        </div></td>
                      </tr>
                      <tr>
                        <td align="left"><div align="right">電話</div></td>
                        <td><div align="left">
                          <input type="text" name="goods_price" id="goods_price" />
                        </div></td>
                      </tr>
                      <tr>
                        <td align="left"><div align="right">地址</div></td>
                        <td><div align="left">
                          <input type="text" name="goods_stand" id="goods_stand" />
                        </div></td>
                      </tr>
                      <tr>
                        <td align="left"><div align="right">說明</div></td>
                        <td><textarea name="goods_desc" id="goods_desc" cols="65" rows="5"></textarea></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><button type="image" class="btn btn-danger">新增</button></td>
                      </tr>
                    </table></span>
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
mysql_free_result($itemRec);
?>
