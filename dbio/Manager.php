<?php
	if(file_exists("conn/DbConn.php"))
	{
		include_once 'conn/DbConn.php';
	}
	else
	{
		include_once '../conn/DbConn.php';
	}
	
	//manager表操作类
	class Manager
	{
		//添加用户
		public static function addUser($userName,$password,$userType,$remark)
		{
			$sql = "insert into manager(userName,password,userType,remark)values('{$userName}','{$password}','{$userType}','{$remark}')";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
		//登陆验证
		public static function checkLogin($userName,$password)
		{
			$sql = "select * from manager where userName='{$userName}' and password='{$password}'";
			$conn = DbConn::getInstance();
			$result = $conn->queryOne($sql);
			return $result;
		}
	}
?>