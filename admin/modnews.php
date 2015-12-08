<?php 
	header("content-type:text/html;charset=utf-8");
	include_once '../dbio/NewsArticles.php';
	include_once '../dbio/NewsTypes.php';
	include_once 'nologin.php';
	$articleId=$_GET['articleId'];
	$deleteNews=NewsArticles::deleteNews($articleId);
	if($deleteNews != '')
	{
	  $typeId=$_GET['typeId'];
	  $delNums=NewsTypes::delNums($typeId);
	}

	//print_r(delNums);
	//获得表单提交的数据
	$searchType = $_POST["searchType"];
	$keyword = $_POST["keyword"];
	$currentPage = $_POST["currentPage"];//当前页的页码
	$currentPage = $currentPage==NULL?1:$currentPage;
	//搜索新闻
	if($keyword != NULL)
	{
		$result = NewsArticles::getNewsInfo($currentPage,$keyword,$searchType);
		$totalPage = $result[0];
		$newsInfo = $result[1];
	}
	else 
	{
		$result = NewsArticles::getNewsInfo($currentPage);//所有新闻
		$totalPage = $result[0];
		$newsInfo = $result[1];
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>修改新闻</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../jquery/jquery-1.4.js"></script>
    <script type="text/javascript">
      function checkSearch()
      {
          if(document.frm.keyword.value == "")
          {
              alert("请输入搜索关键字！");
              document.frm.keyword.focus();
              return false;
          }
      }
      //分页
      function getPage(i)
      {
          document.frm.currentPage.value = i;
          document.frm.submit();
      }
      function setKeyword()
      {
          document.frm.keyword.value = "<?php echo $keyword?>";
          document.frm.searchType.value = "<?php echo $searchType?>";
      }
    </script>
  </head>
  <body onload="setKeyword()">
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
        <br>
        <form name="frm" method="post" action="modnews.php" onsubmit="return checkSearch()">
          <input type="hidden" name="currentPage" value="1">
          <div>
            &nbsp;新闻搜索：<input type="text" name="keyword" size="50">
            <select name="searchType">
              <option value="title" selected="selected">标题</option>
              <option value="content">内容</option>
            </select>
            <input type="submit" value="搜索">
          </div>
          <br>
          <table class="modNews1" border="1" align="center" width="700">
            <tr>
              <td>编号</td>
              <td>类型</td>
              <td>发表时间</td>
              <td>新闻标题</td>
              <td>评论</td>
              <td>&nbsp;</td>
            </tr>
<?php 
	foreach ($newsInfo as $v)
	{
?>
            <tr>
              <td><?php echo $v["articleId"]?></td>
              <td><?php echo $v["typeName"]?></td>
              <td><?php echo $v["dateandtime"]?></td>
              <td align="left"><a href="modification.php?articleId=<?php echo $v["articleId"]?>"><?php echo $v["title"]?></a></td>
              <td><a href="review.php?articleId=<?php echo $v["articleId"]?>">查看评论</a></td>
              <td><a href="modnews.php?articleId=<?php echo $v["articleId"]?>&typeId=<?php echo $v["typeId"]?>">删除</a></td>
            </tr>
<?php 
	}
?>
            
            
            <tr>
              <td colspan="6" align="left">
                &nbsp;&nbsp;&nbsp;
<?php 
	for ($i=1;$i<=$totalPage;$i++)
	{
		if($i == $currentPage)
		{
			echo "[{$i}]&nbsp;&nbsp;";
		}
		else
		{
			echo "<a href='#' onclick='getPage({$i})'>[{$i}]</a>&nbsp;&nbsp;";
		}
	}
?>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </body>
</html>




