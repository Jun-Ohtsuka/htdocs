<?php

//ユーザーに入力してもらうデータ
$diceCount = 24;//判定ダイスの数
$skillPoint = 6;//判定の技能値
$critical = 7;//C値
$attack = 75;//攻撃力固定値


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

echo "Achieved Value : " .$achieved;

$attackDice = round($achieved/10);
//echo " attack :" .$attack;
//echo " attackDice :";
for($i = 0; $i < $attackDice; $i++){
	$dice = mt_rand(1,10);
//	echo $dice.",";
	$attack = $attack + $dice;
};


echo " FinalAttackPoint :".$attack."!";



