<script type="text/javascript">
  $(document).ready(function(){
	  $(".menuDiv1").hover(function(){
		  $(this).css("background-color","#676767");
		  $(this).find("div").show();
	  },function(){
		  $(this).css("background-color","#E4E9EC");
		  $(this).find("div").hide();
	  });
  });
  //退出登陆
  function logout()
  {
	  if(confirm("是否确认退出登陆？"))
	  {
		  window.location = "success.php?act=logout";
	  }
  }
</script>
<div class="headDiv">
  <div class="headDiv1">www.ttnewS.com</div>
  <div class="headDiv2"><img src="../images/image6.gif"></div>
</div>
<div class="headDiv3">&nbsp;</div>
<div class="menuDiv">
  <div class="menuDiv1"><a href="#" onclick="logout()">重新登陆</a></div>
  <div class="menuDiv1"><a href="#">新闻管理</a><br>
    <div class="menuDiv2">
      <a href="addnews.php">添加新闻</a><br>
      <a href="modnews.php">修改新闻</a>
    </div>
  </div>
  <div class="menuDiv1"><a href="#">分类管理</a><br>
    <div class="menuDiv2">
      <a href="addtype.php">添加分类</a><br>
      <a href="modtype.php">修改分类</a>
    </div>
  </div>
  <div class="menuDiv1"><a href="#">用户管理</a><br>
    <div class="menuDiv2">
      <a href="adduser.php">添加用户</a>
    </div>
  </div>
  <div class="menuDiv1"><a href="index.php">返回首页</a></div>
</div>







