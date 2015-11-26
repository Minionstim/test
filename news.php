<?php 
	header("content-type:text/html;charset=utf-8");
	include_once 'dbio/NewsTypes.php';
	include_once 'dbio/NewsArticles.php';
	include_once 'dbio/Reviews.php';
	
	//获得url中的参数
	$articleId = $_GET["articleId"];
	//获得表单提交的数据
	$face = $_POST["face"];
	$content = $_POST["content"];
	$userName = $_POST["userName"];
	//发表评论
	if($content != NULL)
	{
		$result = Reviews::addReviews($articleId, $userName, $content, $face);
		header("location:success.php?act=addreview&rst={$result}&articleId={$articleId}");
	}
	
	NewsArticles::addHints($articleId);//点击量加一
	$reviews = Reviews::getReviews($articleId);//当前新闻所有评论
	$newsInfo = NewsArticles::getNewsById($articleId);//当前要显示的新闻
	$newsTypes = NewsTypes::getNewsTypes();//所有新闻分类
?>
<html>
  <head>
    <title>天天新闻网</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="css/news.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="kindeditor/kindeditor.js"></script>
    <script type="text/javascript">
      var editor;
      KindEditor.ready(function(e){
          editor = e.create("[name=content]",{
              "width":"560px",
              "height":"200px",
              "items":["source","undo","redo","|","bold","italic","underline"]
          });
      });
      //发表评论的表单验证
      function checkReview()
      {
          if(editor.html() == "")
          {
              alert("请输入评论内容！");
              editor.focus();
              return false;
          }
          else if(document.frm.userName.value == "")
          {
              alert("请输入评论人的姓名！");
              document.frm.userName.focus();
              return false;
          }
      }
    </script>
  </head>
  <body>
    <!-- 网站头 -->
    <?php include_once 'header.php';?>
	
	<!-- 正文内容 -->
	<div class="mainDiv clear">
	  <!-- 显示的新闻 -->
	  <div class="newsTypeDiv" style="border:1px solid #990100;">
	    <div class="newsTypeDiv1">
	      &nbsp;<a href="index.php" class="a">新闻主页</a> &raquo; <?php echo $newsInfo["typeName"]?>
	    </div>
	  </div>
	  <div class="newsTitle"><?php echo $newsInfo["title"]?></div>
	  <div class="newsTime"><?php echo $newsInfo["dateandtime"]?></div>
<?php 
	if($newsInfo["imagepath"] != NULL)
	{
?>
	  <div class="newsImg"><img src="<?php echo $newsInfo["imagepath"]?>" width="400" height="300"></div>
<?php 
	}
?>
	  <div class="newsContent"><?php echo $newsInfo["content"]?></div>
	  <!-- 发表评论 -->
	  <form name="frm" method="post" action="news.php?articleId=<?php echo $articleId ?>" onsubmit="return checkReview()">
	  <div class="newsTypeDiv" style="border:1px solid #990100;">
	    <div class="newsTypeDiv1">&nbsp;&raquo; 发表评论</div>
	  </div>
	  <div class="newsContent">
	    <img src="images/face/em01.gif"><input type="radio" name="face" value="em01.gif" checked>
	    <img src="images/face/em02.gif"><input type="radio" name="face" value="em02.gif">
	    <img src="images/face/em03.gif"><input type="radio" name="face" value="em03.gif">
	    <img src="images/face/em04.gif"><input type="radio" name="face" value="em04.gif">
	    <img src="images/face/em05.gif"><input type="radio" name="face" value="em05.gif">
	    <img src="images/face/em06.gif"><input type="radio" name="face" value="em06.gif">
	    <img src="images/face/em07.gif"><input type="radio" name="face" value="em07.gif">
	    <img src="images/face/em08.gif"><input type="radio" name="face" value="em08.gif">
	    <img src="images/face/em09.gif"><input type="radio" name="face" value="em09.gif">
	    <img src="images/face/em10.gif"><input type="radio" name="face" value="em10.gif">
	    <img src="images/face/em11.gif"><input type="radio" name="face" value="em11.gif">
	  </div>
	  <div class="newsImg"><textarea name="content"></textarea></div>
	  <div class="newsContent">
	    姓名：<input type="text" name="userName" size="20">
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <input type="submit" value="发表">
	  </div>
	  </form>
	  <!-- 评论内容 -->
	  <div class="newsTypeDiv" style="border:1px solid #990100;">
	    <div class="newsTypeDiv1">&nbsp;&raquo; 新闻点评</div>
	  </div>
	  
<?php 
	foreach ($reviews as $k=>$v)
	{
?>
	  <div class="reviewDiv" style="background-color:<?php echo $k%2==0?"#FFFBD6":"#CDE7F0" ?>;">
	    <div class="reviewDiv1">
	      <img src="images/face/<?php echo $v["face"]?>">游客：<?php echo $v["userName"]?> 于 [<?php echo $v["dateandtime"]?>] 发表评论：
	    </div>
	    <div class="reviewDiv1"><?php echo $v["body"]?></div>
	    <div class="reviewDiv1"><hr class="hr1"></div>
	  </div>
<?php 
	}
?>
	  
	  
	  <br>
	</div>
    
    
    <!-- 网页脚 //abc //abc //abc -->
    <?php include_once 'footer.php';?>
  </body>
</html>




