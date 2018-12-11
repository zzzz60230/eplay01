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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		
	move_uploaded_file($_FILES["realimage"]["tmp_name"], "goodsimg\\" . $_POST['realimage']);
	
  $insertSQL = sprintf("INSERT INTO memberdata (memId, memPsw, memName, memEmail, memPId, memBirthday, memSex, memTel, memAddress, realimage) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['memId'], "text"),
                       GetSQLValueString($_POST['pass1'], "text"),
                       GetSQLValueString($_POST['memName'], "text"),
                       GetSQLValueString($_POST['memEmail'], "text"),
                       GetSQLValueString($_POST['memPId'], "text"),
                       GetSQLValueString($_POST['memBirthday'], "date"),
                       GetSQLValueString($_POST['memSex'], "text"),
                       GetSQLValueString($_POST['memTel'], "text"),
                       GetSQLValueString($_POST['memAddress'], "text"),
                       GetSQLValueString($_POST['realimage'], "text"));

  mysql_select_db($database_eplay, $eplay);
  $Result1 = mysql_query($insertSQL, $eplay) or die(mysql_error());

  $insertGoTo = "addok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_eplay, $eplay);
$query_addmemRec = "SELECT * FROM memberdata";
$addmemRec = mysql_query($query_addmemRec, $eplay) or die(mysql_error());
$row_addmemRec = mysql_fetch_assoc($addmemRec);
$totalRows_addmemRec = mysql_num_rows($addmemRec);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> e旅遊-加入會員 </title>

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
                    <a class="dropdown-toggle ; bg-danger ; " data-toggle="dropdown" href="index.php">
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
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">加入會員</div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    <p><!-- /.table-responsive --></p>
                    <div class="albumDiv">
                      <div class="picDiv">
                        <form method="POST" name="form1" onSubmit="MM_validateForm('exampleInputPassword1','','R','exampleInputPassword2','','R');return document.MM_returnValue">
                          <div class="form-group"></div>
                        </form>
                        <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
<table width="650" border="0" cellspacing="0" cellpadding="5">
                            <tr class="m08">
                              <td width="84" align="left"><span class="style42">帳　　號：</span></td>
                              <td width="546" align="left" class="style42"><input name="memId" type="text" size="25" maxlength="30" onBlur="chkUserID(this);" ><span id="idErrMsg"> </span></td>
                            </tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">密　　碼：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield8">
                                <input name="pass1" id="pass1" type="password" size="25" maxlength="30" />
                                <span class="textfieldRequiredMsg">請輸入密碼。</span></span></td>
</tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">確認密碼：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield7">
                                <input name="pass2" type="password" size="25" maxlength="30" />
                                <span class="textfieldRequiredMsg">請再次輸入密碼作為確認。</span><span class="textfieldInvalidFormatMsg">兩次輸入密碼必須相同。</span></span></td>
</tr>
                            <tr class="m08">
                              <td width="84" align="left"><span class="style42">姓　　名：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield4">
                                <input name="memName" type="text" size="25" maxlength="40" id="memName" />
                                <span class="textfieldRequiredMsg">請輸入姓名。</span></span>
                                <input name="memSex" type="radio" value="m" checked>
先生
<input name="memSex" type="radio" value="f">
小姐 </td>
</tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">生　　日：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield3">
                                <label>
                                  <input name="memBirthday" type="text" id="memBirthday" size="25" maxlength="10" />
                                  <font color="red">*</font><span class="style6">yyyy/mm/dd</span></label>
                                <span class="textfieldRequiredMsg">請輸入生日。</span><span class="textfieldInvalidFormatMsg">請輸入正確格式的生日。</span></span></td>
</tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">身分證字號：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield2">
                                <input name="memPId" type="text" id="memPId" size="25" maxlength="15" />
                                <span class="textfieldRequiredMsg">請輸入身分證字號。</span></span></td>
</tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">居住地址：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield5">
                                <input name="memAddress" type="text" size="35" value="" id="memAddress" />
                                <span class="textfieldRequiredMsg">請輸入住址。</span></span><font color=red>* 請勿填寫郵政信箱</font></td>
</tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">電子郵件：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield1">
                                <input name="memEmail" type="text" size="25" maxlength="100" id="memEmail" />
                                <span class="textfieldRequiredMsg">請輸入電子郵件。</span><span class="textfieldInvalidFormatMsg">請正確填寫Email。</span></span></td>
</tr>
                            <tr class="m08">
                              <td align="left"><span class="style42">聯絡電話：</span></td>
                              <td align="left" class="style42"><span id="sprytextfield6">
                                <input name="memTel" type="text" id="memTel" size="25" maxlength="50" />
                                <span class="textfieldRequiredMsg">請輸入電話。</span></span></td>
</tr>
                          </table>
               <input type="submit" name="submit" id="submit" value="加入會員" />
               <input type="hidden" name="MM_insert" value="form1">
            </form>
          </td>
        </tr>
    </table></td>
    
  
</table>            

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
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"yyyy/mm/dd"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "custom", {validation:chkpas, validateOn:["blur"]} );
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>




</body>

</html>
<?php
mysql_free_result($addmemRec);
?>
