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
		$b_produce_A[$i] = $result['produce_A'];
		$b_produce_B[$i] = $result['produce_B'];
		//---------------------------------------------------------------------------------------------------
	
	
		//實際生產量-------------------------------------------------------------------------------------------
		$temp = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$cid' AND `year`='$i' AND `product`='A'");
		$result = mysql_fetch_array($temp);
		$produce_A[$i] = $result[0];
		if($produce_A[$i] == ""){
			$produce_A[$i] = 0;
		}
		$temp = mysql_query("SELECT SUM(`batch`) FROM `product_history` WHERE `cid`='$cid' AND `year`='$i' AND `product`='B'");
		$result = mysql_fetch_array($temp);
		$produce_B[$i] = $result[0];
		if($produce_B[$i] == ""){
			$produce_B[$i] = 0;
		}
		//---------------------------------------------------------------------------------------------------
	
	
	
		//達成率-----------------------------------------------------------------------------------------------
		
		if($b_produce_A[$i] != 0){
			$produce_A_rate[$i] = ($produce_A[$i]*100) / $b_produce_A[$i];
		}
		else{
			$produce_A_rate[$i] = 0;
		}
		if($b_produce_B[$i] != 0){
			$produce_B_rate[$i] = ($produce_B[$i]*100) / $b_produce_B[$i];
		}
		else{
			$produce_B_rate[$i] = 0;
		}
		//---------------------------------------------------------------------------------------------------
		
		
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
    <td>產品A生產量</td>
    <td><?php echo $result['produce_A']; ?></td>
    <td><?php echo $produce_A[1]; ?></td>
    <td><?php echo number_format($produce_A_rate[1],2); ?>%</td>
    <td><?php echo $produce_A[2]; ?></td>
    <td><?php echo number_format($produce_A_rate[2],2); ?>%</td>
    <td><?php echo $produce_A[3]; ?></td>
    <td><?php echo number_format($produce_A_rate[3],2); ?>%</td>
    <td><?php echo $produce_A[4]; ?></td>
    <td><?php echo number_format($produce_A_rate[4],2); ?>%</td>
    <td><?php echo $produce_A[5]; ?></td>
    <td><?php echo number_format($produce_A_rate[5],2); ?>%</td>
  </tr>
  <tr>
    <td>產品B生產量</td>
    <td><?php echo $result['produce_B']; ?></td>
    <td><?php echo $produce_B[1]; ?></td>
    <td><?php echo number_format($produce_B_rate[1],2); ?>%</td>
    <td><?php echo $produce_B[2]; ?></td>
    <td><?php echo number_format($produce_B_rate[2],2); ?>%</td>
    <td><?php echo $produce_B[3]; ?></td>
    <td><?php echo number_format($produce_B_rate[3],2); ?>%</td>
    <td><?php echo $produce_B[4]; ?></td>
    <td><?php echo number_format($produce_B_rate[4],2); ?>%</td>
    <td><?php echo $produce_B[5]; ?></td>
    <td><?php echo number_format($produce_B_rate[5],2); ?>%</td>
  </tr>
</table>

</body>
</html>