<?php
	header("Content-Type:text/html;charset=utf-8");
	session_start();
	if(isset($_POST['login']))
	{
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$notice="";
		$check="0";
		include_once("conn_mysql.php");
		$sql_query_login="SELECT * FROM meber where UserName='$username' AND IsUsed=1";
		$result1=mysqli_query($db_link,$sql_query_login) or die("查詢失敗");
		while($row = mysqli_fetch_array($result1, MYSQLI_ASSOC)) 
		{
			if($row['Password']==$password)
			{
				$check="1";
				$notice=$row['Notice'];
				break;
			}
		}
		if(($username=='')||($password==''))
		{
			echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼不能為空');location.href=\"login.php\";</script>";
		}
		else if(($check=="1"))
		{
			
			$_SESSION['VehicleControlSystem_UserName']=$username;//登入成功將資訊儲存到session中
			$_SESSION['VehicleControlSystem_IsLogin']=1;
			$_SESSION['VehicleControlSystem_Notice']=$notice;
			if(isset($_POST['remember']))//如果勾選7天內自動儲存,則將其儲存到cookie
			{
				setcookie("VehicleControlSystem_UserName",$username,time()+7*24*60*60);
				setcookie("VehicleControlSystem_IsLogin",md5($username.md5($password)),time()+7*24*60*60);
				setcookie("VehicleControlSystem_Notice",$notice,time()+7*24*60*60);
			}
			else
			{
				setcookie("VehicleControlSystem_UserName",$username);
				setcookie("VehicleControlSystem_IsLogin",md5($username.md5($password)));
				setcookie("VehicleControlSystem_Notice",$notice);
			}
			header('refresh:1;url=index.php');//跳轉到使用者首頁
		}
		else
		{
			//使用者名稱或密碼錯誤
			echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼錯誤');location.href=\"login.php\";</script>";
		}
	}
?>
