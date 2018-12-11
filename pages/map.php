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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO `map` (address, gps, name) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['gps'], "text"),
                       GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($insertSQL, $eplay) or die(mysql_error());

  $insertGoTo = "map.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$host='localhost';
$dbuser='root';
$dbpw='66666666';
$dbname='eplay';

$link=mysqli_connect($host,$dbuser,$dbpw,$dbname);
if($link){mysqli_query($link,"SET NAME utf8");
echo"以正確連線";}
else
{echo'無法連線資料庫:<br/>'.mysqli_connect_error();}
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
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyBsKnzAmGPbRAHV8mTeR50Ax_S0x6HXdIE" type="text/javascript"></script>

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
                                  <a href="flot.html"> <span style="font-size: 18px; color: #000000; font-family: '微軟正黑體';">中部</spawn></a>
                              </li>
                                <li>
                                  <a href="morris.html">北部</a>
                                </li>
                          <li>
                                  <a href="morris.html">南部</a>
                                </li>
                         
                          <li>
                                  <a href="morris.html">東部</a>
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
              <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title"><font size="7">日月潭</font></h5>
                  </div>
                  <div class="panel-body">
                    <form role="form">
                      <fieldset>
                        <div class="form-group">
                        <fildeset>
                        <legend><font size="5">風景介紹</font>
                          <legend></legend>
                        <div class="form-group"></div>

                        <!-- Change this to a button or input when using this as a form -->
                        <p></p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29192.403995897068!2d120.90094269014446!3d23.85234046091003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3468d5e076ee0005%3A0xec17a6fd5312a528!2z5pel5pyI5r2t!5e0!3m2!1szh-TW!2stw!4v1532940027091" width="480" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                      </fieldset>
                    </form>
                  </div>
                  <form name="form1" method="post" action="">
                  
                     <label>
                            <input name="remember" type="checkbox" value="Remember Me">
                             <font size="5">加到我的最愛</font> </label>
                  </form>
                  <p>&nbsp;</p>
                </div>
              </div>
              
              
                    
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
              <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                  <div class="panel-heading"> 
                  
                    <h5 class="panel-title"><font size="7">日月潭</font></h5>
                  </div>
                  <div class="panel-body">
                    <form role="form">
                      <fieldset>
                        <div class="form-group">
                        <fildeset>
                        <legend>
                         <div class="title_text"><font size="5">篩選</font></a><DIV class="prw_rup prw_common_review_point_campaign button_war lanCTA pointCampaign" data-prwidget-name="common_review_point_campaign" data-prwidget-init="handlers"><div class="iconContainer asiamiles placetypeReview"><a href="/AsiaMiles" target="_blank"> </a></div>
                           <!-- PLACEMENT detail_filters:hr_resp -->
                           <div id="taplc_detail_filters_hr_resp_0" class="ppr_rup ppr_priv_detail_filters" data-placement-name="detail_filters:hr_resp"><div class="filters-all" data-targetEvent="update-detail_filters:hr_resp"><div class="collapsible is-shown-at-tablet" data-breakpoint="tablet"><div class="collapsibleContent ppr_rup ppr_priv_detail_filters">
                         </DIV>
                         </div></div><div class="header is-hidden-tablet"><div class="ui_close_x" onclick="placementEvCall('taplc_detail_filters_hr_resp_0', 'handlers.done', event, this);"></div></div><div class="ui_columns filters"><DIV class="prw_rup prw_filters_detail_checkbox ui_column separated is-5" data-prwidget-name="filters_detail_checkbox" data-prwidget-init="handlers"><div class="node-preserve" data-ajax-preserve="preserved-filters_detail_checkbox_trating_true"><div class="name ui_header h2" onclick="widgetEvCall('handlers.toggleCollapse', event, this);">旅客評等<span class="selection-preview"></span><span class="collapse_mark"><span class="ui_icon caret-down"></span><span class="ui_icon caret-up"></span></span></div><div class="content"><div class="choices"data-param="trating"data-name="ta_rating"><div class="ui_checkbox item" data-value="5" data-tracker="很棒"><input id="filters_detail_checkbox_trating__5"type="checkbox"value="5"class="filters_detail_checkbox_trating_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_trating__5" >很棒</label><span class="row_bar_cell"><span class="row_bar is-shown-at-tablet" onclick="document.getElementById('filters_detail_checkbox_trating__5').click()"><span class="row_fill" style="width:94.93506493506493%;"></span></span></span></div><div class="ui_checkbox item" data-value="4" data-tracker="非常好"><input id="filters_detail_checkbox_trating__4"type="checkbox"value="4"class="filters_detail_checkbox_trating_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_trating__4">非常好</label><span class="row_bar_cell"><span class="row_bar is-shown-at-tablet" onclick="document.getElementById('filters_detail_checkbox_trating__4').click()"><span class="row_fill" style="width:4.545454545454546%;"></span></span></span></div><div class="ui_checkbox item" data-value="3" data-tracker="一般"><input id="filters_detail_checkbox_trating__3"type="checkbox"value="3"class="filters_detail_checkbox_trating_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_trating__3" >一般</label><span class="row_bar_cell"><span class="row_bar is-shown-at-tablet" onclick="document.getElementById('filters_detail_checkbox_trating__3').click()"><span class="row_fill" style="width:0.5194805194805194%;"></span></span></span></div><div class="ui_checkbox item" data-value="2" data-tracker="差"><input id="filters_detail_checkbox_trating__2"type="checkbox"value="2"class="filters_detail_checkbox_trating_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_trating__2" >差</label><span class="row_bar_cell"><span class="row_bar is-shown-at-tablet" onclick="document.getElementById('filters_detail_checkbox_trating__2').click()"></span></span></div><div class="ui_checkbox item" data-value="1" data-tracker="糟透了"><input id="filters_detail_checkbox_trating__1"type="checkbox"value="1"class="filters_detail_checkbox_trating_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_trating__1" >糟透了</label><span class="row_bar_cell"><span class="row_bar is-shown-at-tablet" onclick="document.getElementById('filters_detail_checkbox_trating__1').click()"></span></span></div></div></div></div></DIV><DIV class="prw_rup prw_filters_detail_checkbox ui_column separated is-2" data-prwidget-name="filters_detail_checkbox" data-prwidget-init="handlers"><div class="node-preserve" data-ajax-preserve="preserved-filters_detail_checkbox_filterSegment_true"><div class="name ui_header h2" onclick="widgetEvCall('handlers.toggleCollapse', event, this);">旅客類型<span class="selection-preview"></span><span class="collapse_mark"><span class="ui_icon caret-down"></span><span class="ui_icon caret-up"></span></span></div><div class="content"><div class="choices"data-param="filterSegment"data-name="traveler_filter"><div class="ui_checkbox item" data-value="3" data-tracker="家庭出遊"><input id="filters_detail_checkbox_filterSegment__3"type="checkbox"value="3"class="filters_detail_checkbox_filterSegment_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSegment__3" >家庭出遊</label></div><div class="ui_checkbox item" data-value="2" data-tracker="伴侶旅行"><input id="filters_detail_checkbox_filterSegment__2"type="checkbox"value="2"class="filters_detail_checkbox_filterSegment_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSegment__2">伴侶旅行</label></div><div class="ui_checkbox item" data-value="5" data-tracker="單獨旅行"><input id="filters_detail_checkbox_filterSegment__5"type="checkbox"value="5"class="filters_detail_checkbox_filterSegment_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSegment__5" >單獨旅行</label></div><div class="ui_checkbox item" data-value="1" data-tracker="商務出差"><input id="filters_detail_checkbox_filterSegment__1"type="checkbox"value="1"class="filters_detail_checkbox_filterSegment_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSegment__1" >商務出差</label></div><div class="ui_checkbox item" data-value="4" data-tracker="好友旅行"><input id="filters_detail_checkbox_filterSegment__4"type="checkbox"value="4"class="filters_detail_checkbox_filterSegment_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSegment__4" >好友旅行</label></div></div></div></div></DIV><DIV class="prw_rup prw_filters_detail_checkbox ui_column separated is-2" data-prwidget-name="filters_detail_checkbox" data-prwidget-init="handlers"><div class="node-preserve" data-ajax-preserve="preserved-filters_detail_checkbox_filterSeasons_true"><div class="name ui_header h2" onclick="widgetEvCall('handlers.toggleCollapse', event, this);">月份<span class="selection-preview"></span><span class="collapse_mark"><span class="ui_icon caret-down"></span><span class="ui_icon caret-up"></span></span></div><div class="content"><div class="choices"data-param="filterSeasons"data-name="season"><div class="ui_checkbox item" data-value="1" data-tracker="3 月到 5 月"><input id="filters_detail_checkbox_filterSeasons__1"type="checkbox"value="1"class="filters_detail_checkbox_filterSeasons_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSeasons__1">3 月到 5 月</label></div><div class="ui_checkbox item" data-value="2" data-tracker="6 月到 8 月"><input id="filters_detail_checkbox_filterSeasons__2"type="checkbox"value="2"class="filters_detail_checkbox_filterSeasons_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSeasons__2" >6 月到 8 月</label></div><div class="ui_checkbox item" data-value="3" data-tracker="9 月到 11 月"><input id="filters_detail_checkbox_filterSeasons__3"type="checkbox"value="3"class="filters_detail_checkbox_filterSeasons_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSeasons__3" >9 月到 11 月</label></div><div class="ui_checkbox item" data-value="4" data-tracker="12 月到 2 月"><input id="filters_detail_checkbox_filterSeasons__4"type="checkbox"value="4"class="filters_detail_checkbox_filterSeasons_cbx"onchange="widgetEvCall('handlers.updateFilter', event, this);"><label for="filters_detail_checkbox_filterSeasons__4" >12 月到 2 月</label></div></div></div></div></DIV><DIV class="prw_rup prw_filters_detail_language ui_column separated is-3" data-prwidget-name="filters_detail_language" data-prwidget-init="handlers"><div class="node-preserve" data-ajax-preserve="preserved-filters_detail_language_filterLang"><div class="name ui_header h2" onclick="widgetEvCall('handlers.toggleCollapse', event, this);">
                        </legend>
                        <div class="form-group"></div>
                         <font size="3">
                        日月潭國家風景區於2014年，被觀光局列為適合銀髮族出遊的熱門風景區之一，以「車程短、走得慢、吃的軟、看的久」等主打訴求，強調養生、樂活、自然、無障礙，規劃「慢活悠遊之旅」行程，鼓勵長者出遊體驗不一樣的國內旅遊。遊日月潭可選擇搭遊艇、健行、騎自行車等方式，在日月潭共有水社碼頭、伊達邵碼頭、朝霧碼頭、<a href="http://travel.network.com.tw/tourguide/point/showpage/104703.html">玄光寺</a>碼頭等四個公共碼頭，一般遊湖行程大約需二小時左右，您有可在碼頭租用手划船與知心伴侶倘佯在日月潭的湖光水色浪漫一下。<a href="http://travel.network.com.tw/tourguide/point/showpage/70.html">日月潭國家風景區</a>管理處近年來規劃了幾條自行車悠遊的路線，其中以『環湖公路』為最佳，環湖公路全長約33公里，建議以自行車為主要交通工具，再搭配延途各個景點作為親子休閒一日遊，不但可以健身，又可悠閒的瀏覽體會日月潭好山好水與美麗風景；日月潭環湖公路有順時針方向或逆時針方向兩種環湖方式，『順時針環湖方向』係緊鄰潭邊，以欣賞月月潭潭面的湖光水色為主，但在安全上因在路的外側，所以也較逆時針方向危險；逆時針環湖方向因對向來車會阻擋到視線，故延途也較無法隨意欣賞日月潭潭面的湖光水色。</font>
                      
                        <!-- Change this to a button or input when using this as a form -->
                        <p></p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29192.403995897068!2d120.90094269014446!3d23.85234046091003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3468d5e076ee0005%3A0xec17a6fd5312a528!2z5pel5pyI5r2t!5e0!3m2!1szh-TW!2stw!4v1532940027091" width="480" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>



                        <img src="../1468634691-34699267_n.jpg" alt="日月潭" width="480" height="400" usemap="#Map">
                        <map name="Map">
                          <area shape="rect" coords="151,113,229,147" href="https://nanai.tw/sunmoonlake-shuishepier/">
                          <area shape="rect" coords="133,261,197,291" href="http://www.sunmoonlake.gov.tw/Accessibility/SceneryDetail.aspx?KeyID=b2291032-9b10-47f7-badb-8185b484405c">
                          <area shape="rect" coords="226,262,294,295" href="http://www.sunmoonlake.gov.tw/Accessibility/SceneryDetail.aspx?KeyID=4111222d-bd95-47ed-9374-998c8890f164">
                          <area shape="rect" coords="409,38,478,124" href="https://www.nine.com.tw/">
                        </map> 
                        <a href=https://www.google.com/maps?ll=23.852302,120.918452&z=13&t=m&hl=zh-TW&gl=TW&mapclient=embed&cid=18107808634064367603>日月潭
                        </a>
                      </fieldset>
                    </form>
                  </div>
                  <form name="form1" method="post" action="">
                  
                     <label>
                            <input name="remember" type="checkbox" value="Remember Me">
                             <font size="5">加到我的最愛</font> </label>
                  </form>
                  <p>&nbsp;</p>
                </div>
              </div>
                    <h3 class="panel-title">&nbsp;</h3>
                  </div>
                </div>
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
<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Address:</td>
      <td><input type="text" name="address" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Gps:</td>
      <td><input type="text" name="gps" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="插入記錄"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2">
</form>
<p>&nbsp;</p>
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
