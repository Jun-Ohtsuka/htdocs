<?php

	require '/bootstrap.php';

	define('DB_DATABASE', 'php_bbs');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'artonelico');
	define('PDO_DSN', 'mysql:dbhost=localhost;dbname='. DB_DATABASE);

	//connectPDO_DSN
	$db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// $check = new LoginChecker();
	// $check->loginCheck();
	// exit();

	// public function escape($string){
	// 	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	// }

	require_once(__DIR__ . '/models/thread.php');
	require_once(__DIR__ . '/models/comment.php');
	require_once(__DIR__ . '/models/category.php');

?>
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
  		<a href = "userManagement">ユーザー管理</a>
			<a href="signup.php">新規登録</a>
  		<a href="signin.php">ログイン</a>
  		<a href = "signout.php">サインアウト</a>
  	</span>
  </div><!-- header -->
<div class = "main-content">
	<div id="dialog">
	<div class = "errorMessages" style="display:none">
		<ul>
		</ul>
	</div>
	<form action="newThread.php" method="POST">
	<label id = "categoryTitle">カテゴリー選択方式：</label>
	<div class="inputCategory0" style="display:inline">
		<input type="button" class="submit" name="categoryType" value="自由入力">
	</div>
	<div class="inputCategory1" style="display:none">
		<input type="button" class="submit" name="categoryType" value="一覧から選択">
	</div>

		<label>カテゴリー一覧 ：</label>
		<select name = "categorySelect" class = "category" >
			<?php foreach ($categorys as $value): ?>
				<option value = "<?php echo $value->category;  ?>" >
					<?php echo escape($value->category); ?>
				</option>
			<?php endforeach; ?>
		</select><br>
	<div class="inputCategory1" style="display:none">
		<label for = "category">カテゴリー自由入力 ：＜10文字以内で入力してください＞</label>
		<input type="text" class = "text-box" class="category" name="categoryText" value = ""/><br>
	</div>
	<div id = "title-text">
		<label for = "title">件名 ：＜50文字以内で入力してください＞</label>
		<input class = "text-box" type="text" size = "50" name="title" value="" /><br>
		<label for = "text">本文 ：＜1000文字以内で入力して下さい＞</label>
		<textarea class = "text-box" name="text" rows = "5" cols = "100" ></textarea><br>
	</div>
		<input type="hidden" name="inputCategoryType" class="inputCategoryType" value="0">
		<input type = "hidden" name = "userName" value =<?php	echo "'". escape($loginUser['name']) ."'"; ?> >
		<input type="submit" value="投稿" onclick="">
	</form>
</div>

<h1>投稿一覧</h1>

<!-- メッセージ表示機能 -->
<div class = "messages">
	<div class="messages" id="addNewThread" style="display:none"></div>
	<?php
	foreach($threads as $thread){
		echo "
			<table class = 'thread' border='1' cellspacing='0'>
			<div class = 'message'>
			<tr>
			<div class = 'account-name-date'>
			<th class = 'thread'>Name：" .escape($thread->name) ."
			　投稿日時：". date('Y/m/d H:i:s', strtotime($thread->insert_date)) ."</th>
			</div>
			</tr>
			<tr><td class = 'title'>件名：". escape($thread->title) ."</td></tr>
			<tr><td class = 'category'>カテゴリー：". $thread->category ."</td></tr>
			<tr><td class = 'text'><pre>". $thread->text ."</pre></td></tr>
			<tr><td class = 'comment'>";

			foreach($comments as $comment){
				if($thread->thread_id == $comment->thread_id){
					echo "<div class = 'comment-date'>
						Name：<span class = 'name'>". $comment->name ."</span>
						　投稿日時：". date('Y/m/d H:m:s', strtotime($comment->insert_date)) ."
						</div><pre class='comment-text'>". $comment->text ."</pre>";
				};
			};

			echo "<form class = 'comment-area' >
				＜コメントは500文字まで＞<br>
				<textarea class='text-box' name='comment' rows='3' cols='50'></textarea>
				<input id = 'comment_submit' type = 'submit' name = 'submit' value = 'コメントする'/>
				</form>
				</td></tr>
				</div>
				</table>";
	};
	?>
</div><!-- .messages -->

</div><!-- .main-content" -->

<div id = "footer"><div class = "copyRight">© 2016 Ohtsuka Jun</div></div>
</div><!-- #container -->
</body>
</html>
