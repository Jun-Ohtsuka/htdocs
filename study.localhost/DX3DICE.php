<?php
if(isset($_GET['dice']) && isset($_GET['skill']) &&
 isset($_GET['critical']) && isset($_GET['attack'])){
	 //ユーザーに入力してもらうデータ
	$diceCount = (int)$_GET['dice'];//判定ダイスの数
	$skillPoint = (int)$_GET['skill'];;//判定の技能値
	$critical = (int)$_GET['critical'];;//C値
	$attack = (int)$_GET['attack'];;//攻撃力固定値

	$roopCount = 0;

	while($diceCount > 0){
		$dice10Count = 0;
		if($roopCount > 0){
			$skillPoint +=10;
		};
	//	echo "RollCount(".$roopCount.") :";
		$diceset = array();
		for($i = 0; $i < $diceCount; $i++){
			$dice = mt_rand(1,10);
			$diceset[] = $dice;
	//		echo $dice.",";
			if($dice >= $critical){
				$dice10Count++;
			};
		};
		$diceCount = $dice10Count;
		$roopCount++;
	};

	$achieved = max($diceset) + $skillPoint;

	//echo "Achieved Value : " .$achieved;

	$attackDice = round($achieved/10);
	//echo " attack :" .$attack;
	//echo " attackDice :";
	for($i = 0; $i < $attackDice; $i++){
		$dice = mt_rand(1,10);
	//	echo $dice.",";
		$attack = $attack + $dice;
	};
};
//echo " FinalAttackPoint :".$attack."!";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>DX3ダイス計算</title>
</head>
<body>
  <?php if(isset($_GET['dice']) && isset($_GET['skill']) &&
	 isset($_GET['critical']) && isset($_GET['attack'])): ?>
    <p>達成値：<?php echo htmlspecialchars($achieved, ENT_QUOTES, 'UTF-8'); ?><br>
		ダメージ：<?php echo htmlspecialchars($attack, ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif?>

  <form action="DX3DICE.php" method="get">
    <p>
      判定で使用するダイスの数を半角で入力してください：
        <input type="text" name="dice" /><br>
			判定で使用する技能値を半角で入力してください：
				<input type="text" name="skill" /><br>
			クリティカル値を半角で入力してください：
        <input type="text" name="critical" /><br>
			攻撃力固定値を半角で入力してください：
				<input type="text" name="attack" /><br>
        <input type="submit" value="送信" />
    </p>
  </form>


</body>
</html>
