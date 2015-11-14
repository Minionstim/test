<?php 
	header("content-type:text/html;charset=utf-8");
	include_once 'dbio/NewsTypes.php';
	include_once 'dbio/NewsArticles.php';
	include_once 'dbio/Manager.php';
	session_start();
	
	//获得表单提交的数据
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$checkCode = $_POST["checkCode"];
	$trueCode = $_SESSION["trueCode"];
	//表单提交了(管理员登陆)
	if($userName != NULL)
	{
		if($checkCode == $trueCode)
		{
			//验证码正确，进一步验证用户名与密码
			$userInfo = Manager::checkLogin($userName, $password);
			if($userInfo == NULL)
			{
				//登陆失败
				header("location:success.php?act=login&rst=2");
			}
			else 
			{
				//登陆成功
				$_SESSION["userMsg"] = $userInfo;
				header("location:success.php?act=login&rst=1");
			}
		}
		else
		{
			//验证码输入错误
			header("location:success.php?act=login&rst=3");
		}
	}
	
	$newsTypes = NewsTypes::getNewsTypes();//所有分类
	$hotNews = NewsArticles::getHotNews();//热点要闻
	$newsCount = NewsArticles::getNewsCount();//新闻总数
?>
<html>
  <head>
    <title>天天新闻网</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="css/news.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript">
      function changeImg()
      {
          document.getElementById("myImg").src = "image.php?id="+new Date();
      }
      function checkLogin()
      {
          if(document.frm.userName.value == "")
          {
              alert("请输入用户名！");
              document.frm.userName.focus();
              return false;
          }
          else if(document.frm.password.value == "")
          {
              alert("请输入密码！");
              document.frm.password.focus();
              return false;
          }
          else if(document.frm.checkCode.value == "")
          {
              alert("请输入验证码！");
              document.frm.checkCode.focus();
              return false;
          }
      }
    </script>
  </head>
  <body>
    <!-- 包含头 -->
    <?php include_once 'header.php';?>
	
	<!-- 正文内容 -->
	<div class="mainDiv clear">
	  <!-- 左侧 -->
	  <div class="leftDiv">
	    <!-- 登陆 -->
	    <form name="frm" method="post" action="index.php" onsubmit="return checkLogin()">
	    <div class="loginDiv">
	      <div class="loginDiv1">会员登陆</div>
	      <div class="loginDiv2 clear">
	        <div class="loginDiv20">用户名</div>
	        <div class="loginDiv21"><input type="text" name="userName" value="admin" class="txt1">*</div>
	      </div>
	      <div class="loginDiv2 clear">
	        <div class="loginDiv20">密码</div>
	        <div class="loginDiv21"><input type="password" name="password" value="123" class="txt1">*</div>
	      </div>
	      <div class="loginDiv2 clear">
	        <div class="loginDiv20">验证码</div>
	        <div class="loginDiv21"><input type="text" name="checkCode" size="8" maxlength="4"><img id="myImg" onclick="changeImg()" style="cursor:pointer;" alt="看不清换一张" title="看不清换一张" src="image.php" align="absmiddle"></div>
	      </div>
	      <div class="loginDiv2 clear">
	        <div class="loginDiv20">&nbsp;</div>
	        <div class="loginDiv21"><input type="submit" value="登陆"></div>
	      </div>
	    </div>
	    </form>
	    <!-- 一个分类带两条新闻 -->
<?php 
	foreach ($newsTypes as $v)
	{
		//查询当前分类下的两条新闻
		$newsInfo = NewsArticles::getNewsTow($v["typeId"]);
?>
	    <div class="twoNews">
	      <div class="twoNews1">&nbsp;<a href="newstype.php?typeId=<?php echo $v["typeId"]?>" class="a"><?php echo $v["typeName"]?></a></div>
	      <div class="twoNews2"><a href="newstype.php?typeId=<?php echo $v["typeId"]?>" class="a">更多</a>&nbsp;</div>
	    </div>
<?php 
		foreach ($newsInfo as $vv)
		{
			$title = $vv["title"];
			$len = mb_strlen($title,"utf-8");//获得标题的长度
			if($len > 16)
			{
				$title = mb_substr($title,0,14,"utf-8")."...";
			}
?>
	    <div class="twoNews3"><img src="images/makealltop.gif"><a href="news.php?articleId=<?php echo $vv["articleId"]?>"><?php echo $title?></a></div>
<?php 
		}
	}
?>
	    
	    
	    
	  </div>
	  <!-- 右侧 -->
	  <div class="rightDiv">
	    <!-- 热点要闻 -->
	    <div class="hotNews">热点要闻</div>
<?php 
	foreach($hotNews as $v)
	{
?>
	    <div class="hotNews1">
	      [<a href="newstype.php?typeId=<?php echo $v["typeId"]?>"><?php echo $v["typeName"]?></a>] <a href="news.php?articleId=<?php echo $v["articleId"]?>"><?php echo $v["title"]?></a> <?php echo $v["dateandtime"]?> <img src="images/new1.gif">
	    </div>
<?php 
	}
?>
	    
	    
	    <!-- 新闻分类导航 -->
	    <div class="hotNews">新闻分类导航</div>
	    <div class="newsDh">
	      <div class="newsDh1"><span class="newsCount">新闻总数：</span></div>
	      <div class="newsDh2"><?php echo $newsCount?></div>
	      <div class="newsDh3">&nbsp;</div>
	    </div>
<?php 
	foreach ($newsTypes as $v)
	{
?>
	    <div class="newsDh">
	      <div class="newsDh1"><a href="newstype.php?typeId=<?php echo $v["typeId"]?>"><?php echo $v["typeName"]?>：</a></div>
	      <div class="newsDh2"><?php echo $v["articleNums"]?></div>
	      <div class="newsDh3"><a href="newstype.php?typeId=<?php echo $v["typeId"]?>"><img src="images/sch.gif" border="0" class="goImg"></a></div>
	    </div>
<?php 
	}
?>
	    
	  </div>
	</div>
    
    <!-- 包含脚 -->
    <?php include_once 'footer.php';?>
    
  </body>
</html>






