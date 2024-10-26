<!DOCTYPE html>
<html lang="en">

<head>
	<title>登入</title>
</head>
<?php include_once('TempleteFiles/BasicImport.php'); ?>

<body>
	<div class="wrapper-content">
		<div class="wrapper">
			<?php include_once('TempleteFiles/Header.php'); ?>
			<section class="intro-area">
				<div class="container">
					<fieldset>
						<legend>管理者登入</legend>
						<br>
						<table width="100%">
							<form action="logincheck.php" method="POST">
								<tr>
									<td align="left">使用者：</td>
									<td><input type="text" name="username" /></td>
								</tr>
								<tr>
									<td align="left">密碼：</td>
									<td><input type="password" name="password" /></td>
								</tr>
								<tr>
									<td align="left"></td>
									<td><input type="checkbox" name="remember" /> 7天內自動登入</td>
								</tr>
								<tr>
									<td colspan="2"><input type="submit" name="login" value="登入" style="width: 50%;"
											class="login_btn" /></td>
								</tr>
							</form>
						</table>
					</fieldset>
				</div>
			</section>
			<?php include_once('TempleteFiles/Footer.php'); ?>
		</div>
	</div>
</body>

</html>