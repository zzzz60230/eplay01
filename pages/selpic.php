<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上傳檔案:點擊圖片可關閉視窗</title>

<script language="javascript">
function seeImg(obj){  
   var fileext=obj.value.substring(obj.value.lastIndexOf("."),obj.value.length) 
   fileext=fileext.toLowerCase() 
      if ((fileext!='.jpg')&&(fileext!='.gif')&&(fileext!='.jpeg')&&(fileext!='.png')&&(fileext!='.bmp')) 
      { 
         alert("檔案格式不符喔 !"); 
         obj.focus(); 
      }else{ 
        document.imageform.submit();
      } 
} 
</script>


<style type="text/css">
<!--
body,td,th {
	font-size: 10px;
}
-->
</style></head>
<body id="imageform"><form method="POST" enctype="multipart/form-data" name="imageform" id="imageform">
        <table width="100%" border="0">
          <tr>
            <td><input type="file" name="imageUrl" id="imageUrl" onchange="seeImg(this);" /></td>
          </tr>
          <tr>
            <td><img id="tempimg" name="tempimg" src="photos/guest.jpg" width="150" height="180" alt="個人圖像:點擊圖片可關閉視窗" onclick="window.close();" />
             <div id="errMsg">
            </div>
            </td>
          </tr>
        </table>
</form>

<?php
//如果已指定檔案
 if ( $_FILES["imageUrl"]["name"] <> "" ) 
 {
  //如果檔案上傳成功
  if ($_FILES["imageUrl"]["errok"] == UPLOAD_ERR_OK)
   {
    //取得系統時間的時分秒資料串接在檔案名稱之前
    $reSetFileName=("Eplay_").$_FILES["imageUrl"]["name"];
    //如果檔案儲存成功
    if (move_uploaded_file($_FILES["imageUrl"]["tmp_name"], "upPhoto\\" . $reSetFileName))
     {
      echo '<script language="javascript">';
      echo 'document.getElementById("tempimg").src="upPhoto/' . $reSetFileName . '";';
      echo 'window.opener.dataform.realimage.value="' . $reSetFileName . '";';
      echo 'window.opener.document.getElementById("tempimg").src="upPhoto/' . $reSetFileName . '";';
      echo 'document.getElementById("errMsg").innerHTML="<input type=\'button\' onclick=\'window.close();\' value=\'確定使用此圖片\'>";';
      echo '</script>';
     //如果檔案儲存失敗
     }else{
      echo '<script language="javascript">';
      echo 'document.getElementById("errMsg").innerHTML="<font color=red>檔案存檔發生錯誤錯誤!!</font>";';
      echo '</script>';
     }
   //如果檔案上傳失敗
   }else{
    echo '<script language="javascript">';
    echo 'document.getElementById("errMsg").innerHTML="<font color=red>檔案內容或網路傳輸錯誤!!</font>";';
    echo '</script>';
   }
  } 
?>

</body>
</html>
