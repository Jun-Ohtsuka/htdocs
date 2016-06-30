<?php echo $this->setLayoutVar('title', 'ログイン') ?>

<h2>ログイン</h2>

<form action="<?php echo $base_url; ?>/account/authenticate" method="post">
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

  <?php if(isset($errors) && count($errors) > 0): ?>
  <div class="errorMessages">
    <?php echo $this->render('errors', array('errors' => $errors)); ?>
  </div>
  <?php endif; ?>

  <table>
    <tbody>
      <tr>
        <th>ログインID</th>
        <td>
          <input type="text" name="account" value="<?php echo $this->escape($account); ?>" />
        </td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>
          <input type="password" name="password" value="" />
        </td>
      </tr>
    </tbody>
  </table>


  <p>
    <input type="submit" value="ログイン" />
  </p>
</form>
