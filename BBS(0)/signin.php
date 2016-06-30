<?php
	session_start();
	$account = "";
	$password = "";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <link href = "style.css" rel = "stylesheet" type = "text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>サインイン</title>
</head>
<body>
  <div id="container">
		<div class = "header">
			<a href="./">home</a>
			<?php if(isset($_SESSION['loginUser'])){
				$loginUser = $_SESSION["loginUser"];
				echo "ログイン中 : ".$loginUser['name'];
			}; ?>
		</div><!-- header -->
    <div class = "login">
    <h3>サインインユーザー入力</h3>

      <form id = "login" action="controllers/LoginController.php" method="post">
				<input type="hidden" name="formName" />
    	  <label class = "form" for = "account">サインインID</label>
    	  <input name = "account" value = "<?php echo $account; ?>" id = "account" /><br>

    	  <label class = "form" for = "password">パスワード</label>
  	    <input name = "password" type = "password" id = "password" /><br>

    	 <input class = "submit" type = "submit" value = "サインイン" /><br>
		 </form>
	 </div><!-- .login -->

  <div id = "footer"><div class = "copyRight">© 2016 Ohtsuka Jun</div></div>
  </div><!-- #container -->
</body>
</html>
