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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> e旅遊-所有頁面 </title>

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
    #wrapper #page-wrapper .row .panel.panel-default .panel-body form p {
	font-size: 24px;
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
              <div class="panel panel-default"><!-- /.panel-heading -->
                <div class="panel-body">
                  <p>
                    <!-- /.table-responsive -->
                  </p>
                  <form action="<?php echo $editFormAction; ?>" name="form3" enctype="multipart/form-data" method="POST">
                    <table width="77%" class="table table-bordered table-striped">
                      <tbody>
                      <tr>
                        <th colspan="4" bgcolor="#FF6699">所有頁面</th>
                        </tr>
                      
                      <tr>
                        <th width="28%" bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_member.php" class="breadcrumb">會員資料管理</a></span></th>
                        <td width="24%" bgcolor="#F5F5F5"><span class="breadcrumb"><a href="addmem.php" class="breadcrumb">加入會員</a></span></td>
                        <td width="24%" bgcolor="#F5F5F5"><span class="breadcrumb"><a href="addok.php" class="breadcrumb">加入成功</a></span></td>
                        <td width="24%" bgcolor="#F5F5F5"><span class="breadcrumb"><a href="login01.php" class="breadcrumb">登入會員</a></span></td>
                        </tr>
                      
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_article.php" class="breadcrumb">遊記管理</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_addarticle.php" class="breadcrumb">上架遊記(甄+宸)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="article_index.php" class="breadcrumb">所有遊記</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="article_content.php" class="breadcrumb">遊記詳細頁</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_goods.php" class="breadcrumb">景點管理</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_addgoods.php" class="breadcrumb">上架景點(甄+宸)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="goods_index.php" class="breadcrumb">所有景點</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="goods_content.php" class="breadcrumb">景點詳細頁</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_food.php" class="breadcrumb">美食管理</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_addfood.php" class="breadcrumb">上架美食(甄+宸)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="food_index.php" class="breadcrumb">所有美食</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="food_content.php" class="breadcrumb">美食詳細頁</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_prefer.php" class="breadcrumb">優惠管理</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_addprefer.php" class="breadcrumb">上架優惠(甄+宸)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="prefer_index.php" class="breadcrumb">所有優惠</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="prefer_content.php" class="breadcrumb">優惠詳細頁</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_news.php" class="breadcrumb">公告管理</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="addnews.php" class="breadcrumb">上架公告</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="news_index.php" class="breadcrumb">所有公告</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="editnews.php" class="breadcrumb">編輯公告</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="adminitem.php" class="breadcrumb">分類管理</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="seenews.php" class="breadcrumb">公告詳細頁</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="delnews.php" class="breadcrumb">刪除公告</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_page.php" class="breadcrumb">管理頁面</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="personal_data.php" class="breadcrumb">個人資料</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="personal_page.php" class="breadcrumb">個人頁面</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="realimage.php" class="breadcrumb">變更頭貼</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="aboutme.php" class="breadcrumb">關於我(欽)</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="index.php" class="breadcrumb">首頁</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="forget_pd.php" class="breadcrumb">忘記密碼</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="dm.php" class="breadcrumb">空白版型</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="question.php" class="breadcrumb">常見問題(欽)</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="map_index.php" class="breadcrumb">旅遊地圖(瑞)</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="stroke.php" class="breadcrumb">行程推薦(宸+欽)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="contactmeadmin.php" class="breadcrumb">聯絡我管理B(欽)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="contactme.php" class="breadcrumb">聯絡我B(欽)</a></span></td>
                        </tr>
                        <tr>
                          <th colspan="4" bgcolor="#FF6699">失敗頁面</th>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="admin_ord.php" class="breadcrumb">行程訂單管理X</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="car.php" class="breadcrumb">購物車X(甄)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="order.php" class="breadcrumb">下行程訂單X(甄)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="addphoto.php" class="breadcrumb">加入照片X(甄)</a></span></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="food1.php" class="breadcrumb">遊記版型X(瑞)</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="food4.php" class="breadcrumb">遊記版型X(瑞)</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="comment02.html" class="breadcrumb">排名(瑞)X</a></span></td>
                          <td bgcolor="#F5F5F5"><p><span class="breadcrumb"><a href="person_love.php" class="breadcrumb">個人收藏X(甄)</a></span></p></td>
                        </tr>
                        <tr>
                          <th bgcolor="#F5F5F5"><span class="breadcrumb"><a href="Evaluation.php" class="breadcrumb">評價(欽)X</a></span></th>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="comment.php" class="breadcrumb">排名(欽)X</a></span></td>
                          <td bgcolor="#F5F5F5"><span class="breadcrumb"><a href="map.php" class="breadcrumb">地圖X(宸)</a></span></td>
                          <td bgcolor="#F5F5F5">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                    <p>&nbsp; </p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
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
