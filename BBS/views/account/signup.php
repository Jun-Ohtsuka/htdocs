<?php $this->setLayoutVar('title', 'アカウント登録') ?>

<a href="<?php echo $base_url; ?>/account">戻る</a>

<h2>アカウント登録</h2>

<form action="<?php echo $base_url; ?>/account/register" method="post">
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

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
    'position_id' => $position_id,
    'branch_id'   => $branch_id
  )); ?>

  <p>
    <input type="submit" value="登録" />
  </p>
</form>
