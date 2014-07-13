<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/tableyellow.css" rel="stylesheet" type="text/css" />
</head>
<?php  
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	
	for($i=1;$i<6;$i++){
		
		//預算招聘人員數---------------------------------------------------------------------------------------------------
		
		$temp = mysql_query("SELECT SUM(`equip`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_equip[$i] = $result[0];
		if($b_equip[$i] == ""){
			$b_equip[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`human`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_human[$i] = $result[0];
		if($b_human[$i] == ""){
			$b_human[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`research`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_research[$i] = $result[0];
		if($b_research[$i] == ""){
			$b_research[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`sale`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_sale[$i] = $result[0];
		if($b_sale[$i] == ""){
			$b_sale[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`finance`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$i'");
		$result = mysql_fetch_array($temp);
		$b_finance[$i] = $result[0];
		if($b_finance[$i] == ""){
			$b_finance[$i] = 0;
		}
		//--------------------------------------------------------------------------------------------------------------
		
		
		
		//實際招聘人員數---------------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='equip'");
		$result = mysql_fetch_array($temp);
		$equip[$i] = $result[0];
		if($equip[$i] == ""){
			$equip[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='human'");
		$result = mysql_fetch_array($temp);
		$human[$i] = $result[0];
		if($human[$i] == ""){
			$human[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='research'");
		$result = mysql_fetch_array($temp);
		$research[$i] = $result[0]/5;
		if($research[$i] == ""){
			$research[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='sale'");
		$result = mysql_fetch_array($temp);
		$sale[$i] = $result[0];
		if($sale[$i] == ""){
			$sale[$i] = 0;
		}
		
		$temp = mysql_query("SELECT SUM(`hire_count`) FROM `current_people` WHERE `cid`='$cid' AND `year`='$i' AND `department`='finance'");
		$result = mysql_fetch_array($temp);
		$finance[$i] = $result[0];
		if($finance[$i] == ""){
			$finance[$i] = 0;
		}
	
	
		//--------------------------------------------------------------------------------------------------------------
	
	
		//達成率---------------------------------------------------------------------------------------------------------
		if($b_equip[$i] != 0){
			$equip_rate[$i] = ($equip[$i] * 100) / $b_equip[$i];
		}
		else{
			$equip_rate[$i] = 0;
		}
		
		if($b_human[$i] != 0){
			$human_rate[$i] = ($human[$i] * 100) / $b_human[$i];
		}
		else{
			$human_rate[$i] = 0;
		}
		
		if($b_research[$i] != 0){
			$research_rate[$i] = ($research[$i] * 100) / $b_research[$i];
		}
		else{
			$research_rate[$i] = 0;
		}
		
		if($b_sale[$i] != 0){
			$sale_rate[$i] = ($sale[$i] * 100) / $b_sale[$i];
		}
		else{
			$sale_rate[$i] = 0;
		}
		
		if($b_finance[$i] != 0){
			$finance_rate[$i] = ($finance[$i] * 100) / $b_finance[$i];
		}
		else{
			$finance_rate[$i] = 0;
		}
		//--------------------------------------------------------------------------------------------------------------
		
		
		
	}//end of for
	
	//當年-----------------------------------------------------------------------------------------------------------
	$temp = mysql_query("SELECT SUM(`equip`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$equip_now = $result[0];
	
	$temp = mysql_query("SELECT SUM(`human`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$human_now = $result[0];
	
	$temp = mysql_query("SELECT SUM(`research`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$research_now = $result[0];
	
	$temp = mysql_query("SELECT SUM(`sale`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$sale_now = $result[0];

	$temp = mysql_query("SELECT SUM(`finance`) FROM `budget_hire` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$finance_now = $result[0];
	
	
?>
<body>
<table width="995" border="1" cellpadding="5" class="ytable">
  <tr>
    <th scope="col" width="115" align="center">&nbsp;</th>
    <th scope="col" width="80" align="center">當年</th>
    <th scope="col" width="80" align="center">第一年</th>
    <th scope="col" width="80" align="center">達成率</th>
    <th scope="col" width="80" align="center">第二年</th>
    <th scope="col" width="80" align="center">達成率</th>
    <th scope="col" width="80" align="center">第三年</th>
    <th scope="col" width="80" align="center">達成率</th>
    <th scope="col" width="80" align="center">第四年</th>
    <th scope="col" width="80" align="center">達成率</th>
    <th scope="col" width="80" align="center">第五年</th>
    <th scope="col" width="80" align="center">達成率</th>
  </tr>
  <tr class="odd">
    <td align="center">生產人員</td>
    <td align="center"><?php echo number_format($equip_now); ?></td>
    <td align="center"><?php echo number_format($equip[1]); ?></td>
    <td align="center"><?php echo number_format($equip_rate[1],2); ?>%</td>
    <td align="center"><?php echo number_format($equip[2]); ?></td>
    <td align="center"><?php echo number_format($equip_rate[2],2); ?>%</td>
    <td align="center"><?php echo number_format($equip[3]); ?></td>
    <td align="center"><?php echo number_format($equip_rate[3],2); ?>%</td>
    <td align="center"><?php echo number_format($equip[4]); ?></td>
    <td align="center"><?php echo number_format($equip_rate[4],2); ?>%</td>
    <td align="center"><?php echo number_format($equip[5]); ?></td>
    <td align="center"><?php echo number_format($equip_rate[5],2); ?>%</td>
  </tr>
  <tr>
    <td align="center">行政人員</td>
    <td align="center"><?php echo number_format($human_now); ?></td>
    <td align="center"><?php echo number_format($human[1]); ?></td>
    <td align="center"><?php echo number_format($human_rate[1],2); ?>%</td>
    <td align="center"><?php echo number_format($human[2]); ?></td>
    <td align="center"><?php echo number_format($human_rate[2],2); ?>%</td>
    <td align="center"><?php echo number_format($human[3]); ?></td>
    <td align="center"><?php echo number_format($human_rate[3],2); ?>%</td>
    <td align="center"><?php echo number_format($human[4]); ?></td>
    <td align="center"><?php echo number_format($human_rate[4],2); ?>%</td>
    <td align="center"><?php echo number_format($human[5]); ?></td>
    <td align="center"><?php echo number_format($human_rate[5],2); ?>%</td>
  </tr>
  <tr class="odd">
    <td align="center">研發團隊</td>
    <td align="center"><?php echo number_format($research_now); ?></td>
    <td align="center"><?php echo number_format($research[1]); ?></td>
    <td align="center"><?php echo number_format($research_rate[1],2); ?>%</td>
    <td align="center"><?php echo number_format($research[2]); ?></td>
    <td align="center"><?php echo number_format($research_rate[2],2); ?>%</td>
    <td align="center"><?php echo number_format($research[3]); ?></td>
    <td align="center"><?php echo number_format($research_rate[3],2); ?>%</td>
    <td align="center"><?php echo number_format($research[4]); ?></td>
    <td align="center"><?php echo number_format($research_rate[4],2); ?>%</td>
    <td align="center"><?php echo number_format($research[5]); ?></td>
    <td align="center"><?php echo number_format($research_rate[5],2); ?>%</td>
  </tr>
  <tr>
    <td align="center">業務人員</td>
    <td align="center"><?php echo number_format($sale_now); ?></td>
    <td align="center"><?php echo number_format($sale[1]); ?></td>
    <td align="center"><?php echo number_format($sale_rate[1],2); ?>%</td>
    <td align="center"><?php echo number_format($sale[2]); ?></td>
    <td align="center"><?php echo number_format($sale_rate[2],2); ?>%</td>
    <td align="center"><?php echo number_format($sale[3]); ?></td>
    <td align="center"><?php echo number_format($sale_rate[3],2); ?>%</td>
    <td align="center"><?php echo number_format($sale[4]); ?></td>
    <td align="center"><?php echo number_format($sale_rate[4],2); ?>%</td>
    <td align="center"><?php echo number_format($sale[5]); ?></td>
    <td align="center"><?php echo number_format($sale_rate[5],2); ?>%</td>
  </tr>
  <tr class="odd">
    <td align="center">財務人員</td>
    <td align="center"><?php echo number_format($finance_now); ?></td>
    <td align="center"><?php echo number_format($finance[1]); ?></td>
    <td align="center"><?php echo number_format($finance_rate[1],2); ?>%</td>
    <td align="center"><?php echo number_format($finance[2]); ?></td>
    <td align="center"><?php echo number_format($finance_rate[2],2); ?>%</td>
    <td align="center"><?php echo number_format($finance[3]); ?></td>
    <td align="center"><?php echo number_format($finance_rate[3],2); ?>%</td>
    <td align="center"><?php echo number_format($finance[4]); ?></td>
    <td align="center"><?php echo number_format($finance_rate[4],2); ?>%</td>
    <td align="center"><?php echo number_format($finance[5]); ?></td>
    <td align="center"><?php echo number_format($finance_rate[5],2); ?>%</td>
  </tr>
</table>

</body>
</html>