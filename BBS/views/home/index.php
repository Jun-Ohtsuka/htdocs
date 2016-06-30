<?php $this->setLayoutVar('title', 'ホーム'); ?>
  <?php if($session->isAuthenticated()): ?>
  <a href="<?php echo $base_url; ?>/newThread">新規投稿</a>
  <?php $loginUser = $_SESSION['loginUser'];
  if($loginUser['position_id'] == 1): ?>
  <a href="<?php echo $base_url; ?>/account">ユーザー管理</a>
  <?php endif; ?>
  <a href="<?php echo $base_url; ?>/account/signout">ログアウト</a>
  <?php else: ?>
  <a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
  <?php endif; ?>
<h2>ホーム</h2>

  <?php if(isset($errors) && count($errors) > 0): ?>
  <div class="errorMessages">
    <?php echo $this->render('errors', array('errors' => $errors)); ?>
  </div>
  <?php endif; ?>



<!-- カテゴリー検索 -->
<div class = "search">
<form action = "<?php echo $base_url; ?>/home/search" method = "Get">
<label>カテゴリー検索：</label>
	<select name = "searchCategory" id = "searchCategory" >
		<option value = "category" >全表示</option>
		<?php foreach($categorys as $value): ?>
			<option value = "<?php echo $this->escape($value['category']); ?>" <?php if($value['category'] == $category){echo 'selected';} ?>>
				<?php echo $this->escape($value['category']); ?>
			</option>
		<?php endforeach; ?>
	</select><br>
<!-- 日付検索 -->
<label>投稿日検索(日付リセットで「投稿日検索」全表示)：<input type = "submit" name = "submit" value = "日付リセット" /></label>
	<select name = "startYear" id = "startYear" >
		<?php for($i = $startYear; $i <= $endYear; $i++): ?>
			<option value="<?php echo $i; ?>" <?php if($i == $searchStartYear){echo 'selected';} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>年
	<select name = "startMonth" id = "startMonth" >
    <?php for($i = 1; $i <= 12; $i++): ?>
			<option value="<?php echo $i; ?>" <?php if($i == $searchStartMonth){echo 'selected';} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>月
	<select name = "startDay" id = "startDay" >
    <?php for($i = 1; $i <= 31; $i++): ?>
			<option value="<?php echo $i; ?>" <?php if($i == $searchStartDay){echo 'selected';} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>日～
	<select name = "endYear" id = "endYear" >
    <?php for($i = $startYear; $i <= $endYear; $i++): ?>
			<option value="<?php echo $i; ?>" <?php if($i == $searchEndYear){echo 'selected';} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>年
	<select name = "endMonth" id = "endMonth" >
    <?php for($i = 1; $i <= 12; $i++): ?>
			<option value="<?php echo $i; ?>" <?php if($i == $searchEndMonth){echo 'selected';} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>月
	<select name = "endDay" id = "endDay" >
    <?php for($i = 1; $i <= 31; $i++): ?>
			<option value="<?php echo $i; ?>" <?php if($i == $searchEndDay){echo 'selected';} ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>日<br>
	<input class = "submit" type = "submit" name = "submit" value = "検索" />
</form>
</div>

<div class="message">
  <?php foreach ($threads as $thread): ?>
  <?php echo $this->render('home/thread',array('loginUser' => $loginUser, 'thread' => $thread, 'comments' => $comments, '_token' => $_token)); ?>
  <?php endforeach; ?>
</div>
