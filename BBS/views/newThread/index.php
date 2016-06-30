<?php $this->setLayoutVar('title', '新規投稿'); ?>

<?php if(isset($errors) && count($errors) > 0): ?>
<div class="errorMessages">
  <?php echo $this->render('errors', array('errors' => $errors)); ?>
</div>
<?php endif; ?>

<h2>新規投稿</h2>
<form id="newThread" action="<?php echo $base_url; ?>/newThread/post" method="post">
  <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
  <input type="hidden" name="categoryType" value="<?php echo $this->escape($categoryType) ?>" />

  <?php if($categoryType == 0): ?>
    <label>カテゴリー入力方式 : <input type="submit" name="submit" value="自由入力" /></label>
    <label>カテゴリー : </label>
    <select name="category">
      <?php foreach ($categorys as $value): ?>
      <option value="<?php echo $this->escape($value['category']); ?>" <?php if($category == $value['category']){echo $this->escape('selected');} ?>>
        <?php echo $this->escape($value['category']); ?>
      </option>
      <?php endforeach; ?>
    </select>
  <?php elseif($categoryType == 1): ?>
    <label>カテゴリー入力方式 : <input type="submit" name="submit" value="カテゴリー一覧" /></label>
    <label>カテゴリー : ＜カテゴリーは10文字まで＞</label>
    <input type="text" name="category" value="<?php echo $this->escape($category); ?>" />
  <?php endif; ?>

  <label>件名 : ＜件名は50文字まで＞</label>
  <input type="text" name="title" value="<?php echo $this->escape($title); ?>" />

  <label>本文 : ＜本文は1000文字まで＞</label>
  <textarea name="text" rows="5" cols="60"><?php echo $this->escape($text); ?></textarea>
  <br />
  <input class="submit" type="submit" name="submit" value="投稿" />
</form>
