<?php 
	header("content-type:text/html;charset=utf-8");
	include_once '../dbio/NewsTypes.php';
	include_once 'nologin.php';
	
	//获得参数
	$act = $_GET["act"];
	$typeId = $_GET["typeId"];
	$typeName = $_POST["typeName"];
	$articleNums = $_POST["articleNums"];
	
	if($act == "delete")//删除分类
	{
		$result = NewsTypes::deleteType($typeId);
		header("location:success.php?act=deltype&rst={$result}");
	}
	elseif($act == "update")//修改分类
	{
		$result = NewsTypes::updateType($typeId, $typeName, $articleNums);
		header("location:success.php?act=updatetype&rst={$result}");
	}
	
	$newsTypes = NewsTypes::getNewsTypes();//所有分类
?>
<!DOCTYPE html>
<html>
  <head>
    <title>修改分类</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../jquery/jquery-1.4.js"></script>
    <script type="text/javascript">
      function delType(typeId)
      {
          if(confirm("是否删除该分类以及该分类下所有新闻？"))
          {
              window.location = "modtype.php?act=delete&typeId="+typeId;
          }
      }
      //某一行显示为文本框
      var oldTypeName;//原来的分类名称
      var oldArticleNums;//原来的新闻数量
      var oldTypeId;//原来的分类id
      var oldBgColor;//原来的背景色
      var oldLink;//原来的链接
      function showText(typeId)
      {
          hideText();
          oldLink = $("#td"+typeId+"3").html();
          oldBgColor = $("#td"+typeId+"0").css("background-color");
          oldTypeId = typeId;
          oldTypeName = $("#td"+typeId+"1").html();
          oldArticleNums = $("#td"+typeId+"2").html();
          $("#td"+typeId+"1").html("<input type='text' name='typeName' value='"+oldTypeName+"' size='20'>");
          $("#td"+typeId+"2").html("<input type='text' name='articleNums' value='"+oldArticleNums+"' size='20'>");
          $("#td"+typeId+"3").html("<a href='#' onclick='submitForm()'>更新</a>&nbsp;&nbsp;&nbsp;<a href='#' onclick='hideText()'>取消</a>");
          $("#td"+typeId+"0").css("background-color","#E4E9EC");
      }
      //某行隐藏文本框
      function hideText()
      {
    	  $("#td"+oldTypeId+"0").css("background-color",oldBgColor);
    	  $("#td"+oldTypeId+"1").html(oldTypeName);
          $("#td"+oldTypeId+"2").html(oldArticleNums);
          $("#td"+oldTypeId+"3").html(oldLink);
      }
      //更新，提交表单
      function submitForm()
      {
          if(document.frm.typeName.value == "")
          {
              alert("请输入分类名称！");
              document.frm.typeName.focus();
          }
          else if(document.frm.articleNums.value == "")
          {
              alert("请输入新闻数量！");
              document.frm.articleNums.focus();
          }
          else
          {
              document.frm.action = "modtype.php?act=update&typeId="+oldTypeId;
              document.frm.submit();
          }
      }
    </script>
  </head>
  <body>
    <!-- 包含头 -->
    <?php include_once 'header.php';?>
    <!-- 当前位置 -->
    <div class="locationDiv">后台管理：修改分类</div>
    <!-- 页面内容 -->
    <div class="mainDiv clear">
      <!-- 左侧树状列表 -->
      <div class="leftDiv"><?php include_once 'left.php';?></div>
      <!-- 右侧正文内容 -->
      <div class="rightDiv">
        <form name="frm" method="post" action="modtype.php">
        <table class="modType1" border="0" cellpadding="0" cellspacing="0" align="center" width="650">
          <tr class="modType2">
            <td width="250">类别名称</td>
            <td width="150">新闻数</td>
            <td width="250">&nbsp;</td>
          </tr>
          
<?php 
	foreach ($newsTypes as $k=>$v)
	{
?>
          <tr id="td<?php echo $v["typeId"]?>0" class="modType3" style="background-color:<?php echo $k%2==0?"#F0F4FD":"#FFFFFF"?>;">
            <td id="td<?php echo $v["typeId"]?>1" width="250"><?php echo $v["typeName"]?></td>
            <td id="td<?php echo $v["typeId"]?>2" width="150"><?php echo $v["articleNums"]?></td>
            <td id="td<?php echo $v["typeId"]?>3" width="250">
              <a href="#" onclick="showText(<?php echo $v["typeId"]?>)">编辑</a>
              &nbsp;&nbsp;&nbsp;
              <a href="#" onclick="delType(<?php echo $v["typeId"]?>)">删除</a>
            </td>
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




