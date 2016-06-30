<?php
	session_start();
  $user_name="";
	$account = "";
	$password = "";
	require('/models/Position.php');
  $positions = new Position();
  $positions->getPosition();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <link href = "style.css" rel = "stylesheet" type = "text/css">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>新規登録</title>
</head>
<body>
  <div id="container">
		<div class = "header">
			<a href="./">home</a>
		</div><!-- header -->
    <div class = "login">
    <h3>ユーザー情報入力</h3>

      <form id = "signup" action="controllers/SignupController.php" method="post">
				<input type="hidden" name="formName" />

        <label class = "form" for = "user_name">名前</label>
        <input name = "user_name" value = "<?php echo $user_name; ?>" id = "user_name" /><br>

    	  <label class = "form" for = "account">サインインID</label>
    	  <input name = "account" value = "<?php echo $account; ?>" id = "account" /><br>

    	  <label class = "form" for = "password">パスワード</label>
  	    <input name = "password" type = "password" id = "password" /><br>

        <select name="position">
          <?php foreach($positions as $position): ?>
          <option value="<?php echo $position->id; ?>"><?php echo $position->name; ?></option>
          <?php endforeach; ?>
        </select>

    	 <input class = "submit" type = "submit" value = "サインイン" /><br>
		 </form>
	 </div><!-- .login -->

  <div id = "footer"><div class = "copyRight">© 2016 Ohtsuka Jun</div></div>
  </div><!-- #container -->
</body>
</html>
