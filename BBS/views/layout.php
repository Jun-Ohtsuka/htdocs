<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href = "/css/style.css" rel = "stylesheet" type = "text/css">
  <title><?php if(isset($title)): echo $this->escape($title) .' - ';
endif; ?>BBS</title>
</head>
<body>
  <div id="header">
    <h1>BBS</h1>
    <?php if($session->isAuthenticated()): ?>
      <?php $loginUser = $_SESSION['loginUser'];
        echo "ログイン中：{$loginUser['name']}"; ?>
      <?php endif;?>
    <div id="nav">
      <a href="<?php echo $base_url; ?>/">ホーム</a>
    </div>
  </div>

  <div id="main">
    <?php echo $_content; ?>
  </div>
</body>
</html>
