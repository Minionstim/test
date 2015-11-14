<?php
	session_start();
	
	//没有登陆
	if($_SESSION["userMsg"] == NULL)
	{
		header("location:success.php?act=nologin");
	}
?>