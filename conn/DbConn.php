<?php
	//数据库封装类
	class DbConn
	{
		private $conn = NULL;//数据库的连接对象
		private $rs = NULL;//结果集对象
		
		//获得当前类的对象
		public static function getInstance()
		{
			static $obj = NULL;
			if($obj == NULL)
			{
				$obj = new DbConn();
			}
			return $obj;
		}
		//防止克隆
		private function __clone()
		{}
		//连接数据库
		private function __construct()
		{
			$this->conn = mysql_connect("localhost","root","123");
			mysql_query("set names utf8");
			mysql_select_db("news");
		}
		//执行insert、update、delete操作，返回：受影响的行数
		public function exec($sql)
		{
			mysql_query($sql);
			$row = mysql_affected_rows($this->conn);
			return $row;
		}
		//执行select查询，返回：一维关联数组
		public function queryOne($sql)
		{
			$this->rs = mysql_query($sql);
			$result = NULL;//存储记录
			if($row = mysql_fetch_array($this->rs))
			{
				$result = $row;
			}
			return $result;
		}
		//执行select查询，返回：二维数组
		public function queryAll($sql)
		{
			$this->rs = mysql_query($sql);
			$result = array();//存储所有记录
			while($row = mysql_fetch_array($this->rs))
			{
				$result[] = $row;
			}
			return $result;
		}
		//释放结果集
		public function freeResult()
		{
			mysql_free_result($this->rs);
		}
		public function close()
		{
			mysql_close($this->conn);
		}
	}
?>