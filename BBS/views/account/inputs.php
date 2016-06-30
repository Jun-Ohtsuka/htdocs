
<table>
  <tbody>
    <tr>
      <th>ログインID</th>
      <td>
        <input type="text" name="account" value="<?php echo $this->escape($account); ?>" />
      </td>
    </tr>
    <tr>
      <th>名前</th>
      <td>
        <input type="text" name="user_name" value="<?php echo $this->escape($user_name); ?>" />
      </td>
    </tr>
    <tr>
      <th>パスワード</th>
      <td>
        <input type="password" name="password" value="" />
      </td>
    </tr>
    <tr>
      <th>確認用パスワード</th>
      <td>
        <input type="password" name="checkPassword" value="" />
      </td>
    </tr>
    <tr>
      <th>所属</th>
      <td>
        <select name="branch_id">
          <?php foreach($branchs as $branch): ?>
          <option value="<?php echo $this->escape($branch['id']); ?>"
            <?php if($branch['id'] == $branch_id){echo $this->escape("selected");} ?>><?php echo $this->escape($branch['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr>
    <tr>
      <th>部署･役職</th>
      <td>
        <select name="position_id">
          <?php foreach($positions as $position): ?>
          <option value="<?php echo $this->escape($position['id']); ?>"
            <?php if($position['id'] == $position_id){echo $this->escape("selected");} ?>><?php echo $this->escape($position['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </td>
    </tr>
  </tbody>
</table>
