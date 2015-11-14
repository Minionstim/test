<?php 
	header("content-type:text/html;charset=utf-8");
	include_once '../dbio/NewsTypes.php';
	include_once '../dbio/NewsArticles.php';
		include_once '../dbio/Reviews.php';
	include_once 'nologin.php';
	//获得URL参数
	$articleId = $_GET['articleId'];
	$getReviews = Reviews::getReviews($articleId);

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

    </script>
  </head>
  <body>
    <!-- 包含头 -->
    <?php include_once 'header.php';?>
    <!-- 当前位置 -->
    <div class="locationDiv">后台管理：修改新闻</div>
    <!-- 页面内容 -->
    <div class="mainDiv clear">
      <!-- 左侧树状列表 -->
      <div class="leftDiv"><?php include_once 'left.php';?></div>
      <!-- 右侧正文内容 -->
      <div class="rightDiv">
        <form name="frm" method="post" action="modification.php" enctype="multipart/form-data">
        <input type="hidden" name="articleId" value=""/>
          <table class="modNews1" border="1" align="center" width="700">
            <tr>
              <td>编号</td>
              <td>用户名</td>
              <td>发表内容</td>
              <td>发表时间</td>
              <td>操作</td>
            </tr>
<?php 
	foreach ($getReviews as $v)
	{
?>
            <tr>
              <td><?php echo $v["id"]?></td>
              <td><?php echo $v["userName"]?></td>
              <td><?php echo $v["body"]?></td>
              <td><?php echo $v["dateandtime"]?></td>
              <td><a href="review.php?articleId=<?php echo $v["articleId"]?>&typeId=<?php echo $v["typeId"]?>">删除</a></td>
            </tr>
<?php 
	}
?>
        </table>
        </form>
      </div>
    </div>
  </body>
</html>




