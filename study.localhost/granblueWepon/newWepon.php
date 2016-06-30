<?php
  require_once 'idiorm.php';
  ORM::configure('mysql:dbhost=localhost;dbname=granblue');
  ORM::configure('username', 'root');
  ORM::configure('password', 'artonelico');

  $skills = ORM::for_table('skills')->find_array();
  $types = ORM::for_table('types')->find_array();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href = "/css/style.css" rel = "stylesheet" type = "text/css">
  <title>グラブル計算</title>
</head>
<body>
  <div id="header">
    <h1>武器新規登録</h1>
  </div>
  <div id="navi">
    <a href="http://study.localhost/granblueWepon">ホーム</a>
  </div>

  <div id="main">
    <form action="controller/WeponController.php" method="post">
      <input type="hidden" name="controller" value="insert" />
      <table>
        <tr>
          <td>名前：<input type="text" name="name" /></td>
        </tr>
        <tr>
          <td>HP：<input type="number" name="hp" /></td>
        </tr>
        <tr>
          <td>ATK:<input type="number" name="atk" /></td>
        </tr>
        <tr>
          <td>属性:
            <select name="type_id">
              <?php foreach ($types as $type): ?>
                <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>スキル1:
            <select name="skill_id1">
              <option value="0">なし</option>
              <?php foreach ($skills as $skill): ?>
                <option value="<?php echo $skill['id']; ?>"><?php echo $skill['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>スキル2:
            <select name="skill_id2">
              <option value="0">なし</option>
              <?php foreach ($skills as $skill): ?>
                <option value="<?php echo $skill['id']; ?>"><?php echo $skill['name']; ?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>スキルレベル:<input type="number" name="skillLevel" min="0" max="10" value="0"/></td>
        </tr>
        <tr>
          <td><input type="submit" name="submit" value="登録" /></td>
        </tr>
      </table>
    </form>
  </div>
</body>
</html>
