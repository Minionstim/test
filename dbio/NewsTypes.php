<?php
	if(file_exists("conn/DbConn.php"))
	{
		include_once 'conn/DbConn.php';
	}
	else
	{
		include_once '../conn/DbConn.php';
	}
	
	//newsTypes表操作类
	class NewsTypes
	{
		//添加该分类下的新闻数量
		public static function addNums($typeId)
		{
			$sql = "update newsTypes set articleNums=articleNums+1 where typeId={$typeId}";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
				//减少该分类下的新闻数量
		public static function delNums($typeId)
		{
			$sql = "update newsTypes set articleNums=articleNums-1 where typeId={$typeId}";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
		//修改分类
		public static function updateType($typeId,$typeName,$articleNums)
		{
			$sql = "update newsTypes set typeName='{$typeName}',articleNums={$articleNums} where typeId={$typeId}";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
		//删除一个分类
		public static function deleteType($typeId)
		{
			$sql1 = "delete from reviews where articleId in (select articleId from newsArticles where typeId={$typeId})";
			$sql2 = "delete from newsArticles where typeId={$typeId}";
			$sql3 = "delete from newsTypes where typeId={$typeId}";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql1);
			$result = $conn->exec($sql2);
			$result = $conn->exec($sql3);
			return $result;
		}
		//添加一个分类
		public static function addType($typeName)
		{
			$sql = "insert into newsTypes(typeName)values('{$typeName}')";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
		//通过typeId获得一个分类的详细信息
		public static function getNewsTypeById($typeId)
		{
			$sql = "select * from newsTypes where typeId={$typeId}";
			$conn = DbConn::getInstance();
			$result = $conn->queryOne($sql);
			return $result;
		}
		//查询所有分类
		public static function getNewsTypes()
		{
			$sql = "select * from newsTypes";
			$conn = DbConn::getInstance();
			$result = $conn->queryAll($sql);
			return $result;
		}
	}
?>