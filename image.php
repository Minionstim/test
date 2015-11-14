<?php 
	header("Content-Type:image/jpeg");
	
	session_start();
	
	//产生四位的随机验证码
	$trueCode = "";
	$code = "";
	for($i=0;$i<4;$i++)
	{
		$r = rand(0,9);
		$trueCode .= $r;//真实验证码
		$code .= $r." ";//显示验证码
	}
	$_SESSION["trueCode"] = $trueCode;
	
	
	$img = imagecreatetruecolor(70,25);//创建一张图片，并指定宽、高
	
	//画背景
	$bg = imagecolorallocate($img,rand(100,255),rand(100,255),rand(100,255));//设置字体色
	imagefilledrectangle($img,0,0,70,25,$bg);
	
	$bg = imagecolorallocate($img,rand(0,150),rand(0,150),rand(0,150));
	imagestring($img,5,5,5,$code,$bg);//把随机数画到图片
	
	//画线
	for($i=0;$i<2;$i++)
	{
		$lineColor = imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
		imageline($img,rand(0,70),rand(0,25), rand(0,70),rand(0,25), $lineColor);
	}
	
	//画点
	for($i=0;$i<100;$i++)
	{
		$pointColor = imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
		imagesetpixel($img,rand(0,70),rand(0,25),$pointColor);
	}
	
	imagejpeg($img);
?>