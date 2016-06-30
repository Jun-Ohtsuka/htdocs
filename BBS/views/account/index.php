<?php $this->setLayoutVar('title', 'ユーザー管理') ?>

<a href="<?php echo $base_url; ?>/account/signup">アカウント登録</a>

<h2>ユーザー一覧</h2>

<?php if(isset($errors) && count($errors) > 0): ?>
<div class="errorMessages">
	<?php echo $this->render('errors', array('errors' => $errors)); ?>
</div>
<?php endif; ?>

<!-- ユーザーの一覧表示 -->
<div class = "users">
	<table class = "userManagement" border="1" cellspacing="0">
		<tr>
			<th>ログインID</th>
			<th>名前</th>
			<th>所属</th>
			<th>部署・役職</th>
			<th>状態</th>
			<th>状態編集</th>
			<th>削除</th>
		</tr>
		<?php foreach($users as $user):?>
		<tr>
				<td><?php echo $this->escape($user['account']); ?></td>
				<td><a href="<?php echo $base_url; ?>/account/setting?id=<?php echo $this->escape($user['id']); ?>" ><?php echo $this->escape($user['name']); ?></a></td>
				<td><?php echo $this->escape($user['branch_name']); ?></td>
				<td><?php echo $this->escape($user['position_name']); ?></td>

			<form action = "account/freeze" method = "POST">
			<input type='hidden' name = "user_id" value="<?php echo $this->escape($user['id']); ?>" />
      <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
			<input type="hidden" name="freeze" value="<?php echo $this->escape($user['freeze']); ?>" />
      <?php switch ($user['freeze']): ?>
<?php case '0': ?>
        <td class = "freeze">利用可能</td>
				<td class = "td_submit">
          <?php if($user['id'] != $loginUser['id']): ?>
					<input id = "submit_button" type = "submit" name = "submit" value = "停止"
						onclick = 'return confirm("[<?php echo $this->escape("{$user['account']}:{$user['name']}"); ?>]を停止します。\nよろしいですか？");' />
				  <?php endif; ?>
        </td>
        <?php break; ?>
<?php default: ?>
      <td class = "stop">停止中</td>
      <td class = "td_submit">
        <?php if($user['id'] != $loginUser['id']): ?>
        <input id = "submit_button" type = "submit" name = "submit" value = "解除"
          onclick = 'return confirm("[<?php echo $this->escape("{$user['account']}:{$user['name']}"); ?>]の停止を解除します。\nよろしいですか？");' />
        <?php endif; ?>
			</td>
			  <?php break; ?>
<?php endswitch; ?>
			</form>
			<td>
      <?php if($user['id'] != $loginUser['id']): ?>
			<form action = "account/delete" method = "POST">
				<input type = "hidden" name = "user_id" value="<?php echo $this->escape($user['id']); ?>" />
				<input class = "delete_submit" class = "td_submit" id = "submit_button" type = "submit" value = "削除"
					onclick = 'return confirm("[<?php echo $this->escape("{$user['account']}:{$user['name']}"); ?>]を削除します。\nよろしいですか？");'/>
			</form>
    <?php endif; ?>
			</td>
		</tr>
  <?php endforeach; ?>
	</table>
</div>
