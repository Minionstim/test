<?php 
	header("content-type:text/html;charset=utf-8");
	include_once '../dbio/NewsTypes.php';
	include_once '../dbio/NewsArticles.php';
	include_once 'nologin.php';
	
	//获得表单提交的数据
	$title = $_POST["title"];
	$typeId = $_POST["typeId"];
	$writer = $_POST["writer"];
	$source = $_POST["source"];
	$newsImg = $_FILES["newsImg"];
	$content = $_POST["content"];
	
	//表单提交(添加新闻)
	if($content != NULL)
	{
		$savePath = NULL;
		//是否上传了图片
		if($newsImg["name"] != NULL)
		{
			$fileName = $newsImg["name"];//图片的原名
			$arr = explode(".",$fileName);//拆分字符串
			$ext = $arr[count($arr)-1];//扩展名
			$ext = strtolower($ext);
			
			if($ext == "jpg" || $ext=="gif" || $ext=="png" || $ext=="jpeg")
			{
				if($newsImg["size"] > 2000000)
				{
					header("location:success.php?act=addnews&rst=2");
				}
				else
				{
					$trueName = md5(time().rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9)).".".$ext;
					$savePath = "newspicture/{$trueName}";//保存路径
					move_uploaded_file($newsImg["tmp_name"],"../{$savePath}");
				}
			}
			else
			{
				header("location:success.php?act=addnews&rst=1");
			}
		}
		//添加数据库
		$userName = $_SESSION["userMsg"]["userName"];
		$result = NewsArticles::addNews($content, $title, $typeId, $userName, $writer, $source, $savePath);
		if($result > 0)
		{
			NewsTypes::addNums($typeId);//新闻数量加一
			header("location:success.php?act=addnews&rst=3");
		}
		else
		{
			header("location:success.php?act=addnews&rst=4");
		}
	}
	
	
	
	$newsTypes = NewsTypes::getNewsTypes();//所有分类
?>
<!DOCTYPE html>
<html>
  <head>
    <title>添加新闻</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../jquery/jquery-1.4.js"></script>
    <script type="text/javascript" src="../kindeditor/kindeditor.js"></script>
    <script type="text/javascript">
      var editor;
      KindEditor.ready(function(e){
          editor = e.create("[name=content]",{
              "width":"700px",
              "height":"300px"
          });
      });
      //表单验证
      function checkAddNews()
      {
          if(document.frm.title.value == "")
          {
              alert("请输入新闻的标题！");
              document.frm.title.focus();
          }
          else if(editor.html() == "")
          {
              alert("请输入新闻的内容！");
              editor.focus();
          }
          else
          {
              document.frm.content.value = editor.html();
              document.frm.submit();
          }
      }
      //表单重置
      function clearForm()
      {
          editor.html("");
          document.frm.reset();
      }
    </script>
  </head>
  <body>
    <!-- 包含头 -->
    <?php include_once 'header.php';?>
    <!-- 当前位置 -->
    <div class="locationDiv">后台管理：添加新闻</div>
    <!-- 页面内容 -->
    <div class="mainDiv clear">
      <!-- 左侧树状列表 -->
      <div class="leftDiv"><?php include_once 'left.php';?></div>
      <!-- 右侧正文内容 -->
      <div class="rightDiv">
        <form name="frm" method="post" action="addnews.php" enctype="multipart/form-data">
        <table class="addNews1" border="0" align="center">
          <tr>
            <td align="left">新闻标题：</td>
            <td align="left"><input type="text" name="title" size="50"></td>
          </tr>
          <tr>
            <td align="left">新闻类型：</td>
            <td align="left">
              <select name="typeId">
<?php 
	foreach ($newsTypes as $v)
	{
		echo "<option value='{$v["typeId"]}'>{$v["typeName"]}</option>";
	}
?>
              </select>
            </td>
          </tr>
          <tr>
            <td align="left">新闻作者：</td>
            <td align="left"><input type="text" name="writer" size="50"></td>
          </tr>
          <tr>
            <td align="left">新闻来源：</td>
            <td align="left"><input type="text" name="source" size="50"></td>
          </tr>
          <tr>
            <td align="left">新闻图片：</td>
            <td align="left"><input type="file" name="newsImg" size="50"></td>
          </tr>
          <tr>
            <td colspan="2"><textarea name="content"></textarea></td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <a href="#" onclick="checkAddNews()">添加</a>
              &nbsp;&nbsp;&nbsp;
              <a href="#" onclick="clearForm()">取消</a>
            </td>
          </tr>
        </table>
        </form>
      </div>
    </div>
  </body>
</html>




