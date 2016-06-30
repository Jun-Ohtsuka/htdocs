<table class="thread" border="1" cellspacing="0">
  <form action="<?php echo $base_url; ?>/home/threadDelete" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
    <input type="hidden" name="thread_id" value="<?php echo $this->escape($thread['thread_id']); ?>" />
    <tr>
      <th class="thread">Name ： <?php echo $this->escape($thread['name']); ?>　
        投稿日時 ： <?php $date = date('Y/m/d H:i:s', strtotime($thread['insert_date'])); echo $this->escape($date); ?>
        <input class = "delete-button" type = "submit" name = "submit" value = "この投稿を削除する"
            onclick = 'return confirm("<?php echo "{$date}に投稿された[{$thread['name']}]の投稿を削除します。" ?>\n本当に削除してよろしいですか？");'/>
      </th>
    </tr>
  </form>
  <tr>
    <td class="title">件名 ： <?php echo $this->escape($thread['title']); ?></td>
  </tr>
  <tr>
    <td>カテゴリー ： <?php echo $this->escape($thread['category']); ?></td>
  </tr>
  <tr>
    <td class="text"><pre><?php echo $this->escape($thread['text']); ?></pre></td>
  </tr>
  <tr>
    <td class="comment">
        <?php foreach($comments as $comment): ?>
          <?php if($comment['thread_id'] == $thread['thread_id']): ?>
            <form action="home/commentDelete" method="post">
              <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
              <input type="hidden" name="comment_id" value="<?php echo $this->escape($comment['comment_id']); ?>" />
              <div class = "comment-date">Name : <?php echo $this->escape($comment['name']); ?>
                　投稿日時 : <?php $date = date('Y/m/d H:i:s', strtotime($comment['insert_date'])); echo $this->escape($date); ?>
                <?php if(($loginUser['id'] == $comment['user_id']) || ($loginUser['position_id'] == 2) ||
                    (($loginUser['position_id'] == 3) && ($loginUser['branch_id'] == $comment['user_branch_id']))): ?>
                  <input class = "delete-button" type = "submit" name = "submit" value = "このコメントを削除する"
                      onclick = 'return confirm("<?php echo "{$date}に投稿された[{$comment['name']}]のコメントを削除します。" ?>\n本当に削除してよろしいですか？");'/>
                <?php endif; ?>
              </div>
              <pre class="comment-text"><?php echo $this->escape($comment['text']); ?></pre>
            </form>
          <?php endif; ?>
        <?php endforeach; ?>

      <form class="comment-area" action="<?php echo $base_url; ?>/home/post" method="post">
        <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
        <input type="hidden" name="thread_id" value="<?php echo $this->escape($thread['thread_id']); ?>" />
        コメント：（コメントは500文字まで）<br />
        <textarea name="text" cols="100" rows="5"></textarea>
        <input id="comment_submit" type="submit" value="コメントする" />
      </form>
    </td>
  </tr>
</table>
