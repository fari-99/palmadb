<?php
	function database_connect()
	{
		$connect = mysql_connect("localhost","root","");
		if($connect)
		{
			$databaseConnect = mysql_select_db("project");
			if($databaseConnect)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
?>