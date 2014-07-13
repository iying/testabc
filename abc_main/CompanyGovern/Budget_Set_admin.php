<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/tableyellow.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<?php	
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	
	$temp = mysql_query("SELECT MAX(`product_A_RD`) FROM `state`  WHERE `cid`='$cid'");
	$result = mysql_fetch_array($temp);
	$rd_A = $result[0];
	
	$temp = mysql_query("SELECT MAX(`product_B_RD`) FROM `state`  WHERE `cid`='$cid'");
	$result = mysql_fetch_array($temp);
	$rd_B = $result[0];
	
	/*
	$temp = mysql_query("SELECT SUM(`price`) FROM `operating_revenue` WHERE `cid`='$cid' AND `month`<=($year-1)*12 AND `month` > ($year-2)*12");
	$result = mysql_fetch_array($temp);
	$total_revenue = $result[0];
	if($total_revenue == ""){
		$total_revenue = 0;
	}*/
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	$total_revenue = ($result['sell_A']*20000) + ($result['sell_B']*15000);
	if($result['produce_A'] > $result['produce_B']){
		$Recom_equip = $result['produce_A'] / 200;
	}
	else{
		$Recom_equip = $result['produce_B'] / 200;
	}
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='finan_load2'");
	$result = mysql_fetch_array($temp);
	$finan_load2 = $result[0];
	$Recom_finan = ($total_revenue / 12) / ($finan_load2 * 1000);
	
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='research_load2'");
	$result = mysql_fetch_array($temp);
	$research_load2 = $result[0];
	$Recom_research = ($total_revenue / 12) / ($research_load2 * 1000);
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='sale_load2'");
	$result = mysql_fetch_array($temp);
	$sale_load2 = $result[0];
	$Recom_sale = ($total_revenue / 12) / ($sale_load2 * 1000);
	
	$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='human_load2'");
	$result = mysql_fetch_array($temp);
	$human_load2 = $result[0];
	$Recom_human = ($total_revenue / 12) / ($human_load2 * 1000);
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	
?>
<body>
	<div id="admin" align="center">
        
        <table width="1050" border="1" cellpadding="5" class="ytable">
          <tr>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">筆記型電腦</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">平板電腦</th>
          </tr>
          <tr>
            <td>產品研發</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="RD_A" type="checkbox" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="RD_B" type="checkbox" /></td>
          </tr>
          <tr>
            <th>&nbsp;</th>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <th>購置資產</th>
            <td>&nbsp;</td>
            <td>切割原料機具</td>
            <td>&nbsp;</td>
            <td>第一層組裝機具</td>
            <td>&nbsp;</td>
            <td>第二層組裝機具</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>A (600,000 / 每台)</td>
            <td><input id="p_mc_A" style="text-align:center" value="<?php echo $result['p_mc_A']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>A (700,000 / 每台)</td>
            <td><input id="p_m1_A" style="text-align:center" value="<?php echo $result['p_m1_A']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>A (1,000,000 / 每台)</td>
            <td><input id="p_m2_A" style="text-align:center" value="<?php echo $result['p_m2_A']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>B (500,000 / 每台)</td>
            <td><input id="p_mc_B" style="text-align:center" value="<?php echo $result['p_mc_B']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>B (600,000 / 每台)</td>
            <td><input id="p_m1_B" style="text-align:center" value="<?php echo $result['p_m1_B']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>B (900,000 / 每台)</td>
            <td><input id="p_m2_B" style="text-align:center" value="<?php echo $result['p_m2_B']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>C (400,000 / 每台)</td>
            <td><input id="p_mc_C" style="text-align:center" value="<?php echo $result['p_mc_C']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>C (500,000 / 每台)</td>
            <td><input id="p_m1_C" style="text-align:center" value="<?php echo $result['p_m1_C']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>C (800,000 / 每台)</td>
            <td><input id="p_m2_C" style="text-align:center" value="<?php echo $result['p_m2_C']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>合格檢測機具</td>
            <td>1,000,000 / 每台</td>
            <td><input id="p_mcheck" style="text-align:center" value="<?php echo $result['p_mcheck']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
            <td>精密檢測機具</td>
            <td>1,500,000 / 每台</td>
            <td><input id="p_mchecks" style="text-align:center" value="<?php echo $result['p_mchecks']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>資金募集</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="fund_raising" style="text-align:center" value="<?php echo $result['fund_raising']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>發放現金股利</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="cash_divide" style="text-align:center" value="<?php echo $result['cash_divide']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>短期借款</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="S_borrow" style="text-align:center" value="<?php echo $result['S_borrow']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
          <tr>
            <td>長期借款</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="L_borrow" style="text-align:center" value="<?php echo $result['L_borrow']; ?>" width="10" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" value="0"></td>
          </tr>
        </table>

    </div>
    <div align="center" style="height:150px">
    	<input id="sub" type="image" src="../images/submit.png" />
    </div>
    <script type="text/javascript">
	
		var rd_A = 0 , rd_B = 0;
		var p_mc_A = p_mc_B = p_mc_C = p_m1_A = p_m1_B = p_m1_C = p_m2_A = p_m2_B = p_m2_C = p_mcheck = p_mchecks = 0;
		var func_raising = cash_divide = S_borrow = L_borrow = 0;
		
        $(document).ready(function(){
			if(<?php echo $result['rd_A'] ?> == 1){
				document.getElementById("RD_A").checked = true;
			}
			if(<?php echo $result['rd_B'] ?> == 1){
				document.getElementById("RD_B").checked = true;
			}
            if(<?php echo $rd_A ?> == 1){
				document.getElementById("RD_A").checked = true;
				document.getElementById("RD_A").disabled = true;
			}
			if(<?php echo $rd_B ?> == 1){
				document.getElementById("RD_B").checked = true;
				document.getElementById("RD_B").disabled = true;
			}
			$("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					
					if(document.getElementById("RD_A").checked == true){
						rd_A = 1;
					}
					if(document.getElementById("RD_B").checked == true){
						rd_B = 1;
					}
					p_mc_A = document.getElementById("p_mc_A").value;
					p_mc_B = document.getElementById("p_mc_B").value;
					p_mc_C = document.getElementById("p_mc_C").value;
					p_m1_A = document.getElementById("p_m1_A").value;
					p_m1_B = document.getElementById("p_m1_B").value;
					p_m1_C = document.getElementById("p_m1_C").value;
					p_m2_A = document.getElementById("p_m2_A").value;
					p_m2_B = document.getElementById("p_m2_B").value;
					p_m2_C = document.getElementById("p_m2_C").value;
					p_mcheck = document.getElementById("p_mcheck").value;
					p_mchecks = document.getElementById("p_mchecks").value;
					fund_raising = document.getElementById("fund_raising").value;
					cash_divide = document.getElementById("cash_divide").value;
					S_borrow = document.getElementById("S_borrow").value;
					L_borrow = document.getElementById("L_borrow").value;
					
					
					$.ajax({
						url:"Budget_DB.php",
						type:"GET",
						dataType:"html",
						data:"type=admin&rd_A="+rd_A+"&rd_B="+rd_B+"&p_mc_A="+p_mc_A+"&p_mc_B="+p_mc_B+"&p_mc_C="+p_mc_C+"&p_m1_A="+p_m1_A+"&p_m1_B="+p_m1_B+"&p_m1_C="+p_m1_C+"&p_m2_A="+p_m2_A+"&p_m2_B="+p_m2_B+"&p_m2_C="+p_m2_C+"&p_mcheck="+p_mcheck+"&p_mchecks="+p_mchecks+"&fund_raising="+fund_raising+"&cash_divide="+cash_divide+"&S_borrow="+S_borrow+"&L_borrow="+L_borrow
						,
						error: function(){
							alert("fail");
							
						},
						success: function(){
							alert("success");
						}
					});
				}
				else{
					alert("每年一月才能進行編製");
				}
			});
        });//end of ready
		
		function addCommas(nStr){
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
    </script>
</body>
</html>