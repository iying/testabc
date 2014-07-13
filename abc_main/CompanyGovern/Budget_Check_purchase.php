<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/tableyellow.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php  
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	
	for($i=1;$i<6;$i++){
		
		//預算------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_purchase_p[$i] = $result['purchase_p'];
		$b_purchase_k[$i] = $result['purchase_k'];
		$b_purchase_kb[$i] = $result['purchase_kb'];
		
		//---------------------------------------------------------------------------------------------------
	
	
		//實際購買量-------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$ma1 = $result[0];
		if($ma1 == ""){
			$ma1 = 0;
		}
		$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$ma2 = $result[0];
		if($ma2 == ""){
			$ma2 = 0;
		}
		$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$ma3 = $result[0];
		if($ma3 == ""){
			$ma3 = 0;
		}
		$purchase_p[$i] = $ma1 + $ma2 + $ma3;
		if($purchase_p[$i] == ""){
			$purchase_p[$i] = 0;
		}
		
		
		$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mb1 = $result[0];
		if($mb1 == ""){
			$mb1 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mb2 = $result[0];
		if($mb2 == ""){
			$mb2 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mb3 = $result[0];
		if($mb3 == ""){
			$mb3 = 0;
		}
		$purchase_k[$i] = $mb1 + $mb2 + $mb3;
		
		$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mc1 = $result[0];
		if($mc1 == ""){
			$mc1 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mc2 = $result[0];
		if($mc2 == ""){
			$mc2 = 0;
		}
		$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$mc3 = $result[0];
		if($mc3 == ""){
			$mc3 = 0;
		}
		$purchase_kb[$i] = $mc1 + $mc2 + $mc3;
		
		//----------------------------------------------------------------------------------------------------
	
	
	
	
		//達成率-----------------------------------------------------------------------------------------------
		if($b_purchase_p[$i] != 0){
		$purchase_p_rate[$i] = ($purchase_p[$i]*100) / $b_purchase_p[$i];
		}
		else{
			$purchase_p_rate[$i] = 0;
		}
		if($b_purchase_k[$i] != 0){
			$purchase_k_rate[$i] = ($purchase_k[$i]*100) / $b_purchase_k[$i];
		}
		else{
			$purchase_k_rate[$i] = 0;
		}
		if($b_purchase_kb[$i] != 0){
			$purchase_kb_rate[$i] = ($purchase_kb[$i]*100) / $b_purchase_kb[$i];
		}
		else{
			$purchase_kb_rate[$i] = 0;
		}
		
		
		//----------------------------------------------------------------------------------------------------
		
		
	}
	
	
	
	
	//當年------------------------------------------------------------------------------------------------
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);

?>
<table class="ytable" width="995" border="1" cellpadding="5" align="center">
  <tr>
    <th scope="col" width="115">&nbsp;</th>
    <th scope="col" width="80">當年</th>
    <th scope="col" width="80">第一年</th>
    <th scope="col" width="80">達成率</th>
    <th scope="col" width="80">第二年</th>
    <th scope="col" width="80">達成率</th>
    <th scope="col" width="80">第三年</th>
    <th scope="col" width="80">達成率</th>
    <th scope="col" width="80">第四年</th>
    <th scope="col" width="80">達成率</th>
    <th scope="col" width="80">第五年</th>
    <th scope="col" width="80">達成率</th>
  </tr>
  <tr>
    <td>面板購買量</td>
    <td><?php echo $result['purchase_p']; ?></td>
    <td><?php echo $purchase_p[1]; ?></td>
    <td><?php echo number_format($purchase_p_rate[1],2); ?>%</td>
    <td><?php echo $purchase_p[2]; ?></td>
    <td><?php echo number_format($purchase_p_rate[2],2); ?>%</td>
    <td><?php echo $purchase_p[3]; ?></td>
    <td><?php echo number_format($purchase_p_rate[3],2); ?>%</td>
    <td><?php echo $purchase_p[4]; ?></td>
    <td><?php echo number_format($purchase_p_rate[4],2); ?>%</td>
    <td><?php echo $purchase_p[5]; ?></td>
    <td><?php echo number_format($purchase_p_rate[5],2); ?>%</td>
  </tr>
  <tr>
    <td>核心購買量</td>
    <td><?php echo $result['purchase_k']; ?></td>
    <td><?php echo $purchase_k[1]; ?></td>
    <td><?php echo number_format($purchase_k_rate[1],2); ?>%</td>
    <td><?php echo $purchase_k[2]; ?></td>
    <td><?php echo number_format($purchase_k_rate[2],2); ?>%</td>
    <td><?php echo $purchase_k[3]; ?></td>
    <td><?php echo number_format($purchase_k_rate[3],2); ?>%</td>
    <td><?php echo $purchase_k[4]; ?></td>
    <td><?php echo number_format($purchase_k_rate[4],2); ?>%</td>
    <td><?php echo $purchase_k[5]; ?></td>
    <td><?php echo number_format($purchase_k_rate[5],2); ?>%</td>
  </tr>
  <tr>
    <td>鍵盤購買量</td>
    <td><?php echo $result['purchase_kb']; ?></td>
    <td><?php echo $purchase_kb[1]; ?></td>
    <td><?php echo number_format($purchase_kb_rate[1],2); ?>%</td>
    <td><?php echo $purchase_kb[2]; ?></td>
    <td><?php echo number_format($purchase_kb_rate[2],2); ?>%</td>
    <td><?php echo $purchase_kb[3]; ?></td>
    <td><?php echo number_format($purchase_kb_rate[3],2); ?>%</td>
    <td><?php echo $purchase_kb[4]; ?></td>
    <td><?php echo number_format($purchase_kb_rate[4],2); ?>%</td>
    <td><?php echo $purchase_kb[5]; ?></td>
    <td><?php echo number_format($purchase_kb_rate[5],2); ?>%</td>
  </tr>
</table>

</body>
</html>