<?php 
	header("content-type:text/html;charset=utf-8");
	session_start();
	
	$act = $_GET["act"];//操作类型
	$rst = $_GET["rst"];//操作结果
	$message = "";//提示信息
	$location = "";//跳转的地址
	
	if($act == "nologin")//没登陆直接访问的后台
	{
		$message = "您还没有登陆，无权访问该页面！";
		$location = "../index.php";
	}
	elseif($act == "logout")//退出登陆
	{
		unset($_SESSION["userMsg"]);
		$message = "正在退出后台管理！";
		$location = "../index.php";
	}
	elseif($act == "adduser")//添加用户
	{
		if($rst > 0)
		{
			$message = "用户添加成功！";
			$location = "adduser.php";
		}
		else
		{
			$message = "用户添加失败！";
			$location = "adduser.php";
		}
	}
	elseif($act == "addtype")//添加分类
	{
		if($rst > 0)
		{
			$message = "添加分类成功！";
			$location = "addtype.php";
		}
		else
		{
			$message = "添加分类失败！";
			$location = "addtype.php";
		}
	}
	elseif($act == "deltype")//删除分类
	{
		if($rst > 0)
		{
			$message = "删除分类成功！";
			$location = "modtype.php";
		}
		else
		{
			$message = "删除分类失败！";
			$location = "modtype.php";
		}
	}
	elseif($act == "updatetype")//修改分类
	{
		if($rst > 0)
		{
			$message = "修改分类成功！";
			$location = "modtype.php";
		}
		else
		{
			$message = "修改分类失败！";
			$location = "modtype.php";
		}
	}
	elseif($act == NULL)//直接访问后台的success.php页面
	{
		$message = "您还没有登陆，无权访问该页面！";
		$location = "../index.php";
	}
	elseif($act == "addnews")//添加新闻
	{
		if($rst == 1)
		{
			$message = "只允许上传图片！";
			$location = "addnews.php";
		}
		elseif($rst == 2)
		{
			$message = "最大只允许上传2M的图片！";
			$location = "addnews.php";
		}
		elseif($rst == 3)
		{
			$message = "新闻添加成功！";
			$location = "addnews.php";
		}
		elseif($rst == 4)
		{
			$message = "添加新闻失败！";
			$location = "addnews.php";
		}
	}
		elseif($act == "modification")//修改新闻
	{
		if($rst == 1)
		{
			$message = "只允许上传图片！";
			$location = "modification.php";
		}
		elseif($rst == 2)
		{
			$message = "最大只允许上传2M的图片！";
			$location = "modification.php";
		}
		elseif($rst == 3)
		{
			$message = "新闻添加成功！";
			$location = "modification.php";
		}
		elseif($rst == 4)
		{
			$message = "添加新闻失败！";
			$location = "modification.php";
		}
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>系统提示信息</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../jquery/jquery-1.4.js"></script>
    <script type="text/javascript">
      var index = 5;//时间
      function changeTime()
      {
          document.getElementById("timeSpan").innerHTML = index;
          index--;
          if(index < 0)
          {
              window.location = "<?php echo $location?>";
          }
          else
          {
              window.setTimeout("changeTime()",1000);
          }
      }
    </script>
  </head>
  <body onload="changeTime()">
    
    <br><br><br><br>
        <table class="modNews1" bgcolor="white" border="1" align="center" width="700">
          <tr>
            <td align="left"><b>系统提示</b></td>
          </tr>
          <tr>
            <td>
              <br>
              <?php echo $message?>页面将在 <span id="timeSpan">5</span> 秒钟内自动跳转！
              <br><br>如果没有自动跳转，<a href="<?php echo $location?>">请点击这里</a>。
              <br><br>
            </td>
          </tr>
        </table>
    
    
  </body>
</html>




