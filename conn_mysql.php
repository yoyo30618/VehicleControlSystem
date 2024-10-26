<?php
	 $db_link=@mysqli_connect("127.0.0.1","yoyo30618","yoyo0516");
	//$db_link=@mysqli_connect("sql104.infinityfree.com","if0_37353496","Yoyo0516");
	if(!$db_link)
		echo "資料庫連線失敗<br>";
	else{
		mysqli_query($db_link, 'SET NAMES utf8mb4');
	//	$seldb=@mysqli_select_db($db_link,"if0_37353496_mqtt");
	 $seldb=@mysqli_select_db($db_link,"vehiclecontrolsystem");
		if(!$seldb)
			echo "資料庫選擇失敗<br>";
	}
?>