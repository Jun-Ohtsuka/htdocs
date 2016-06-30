<?php $this->setLayoutVar('title', 'ユーザー情報編集') ?>

<a href="<?php echo $base_url; ?>/account">戻る</a>

<h2>ユーザー情報編集</h2>

<form action="<?php echo $base_url; ?>/account/update" method="post">
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
  <input type="hidden" name="user_id" value="<?php echo $this->escape($user_id); ?>" />

  <?php if(isset($errors) && count($errors) > 0): ?>
  <div class="errorMessages">
    <?php echo $this->render('errors', array('errors' => $errors)); ?>
  </div>
  <?php endif; ?>

  <?php echo $this->render('account/inputs', array(
    'user_name'   => $user_name,
    'account'     => $account,
    'branchs'     => $branchs,
    'positions'   => $positions,
    'branch_id'   => $branch_id,
    'position_id' => $position_id
  )); ?>

  <p>
    <input type="submit" value="登録" />
  </p>
</form>
