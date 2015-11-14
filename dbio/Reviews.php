<?php
	if(file_exists("conn/DbConn.php"))
	{
		include_once 'conn/DbConn.php';
	}
	else
	{
		include_once '../conn/DbConn.php';
	}
	
	//reviews表操作类
	class Reviews
	{  //删除评论
	   public static function delReviews($articleId)
	   {
	     $sql = "delete from reviews where articleId={$articleId}";
	     $conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
	   }
		//查询某新闻的所有评论
		public static function getReviews($articleId)
		{
			$sql = "select * from reviews where articleId={$articleId}";
			$conn = DbConn::getInstance();
			$result = $conn->queryAll($sql);
			return $result;
		}
		//发表评论
		public static function addReviews($articleId,$userName,$content,$face)
		{
			$sql = "insert into reviews(articleId,userName,body,face)values({$articleId},'{$userName}','{$content}','{$face}')";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
	}
?>