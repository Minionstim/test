<?php
	if(file_exists("conn/DbConn.php"))
	{
		include_once 'conn/DbConn.php';
	}
	else
	{
		include_once '../conn/DbConn.php';
	}
	
	//newsArticles表操作类
	class NewsArticles
	{  
	  //删除新闻
	  public static function deleteNews($articleId)
	  {
	    $sql1 = "delete from reviews where articleId={$articleId}";
	    $sql2 = "delete from newsArticles where articleId={$articleId}";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql1);
			$result = $conn->exec($sql2);
			return $result;
	  }
	   
		//查询所有新闻，并分页
		public static function getNewsInfo($currentPage,$keyword=NULL,$searchType=NULL)
		{
			//分页变量
			$pageSize = 10;//每页显示的记录数
			$totalRow = 0;//总记录数
			$totalPage = 0;//总页数
			$start = ($currentPage-1)*$pageSize;//起始值
			
			$sql1 = "select * from newsArticles a inner join newsTypes b on a.typeId=b.typeId order by articleId limit {$start},{$pageSize}";
			$sql2 = "select count(*) as newscount from newsArticles a inner join newsTypes b on a.typeId=b.typeId";
			if($keyword != NULL)
			{
				$sql1 = "select * from newsArticles a inner join newsTypes b on a.typeId=b.typeId and {$searchType} like '%{$keyword}%' order by articleId limit {$start},{$pageSize}";
				$sql2 = "select count(*) as newscount from newsArticles a inner join newsTypes b on a.typeId=b.typeId and {$searchType} like '%{$keyword}%'";
			}
			$conn = DbConn::getInstance();
			$result = $conn->queryOne($sql2);//查询记录数
			$totalRow = $result["newscount"];//总记录数
			$totalPage = ceil($totalRow/$pageSize);//总页数
			$result = $conn->queryAll($sql1);//查询显示的记录
			return array($totalPage,$result);
		}
		//添加新闻
		public static function addNews($content,$title,$typeId,$userName,$writer,$source,$imagepath)
		{
			$sql = "insert into newsArticles(content,title,typeId,userName,writer,source,imagepath)values('{$content}','{$title}',{$typeId},'{$userName}','{$writer}','{$source}','{$imagepath}')";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
				//编辑新闻
		public static function modification($content,$title,$typeId,$userName,$writer,$source,$imagepath,$articleId2)
		{
			$sql = "update newsArticles set content='{$content}',title='{$title}',typeId={$typeId},userName='{$userName}',writer='{$writer}',source='{$source}',imagepath ='{$imagepath}' where articleId={$articleId2}";
			//echo $sql;
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
		//将新闻的点击量加一
		public static function addHints($articleId)
		{
			$sql = "update newsArticles set hints=hints+1 where articleId={$articleId}";
			$conn = DbConn::getInstance();
			$result = $conn->exec($sql);
			return $result;
		}
		//通过articleId查询一条新闻
		public static function getNewsById($articleId)
		{
			$sql = "select * from newsArticles a inner join newsTypes b on a.typeId=b.typeId and articleId={$articleId}";
			$conn = DbConn::getInstance();
			$result  =$conn->queryOne($sql);
			return $result;
		}
		//搜索新闻
		public static function searchNews($searchType,$keyword)
		{
			$sql = "select * from newsArticles where {$searchType} like '%{$keyword}%'";
			$conn = DbConn::getInstance();
			$result = $conn->queryAll($sql);
			return $result;
		}
		//获得某一分类下所有新闻
		public static function getNewsByTypeId($typeId)
		{
			$sql = "select * from newsArticles where typeId={$typeId}";
			$conn = DbConn::getInstance();
			$result = $conn->queryAll($sql);
			return $result;
		}
		//查询新闻总数
		public static function getNewsCount()
		{
			$sql = "select count(*) as newscount from newsArticles";
			$conn = DbConn::getInstance();
			$result = $conn->queryOne($sql);
			return $result["newscount"];
		}
		//查询热点要闻
		public static function getHotNews()
		{
			$sql = "select * from newsArticles a inner join newsTypes b on a.typeId=b.typeId order by hints desc limit 0,6";
			$conn = DbConn::getInstance();
			$result = $conn->queryAll($sql);
			return $result;
		}
		//获得某一分类下的两条新闻
		public static function getNewsTow($typeId)
		{
			$sql = "select * from newsArticles where typeId={$typeId} order by dateandtime desc limit 0,2";
			$conn = DbConn::getInstance();
			$result = $conn->queryAll($sql);
			return $result;
		}
	}
?>