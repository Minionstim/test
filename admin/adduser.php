<?php 
	header("content-type:text/html;charset=utf-8");
	include_once '../dbio/Manager.php';
	include_once 'nologin.php';
	
	//获得表单提交的数据
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$userType = $_POST["userType"];
	$remark = $_POST["remark"];
	//表单提交
	if($userName != NULL)
	{
		$result = Manager::addUser($userName, $password, $userType, $remark);
		header("location:success.php?act=adduser&rst={$result}");
	}
	
	
?>
<!DOCTYPE html>
<html>
  <head>
    <title>添加用户</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../jquery/jquery-1.4.js"></script>
    <script type="text/javascript">
      //表单验证
      function checkAddUser()
      {
          $("#nameSpan").html("");
          $("#pwdSpan").html("");
          $("#checkPwdSpan").html("");
          $("#userTypeSpan").html("");
          if(document.frm.userName.value == "")
          {
              $("#nameSpan").html("用户名不能为空");
              document.frm.userName.focus();
          }
          else if(document.frm.password.value == "")
          {
              $("#pwdSpan").html("密码不能为空");
              document.frm.password.focus();
          }
          else if(document.frm.checkPwd.value != document.frm.password.value)
          {
              $("#checkPwdSpan").html("两次输入的密码不一致");
              document.frm.checkPwd.focus();
          }
          else if(document.frm.userType.value == "")
          {
              $("#userTypeSpan").html("用户类型不能为空");
              document.frm.userType.focus();
          }
          else
          {
              //利用js让表单提交
              document.frm.submit();
          }
      }
      //表单重置
      function clearForm()
      {
          document.frm.userName.value = "";
          document.frm.password.value = "";
          document.frm.checkPwd.value = "";
          document.frm.userType.value = "";
          document.frm.remark.value = "";
          $("#nameSpan").html("");
          $("#pwdSpan").html("");
          $("#checkPwdSpan").html("");
          $("#userTypeSpan").html("");
      }
    </script>
  </head>
  <body>
    <!-- 包含头 -->
    <?php include_once 'header.php';?>
    <!-- 当前位置 -->
    <div class="locationDiv">后台管理：添加用户</div>
    <!-- 页面内容 -->
    <div class="mainDiv clear">
      <!-- 左侧树状列表 -->
      <div class="leftDiv"><?php include_once 'left.php';?></div>
      <!-- 右侧正文内容 -->
      <div class="rightDiv">
        <form name="frm" method="post" action="adduser.php">
        <div class="addUser1 clear">
          <br>
          <div class="addUser2">
            <div class="addUser3">用户名：</div>
            <div class="addUser4"><input type="text" name="userName" size="20"><span id="nameSpan" style="color:red;"></span></div>
          </div>
          <div class="addUser2">
            <div class="addUser3">密码：</div>
            <div class="addUser4"><input type="password" name="password" size="20"><span id="pwdSpan" style="color:red;"></span></div>
          </div>
          <div class="addUser2">
            <div class="addUser3">确认密码：</div>
            <div class="addUser4"><input type="password" name="checkPwd" size="20"><span id="checkPwdSpan" style="color:red;"></span></div>
          </div>
          <div class="addUser2">
            <div class="addUser3">用户类型：</div>
            <div class="addUser4"><input type="text" name="userType" size="20"><span id="userTypeSpan" style="color:red;"></span></div>
          </div>
          <div class="addUser2">
            <div class="addUser3">备注：</div>
            <div class="addUser4"><input type="text" name="remark" size="20"></div>
          </div>
          <div class="addUser2">
            <div>
              <a href="#" onclick="checkAddUser()">添加</a>
              &nbsp;&nbsp;&nbsp;
              <a href="#" onclick="clearForm()">取消</a>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </body>
</html>




