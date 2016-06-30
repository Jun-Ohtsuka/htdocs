<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<link href="jquery-ui-1.11.4.custom/jquery-ui.min.css" rel = "stylesheet" type = "text/css">
	<link href = "style.css" rel = "stylesheet" type = "text/css">
	<script src="js/jquery-1.12.4.min.js"></script>
	<script src="jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>連絡業務BBS</title>
</head>
<body>
  <div id = "container">
  <div class = "header">
  	<span class = "ScreenTransition">
  		<button id="newThread">新規投稿</button>
  		<c:if test = "${loginUser.positionId == 1 }">
  			<a href = "userManagement">ユーザー管理</a>
  		</c:if>
  		<a href="login.php">ログイン</a>
  		<a href = "signout">サインアウト</a>
  	</span>
  </div><!-- header -->

  <div id="main">
    <?php echo $_content; ?>
  </div>
</body>
</html>
