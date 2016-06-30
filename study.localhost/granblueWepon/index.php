<?php
  require_once 'idiorm.php';
  ORM::configure('mysql:dbhost=localhost;dbname=granblue');
  ORM::configure('username', 'root');
  ORM::configure('password', 'artonelico');

  $wepons = ORM::for_table('wepons_types')
  ->find_array();
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
    <h1>武器一覧</h1>
  </div>
  <div id="navi">
    <a href="http://study.localhost/granblueWepon">ホーム</a>
    <a href="http://study.localhost/granblueWepon/newWepon.php">武器新規登録</a>
  </div>

  <div id="main">
    <table border="1px">
      <tr>
        <th>名前</th>
        <th>HP</th>
        <th>ATK</th>
        <th>属性</th>
        <th>skill1</th>
        <th>skill2</th>
        <th>skillLevel</th>
        <th>DELETE</th>
      </tr>
      <?php foreach ($wepons as $wepon) : ?>
        <tr>
          <td>
            <a href="http://study.localhost/granblueWepon/settingWepon.php?id=<?php echo $wepon['id']; ?>">
            <?php echo $wepon['name']; ?>
            </a>
          </td>
          <td><?php echo $wepon['hp']; ?></td>
          <td><?php echo $wepon['atk']; ?></td>
          <td><?php echo $wepon['type']; ?></td>
          <td>
          <?php switch($wepon['skill_id1']):
            case 1 : echo "通常攻刃大"; break;
            case 2 : echo "マグナ攻刃大"; break;
            case 3 : echo "UNK攻刃大"; break;
            case 4 : echo "通常守護大"; break;
            case 5 : echo "マグナ守護大"; break;
            case 6 : echo "UNK守護大"; break;
            case 7 : echo "バハ攻"; break;
            case 8 : echo "バハ攻/HP"; break;
            default : echo "なし"; break;
           endswitch; ?>
          </td>
          <td>
          <?php switch($wepon['skill_id2']):
            case 1 : echo "通常攻刃大"; break;
            case 2 : echo "マグナ攻刃大"; break;
            case 3 : echo "UNK攻刃大"; break;
            case 4 : echo "通常守護大"; break;
            case 5 : echo "マグナ守護大"; break;
            case 6 : echo "UNK守護大"; break;
            case 7 : echo "バハ攻"; break;
            case 8 : echo "バハ攻/HP"; break;
            default : echo "なし"; break;
           endswitch; ?>
          </td>
          <td><?php echo $wepon['skillLevel']; ?></td>
          <form action="Controller/WeponController.php" method="post">
            <input type="hidden" name="controller" value="delete" />
            <input type="hidden" name="id" value="<?php echo $wepon['id']; ?>" />
            <td><input type="submit" name="submit" value="delete"
               onclick = 'return confirm("[<?php echo $wepon['name']; ?>]を削除します。\nよろしいですか？");'/></td>
          </form>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
