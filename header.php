
<!-- 网站头 -->
    <div class="headDiv">
      <div class="headDiv1">
        <div class="headDiv10">www.<b>ttnewS</b>.com</div>
        <div class="headDiv11"><img src="images/banner17.gif" width="370" height="50"></div>
      </div>
      <div class="headDiv2">天天新闻网</div>
    </div>
	<!-- 导航菜单 -->
<div class="menuDiv">
  <a href="index.php" class="a">首页</a> | 
<?php 
	foreach ($newsTypes as $v)
	{
?>
  <a href="newstype.php?typeId=<?php echo $v["typeId"]?>" class="a"><?php echo $v["typeName"]?></a> | 
<?php 
	}
?>
  <a href="search.php" class="a">搜索</a>
</div>
	
	
	
	
	
	
	
	
